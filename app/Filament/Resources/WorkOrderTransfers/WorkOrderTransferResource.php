<?php

namespace App\Filament\Resources\WorkOrderTransfers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;


use App\Filament\Resources\WorkOrderTransfers\Pages\CreateWorkOrderTransfer;
use App\Filament\Resources\WorkOrderTransfers\Pages\EditWorkOrderTransfer;
use App\Filament\Resources\WorkOrderTransfers\Pages\ListWorkOrderTransfers;
use App\Filament\Resources\WorkOrderTransfers\Pages\ViewWorkOrderTransfer;
use App\Models\WorkOrderTransfer;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkOrderTransferResource extends Resource
{
    protected static ?string $model = WorkOrderTransfer::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    public static function getNavigationGroup(): ?string { return __('inventory.nav.operations'); }

    protected static ?string $recordTitleAttribute = 'transfer_number';

    public static function getModelLabel(): string { return __('inventory.transfer'); }
    public static function getPluralModelLabel(): string { return __('inventory.transfers'); }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('inventory.transfer_details'))
                    ->schema([
                        TextInput::make('transfer_number')->label(__('inventory.fields.transfer_number'))
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('warehouse_id')->label(__('inventory.warehouse'))
                            ->searchable()->preload()->relationship('warehouse', 'name')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved')
                            ->live(),
                        Select::make('from_work_order_id')->label(__('inventory.fields.from_work_order'))
                            ->searchable()->preload()->relationship('fromWorkOrder', 'wo_number')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved')
                            ->live(),
                        Select::make('to_work_order_id')->label(__('inventory.fields.to_work_order'))
                            ->searchable()->preload()->relationship('toWorkOrder', 'wo_number')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        DatePicker::make('transfer_date')->label(__('inventory.fields.transfer_date'))
                            ->required()
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
                                        $fromWorkOrderId = $get('../../from_work_order_id');
                                        $warehouseId = $get('../../warehouse_id');
                                        if (!$fromWorkOrderId || !$warehouseId) return [];
                                        
                                        return WorkOrderStock::where('work_order_id', $fromWorkOrderId)
                                            ->where('warehouse_id', $warehouseId)
                                            ->where('balance', '>', 0)
                                            ->join('items', 'items.id', '=', 'work_order_stocks.item_id')
                                            ->pluck('items.name', 'items.id');
                                    })
                                    ->live()
                                    ->disabled(fn ($record) => $record?->status === 'approved'),
                                TextInput::make('qty_transferred')->label(__('inventory.fields.qty_transferred'))
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(1)
                                    ->hint(function (Get $get) {
                                        $itemId = $get('item_id');
                                        $fromWorkOrderId = $get('../../from_work_order_id');
                                        $warehouseId = $get('../../warehouse_id');
                                        if (!$itemId || !$fromWorkOrderId || !$warehouseId) return null;
                                        
                                        $stock = WorkOrderStock::where('work_order_id', $fromWorkOrderId)
                                            ->where('warehouse_id', $warehouseId)
                                            ->where('item_id', $itemId)
                                            ->first();
                                        
                                        $available = __('inventory.fields.balance');
                                        return $stock ? "{$available}: {$stock->balance}" : null;
                                    })
                                    ->rules([
                                        fn (Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                            $itemId = $get('item_id');
                                            $fromWorkOrderId = $get('../../from_work_order_id');
                                            $warehouseId = $get('../../warehouse_id');
                                            if (!$itemId || !$fromWorkOrderId || !$warehouseId) return;
 
                                            $stock = WorkOrderStock::where('work_order_id', $fromWorkOrderId)
                                                ->where('warehouse_id', $warehouseId)
                                                ->where('item_id', $itemId)
                                                ->first();
 
                                            if ($stock && $value > $stock->balance) {
                                                $fail(__('inventory.messages.insufficient_stock', ['balance' => $stock->balance]));
                                            }
                                        },
                                    ])
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
                Section::make(__('inventory.transfer_details'))
                    ->schema([
                        TextEntry::make('transfer_number')->label(__('inventory.fields.transfer_number')),
                        TextEntry::make('warehouse.name')->label(__('inventory.warehouse')),
                        TextEntry::make('fromWorkOrder.wo_number')->label(__('inventory.fields.from_work_order')),
                        TextEntry::make('toWorkOrder.wo_number')->label(__('inventory.fields.to_work_order')),
                        TextEntry::make('transfer_date')->label(__('inventory.fields.transfer_date'))->date(),
                        TextEntry::make('status')->label(__('inventory.fields.status')),
                        TextEntry::make('notes')->label(__('inventory.fields.notes'))->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transfer_number')->label(__('inventory.fields.transfer_number'))->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))->searchable(),
                TextColumn::make('fromWorkOrder.wo_number')->label(__('inventory.fields.from_work_order'))->searchable(),
                TextColumn::make('toWorkOrder.wo_number')->label(__('inventory.fields.to_work_order'))->searchable(),
                TextColumn::make('transfer_date')->label(__('inventory.fields.transfer_date'))->date()->sortable(),
                TextColumn::make('status')->label(__('inventory.fields.status'))->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => ListWorkOrderTransfers::route('/'),
            'create' => CreateWorkOrderTransfer::route('/create'),
            'view' => ViewWorkOrderTransfer::route('/{record}'),
            'edit' => EditWorkOrderTransfer::route('/{record}/edit'),
        ];
    }
}
