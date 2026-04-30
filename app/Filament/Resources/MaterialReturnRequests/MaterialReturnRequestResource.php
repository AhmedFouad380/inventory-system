<?php

namespace App\Filament\Resources\MaterialReturnRequests;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;


use App\Filament\Resources\MaterialReturnRequests\Pages\CreateMaterialReturnRequest;
use App\Filament\Resources\MaterialReturnRequests\Pages\EditMaterialReturnRequest;
use App\Filament\Resources\MaterialReturnRequests\Pages\ListMaterialReturnRequests;
use App\Filament\Resources\MaterialReturnRequests\Pages\ViewMaterialReturnRequest;
use App\Models\MaterialReturnRequest;
use App\Models\WorkOrderStock;
use App\Models\MaterialReceiptNote;
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

class MaterialReturnRequestResource extends Resource
{
    protected static ?string $model = MaterialReturnRequest::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedArrowPath;

    public static function getNavigationGroup(): ?string { return __('inventory.nav.operations'); }

    protected static ?string $recordTitleAttribute = 'mrr_number';

    public static function getModelLabel(): string { return __('inventory.mrr'); }
    public static function getPluralModelLabel(): string { return __('inventory.mrrs'); }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('inventory.mrr'))
                    ->schema([
                        TextInput::make('mrr_number')->label(__('inventory.fields.mrr_number'))
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
                            ->live()
                            ->afterStateUpdated(function (\Filament\Schemas\Components\Utilities\Set $set, $state) {
                                if (!$state) {
                                    $set('supplier_id', null);
                                    return;
                                }
                                // Get the first MRN supplier for this work order
                                $supplierId = \App\Models\MaterialReceiptNote::where('work_order_id', $state)
                                    ->value('supplier_id');
                                $set('supplier_id', $supplierId);
                            }),
                        Select::make('supplier_id')->label(__('inventory.supplier'))
                            ->relationship('supplier', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved')
                            ->dehydrated(),
                        DatePicker::make('mrr_date')->label(__('inventory.fields.mrr_date'))
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        TextInput::make('return_to')->label(__('inventory.fields.return_to'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        TextInput::make('transport_details')->label(__('inventory.fields.transport_details'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),

                        Select::make('status')->label(__('inventory.fields.status'))
                            ->options([
                                'draft' => __('inventory.enums.status.draft'),
                                'approved' => __('inventory.enums.status.approved'),
                            ])
                            ->required()
                            ->default('draft')
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
                                TextInput::make('qty_returned')->label(__('inventory.fields.qty'))
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
                                TextInput::make('return_reason')->label(__('inventory.fields.notes'))
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
                Section::make(__('inventory.mrr'))
                    ->schema([
                        TextEntry::make('mrr_number')->label(__('inventory.fields.mrr_number')),
                        TextEntry::make('warehouse.name')->label(__('inventory.warehouse')),
                        TextEntry::make('workOrder.wo_number')->label(__('inventory.work_order')),
                        TextEntry::make('supplier.name')->label(__('inventory.supplier')),
                        TextEntry::make('mrr_date')->label(__('inventory.fields.mrr_date'))->date(),
                        TextEntry::make('status')->label(__('inventory.fields.status')),
                        TextEntry::make('notes')->label(__('inventory.fields.notes'))->columnSpanFull(),
                        TextEntry::make('createdBy.name')->label(__('inventory.fields.created_by')),
                        TextEntry::make('created_at')->dateTime(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('mrr_number')
            ->columns([
                TextColumn::make('mrr_number')->label(__('inventory.fields.mrr_number'))->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))->searchable(),
                TextColumn::make('workOrder.wo_number')->label(__('inventory.work_order'))->searchable(),
                TextColumn::make('mrr_date')->label(__('inventory.fields.mrr_date'))->date()->sortable(),
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
            'index' => ListMaterialReturnRequests::route('/'),
            'create' => CreateMaterialReturnRequest::route('/create'),
            'view' => ViewMaterialReturnRequest::route('/{record}'),
            'edit' => EditMaterialReturnRequest::route('/{record}/edit'),
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
