<?php

namespace App\Filament\Resources\MaterialReceiptNotes;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Section;


use App\Filament\Resources\MaterialReceiptNotes\Pages\CreateMaterialReceiptNote;
use App\Filament\Resources\MaterialReceiptNotes\Pages\EditMaterialReceiptNote;
use App\Filament\Resources\MaterialReceiptNotes\Pages\ListMaterialReceiptNotes;
use App\Filament\Resources\MaterialReceiptNotes\Pages\ViewMaterialReceiptNote;
use App\Filament\Resources\MaterialReceiptNotes\RelationManagers;
use App\Models\MaterialReceiptNote;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialReceiptNoteResource extends Resource
{
    protected static ?string $model = MaterialReceiptNote::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    public static function getNavigationGroup(): ?string { return __('inventory.nav.operations'); }

    protected static ?string $recordTitleAttribute = 'mrn_number';

    public static function getModelLabel(): string { return __('inventory.mrn'); }
    public static function getPluralModelLabel(): string { return __('inventory.mrns'); }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('inventory.mrn'))
                    ->schema([
                        TextInput::make('mrn_number')->label(__('inventory.fields.mrn_number'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->default(fn () => str_pad((int) (\App\Models\MaterialReceiptNote::max('id') ?? 0) + 1, 5, '0', STR_PAD_LEFT))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('warehouse_id')->label(__('inventory.warehouse'))
                            ->searchable()->preload()->relationship('warehouse', 'name')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('work_order_id')->label(__('inventory.work_order'))
                            ->searchable()->preload()->relationship('workOrder', 'wo_number')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('supplier_id')->label(__('inventory.supplier'))
                            ->relationship('supplier', 'name')
                            ->searchable()->preload()
                            ->disabled(fn ($record) => $record?->status === 'approved')
                            ->dehydrated(true),
                        DatePicker::make('mrn_date')->label(__('inventory.fields.mrn_date'))
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        TextInput::make('delivery_note_ref')->label(__('inventory.fields.delivery_note_ref'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        TextInput::make('vehicle_number')->label(__('inventory.fields.vehicle_number'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        TextInput::make('contract_ref')->label(__('inventory.fields.contract_ref'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('status')->label(__('inventory.fields.status'))
                            ->options([
                                'draft' => __('inventory.enums.status.draft'),
                                'approved' => __('inventory.enums.status.approved'),
                            ])
                            ->required()
                            ->default('draft')
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('warehouse_keeper_id')
                            ->label(__('inventory.fields.warehouse_keeper'))
                            ->searchable()
                            ->preload()
                            ->relationship('warehouseKeeper', 'name')
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('approved_by')
                            ->label(__('inventory.fields.approved_by'))
                            ->searchable()
                            ->preload()
                            ->relationship('approvedBy', 'name')
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        DateTimePicker::make('approved_at')->label(__('inventory.fields.issued_at'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Textarea::make('notes')->label(__('inventory.fields.notes'))
                            ->columnSpanFull()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                    ])->columns(2)->columnSpanFull(),

                Section::make(__('inventory.items'))
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('item_id')->label(__('inventory.item'))
                                    ->searchable()->preload()->relationship('item', 'name')
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('qty_received')->label(__('inventory.fields.qty'))
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(1),
                                TextInput::make('notes')->label(__('inventory.fields.notes'))
                                    ->columnSpan(3),
                            ])
                            ->columns(6)
                            ->defaultItems(1)
                            ->label(__('inventory.items'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                    ])->columnSpanFull(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('inventory.mrn'))
                    ->schema([
                        TextEntry::make('mrn_number')->label(__('inventory.fields.mrn_number')),
                        TextEntry::make('warehouse.name')->label(__('inventory.warehouse')),
                        TextEntry::make('workOrder.wo_number')->label(__('inventory.work_order')),
                        TextEntry::make('supplier.name')->label(__('inventory.supplier')),
                        TextEntry::make('mrn_date')->label(__('inventory.fields.mrn_date'))->date(),
                        TextEntry::make('delivery_note_ref')->label(__('inventory.fields.delivery_note_ref')),
                        TextEntry::make('vehicle_number')->label(__('inventory.fields.vehicle_number')),
                        TextEntry::make('contract_ref')->label(__('inventory.fields.contract_ref')),
                        TextEntry::make('status')->label(__('inventory.fields.status')),
                        TextEntry::make('preparedBy.name')->label(__('inventory.fields.prepared_by')),
                        TextEntry::make('warehouseKeeper.name')->label(__('inventory.fields.warehouse_keeper')),
                        TextEntry::make('approvedBy.name')->label(__('inventory.fields.approved_by')),
                        TextEntry::make('approved_at')->label(__('inventory.fields.issued_at'))->dateTime(),
                        TextEntry::make('notes')->label(__('inventory.fields.notes'))->columnSpanFull(),
                        TextEntry::make('createdBy.name')->label(__('inventory.fields.created_by')),
                        TextEntry::make('created_at')->dateTime(),
                        TextEntry::make('updated_at')->dateTime(),
                        TextEntry::make('deleted_at')
                            ->dateTime()
                            ->visible(fn ($record): bool => $record?->trashed() ?? false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('mrn_number')
            ->columns([
                TextColumn::make('mrn_number')->label(__('inventory.fields.mrn_number'))
                    ->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))
                    ->searchable(),
                TextColumn::make('workOrder.wo_number')->label(__('inventory.work_order'))
                    ->searchable(),
                TextColumn::make('supplier.name')->label(__('inventory.supplier'))
                    ->searchable(),
                TextColumn::make('mrn_date')->label(__('inventory.fields.mrn_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('status')->label(__('inventory.fields.status'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->hidden(fn ($record) => $record?->status === 'approved'),
                DeleteAction::make()->hidden(fn ($record) => $record?->status === 'approved'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaterialReceiptNotes::route('/'),
            'create' => CreateMaterialReceiptNote::route('/create'),
            'view' => ViewMaterialReceiptNote::route('/{record}'),
            'edit' => EditMaterialReceiptNote::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
