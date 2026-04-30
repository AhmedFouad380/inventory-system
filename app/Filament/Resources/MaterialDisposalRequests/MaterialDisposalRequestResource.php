<?php

namespace App\Filament\Resources\MaterialDisposalRequests;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;


use App\Filament\Resources\MaterialDisposalRequests\Pages\CreateMaterialDisposalRequest;
use App\Filament\Resources\MaterialDisposalRequests\Pages\EditMaterialDisposalRequest;
use App\Filament\Resources\MaterialDisposalRequests\Pages\ListMaterialDisposalRequests;
use App\Filament\Resources\MaterialDisposalRequests\Pages\ViewMaterialDisposalRequest;
use App\Models\MaterialDisposalRequest;
use App\Models\WorkOrderStock;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
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

class MaterialDisposalRequestResource extends Resource
{
    protected static ?string $model = MaterialDisposalRequest::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedTrash;

    public static function getNavigationGroup(): ?string { return __('inventory.nav.operations'); }

    protected static ?string $recordTitleAttribute = 'mdr_number';

    public static function getModelLabel(): string { return __('inventory.mdr'); }
    public static function getPluralModelLabel(): string { return __('inventory.mdrs'); }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('inventory.mdr'))
                    ->schema([
                        TextInput::make('mdr_number')->label(__('inventory.fields.mdr_number'))
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('warehouse_id')->label(__('inventory.warehouse'))
                            ->searchable()->preload()->relationship('warehouse', 'name')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved')
                            ->live(),
                        Select::make('work_order_id')->label(__('inventory.work_order'))
                            ->searchable()->preload()->relationship('workOrder', 'wo_number')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved')
                            ->live(),
                        DatePicker::make('mdr_date')->label(__('inventory.fields.mdr_date'))
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('disposal_reason')->label(__('inventory.fields.disposal_reason'))
                            ->options([
                                \App\Models\MaterialDisposalRequest::REASON_DAMAGED => __('inventory.enums.disposal_reason.damaged'),
                                \App\Models\MaterialDisposalRequest::REASON_SCRAP => __('inventory.enums.disposal_reason.scrap'),
                                \App\Models\MaterialDisposalRequest::REASON_EXPIRED => __('inventory.enums.disposal_reason.expired'),
                                \App\Models\MaterialDisposalRequest::REASON_EXCESS => __('inventory.enums.disposal_reason.excess'),
                            ])
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('disposal_method')->label(__('inventory.fields.disposal_method'))
                            ->options([
                                'destruction' => __('inventory.enums.disposal_method.destruction'),
                                'scrap_sale' => __('inventory.enums.disposal_method.scrap_sale'),
                                'recycling' => __('inventory.enums.disposal_method.recycling'),
                                'other' => __('inventory.enums.disposal_method.other'),
                            ])
                            ->searchable()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('status')->label(__('inventory.fields.status'))
                            ->options([
                                'draft' => __('inventory.enums.status.draft'),
                                'approved' => __('inventory.enums.status.approved'),
                            ])
                            ->required()
                            ->default('draft')
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('approved_by')->label(__('inventory.fields.approved_by'))
                            ->searchable()->preload()->relationship('approvedBy', 'name')
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        DateTimePicker::make('approved_at')->label(__('inventory.fields.issued_at'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Textarea::make('notes')->label(__('inventory.fields.notes'))
                            ->columnSpanFull()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                    ])->columns(2),

                Section::make(__('inventory.items'))
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('item_id')->label(__('inventory.item'))
                                    ->required()
                                    ->columnSpan(2)
                                    ->options(function (Get $get) {
                                        $workOrderId = $get('../../work_order_id');
                                        $warehouseId = $get('../../warehouse_id');
                                        if (!$workOrderId || !$warehouseId) return [];
                                        
                                        return WorkOrderStock::where('work_order_id', $workOrderId)
                                            ->where('warehouse_id', $warehouseId)
                                            ->where('balance', '>', 0)
                                            ->join('items', 'items.id', '=', 'work_order_stocks.item_id')
                                            ->pluck('items.name', 'items.id');
                                    })
                                    ->live()
                                    ->disabled(fn ($record) => $record?->status === 'approved'),
                                TextInput::make('qty_disposed')->label(__('inventory.fields.qty'))
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(1)
                                    ->hint(function (Get $get) {
                                        $itemId = $get('item_id');
                                        $workOrderId = $get('../../work_order_id');
                                        $warehouseId = $get('../../warehouse_id');
                                        if (!$itemId || !$workOrderId || !$warehouseId) return null;
                                        
                                        $stock = WorkOrderStock::where('work_order_id', $workOrderId)
                                            ->where('warehouse_id', $warehouseId)
                                            ->where('item_id', $itemId)
                                            ->first();
                                        
                                        $available = __('inventory.fields.available');
                                        return $stock ? "{$available}: {$stock->balance}" : null;
                                    })
                                    ->disabled(fn ($record) => $record?->status === 'approved'),
                                TextInput::make('notes')->label(__('inventory.fields.notes'))
                                    ->columnSpan(3)
                                    ->disabled(fn ($record) => $record?->status === 'approved'),
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
                Section::make(__('inventory.mdr'))
                    ->schema([
                        TextEntry::make('mdr_number')->label(__('inventory.fields.mdr_number')),
                        TextEntry::make('warehouse.name')->label(__('inventory.warehouse')),
                        TextEntry::make('workOrder.wo_number')->label(__('inventory.work_order')),
                        TextEntry::make('mdr_date')->label(__('inventory.fields.mdr_date'))->date(),
                        TextEntry::make('status')->label(__('inventory.fields.status')),
                        TextEntry::make('notes')->label(__('inventory.fields.notes'))->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('mdr_number')
            ->columns([
                TextColumn::make('mdr_number')->label(__('inventory.fields.mdr_number'))->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))->searchable(),
                TextColumn::make('workOrder.wo_number')->label(__('inventory.work_order'))->searchable(),
                TextColumn::make('mdr_date')->label(__('inventory.fields.mdr_date'))->date()->sortable(),
                TextColumn::make('status')->label(__('inventory.fields.status'))->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->hidden(fn ($record) => $record?->status === 'approved'),
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
            'index' => ListMaterialDisposalRequests::route('/'),
            'create' => CreateMaterialDisposalRequest::route('/create'),
            'view' => ViewMaterialDisposalRequest::route('/{record}'),
            'edit' => EditMaterialDisposalRequest::route('/{record}/edit'),
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
