<?php

namespace App\Filament\Resources\GatePasses;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;


use App\Filament\Resources\GatePasses\Pages\CreateGatePass;
use App\Filament\Resources\GatePasses\Pages\EditGatePass;
use App\Filament\Resources\GatePasses\Pages\ListGatePasses;
use App\Filament\Resources\GatePasses\Pages\ViewGatePass;
use App\Filament\Resources\GatePasses\RelationManagers;
use App\Models\GatePass;
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

class GatePassResource extends Resource
{
    protected static ?string $model = GatePass::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedTruck;

    public static function getNavigationGroup(): ?string { return __('inventory.nav.operations'); }

    protected static ?string $recordTitleAttribute = 'gp_number';

    public static function getModelLabel(): string { return __('inventory.gate_pass'); }
    public static function getPluralModelLabel(): string { return __('inventory.gate_passes'); }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('inventory.gate_pass'))
                    ->schema([
                        TextInput::make('gp_number')->label(__('inventory.fields.gp_number'))
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
                        DateTimePicker::make('issued_at')->label(__('inventory.fields.issued_at'))
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        TextInput::make('vehicle_number')->label(__('inventory.fields.vehicle_number'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        TextInput::make('recipient_name')->label(__('inventory.fields.recipient_name'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        TextInput::make('driver_name')->label(__('inventory.fields.driver_name'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        TextInput::make('destination')->label(__('inventory.fields.destination'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('status')->label(__('inventory.fields.status'))
                            ->options([
                                'draft' => __('inventory.enums.status.draft'),
                                'approved' => __('inventory.enums.status.approved'),
                            ])
                            ->required()
                            ->default('draft')
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('warehouse_keeper_id')->label(__('inventory.fields.warehouse_keeper'))
                            ->searchable()->preload()->relationship('warehouseKeeper', 'name')
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        Select::make('engineer_id')->label(__('inventory.fields.engineer'))
                            ->searchable()->preload()->relationship('engineer', 'name')
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
                                TextInput::make('qty_issued')->label(__('inventory.fields.qty'))
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
                                    ->rules([
                                        fn (Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                            $itemId = $get('item_id');
                                            $workOrderId = $get('../../work_order_id');
                                            $warehouseId = $get('../../warehouse_id');
                                            if (!$itemId || !$workOrderId || !$warehouseId) return;

                                            $stock = WorkOrderStock::where('work_order_id', $workOrderId)
                                                ->where('warehouse_id', $warehouseId)
                                                ->where('item_id', $itemId)
                                                ->first();

                                            if ($stock && $value > $stock->balance) {
                                                $fail(__('inventory.messages.insufficient_stock', ['balance' => $stock->balance]));
                                            }
                                        },
                                    ])
                                    ->disabled(fn ($record) => $record?->status === 'approved'),
                                TextInput::make('reel_number')->label(__('inventory.fields.reel_number'))
                                    ->columnSpan(1)
                                    ->disabled(fn ($record) => $record?->status === 'approved'),
                                TextInput::make('notes')->label(__('inventory.fields.notes'))
                                    ->columnSpan(2)
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
                Section::make(__('inventory.gate_pass'))
                    ->schema([
                        TextEntry::make('gp_number')->label(__('inventory.fields.gp_number')),
                        TextEntry::make('warehouse.name')->label(__('inventory.warehouse')),
                        TextEntry::make('workOrder.wo_number')->label(__('inventory.work_order')),
                        TextEntry::make('issued_at')->label(__('inventory.fields.issued_at'))->dateTime(),
                        TextEntry::make('vehicle_number')->label(__('inventory.fields.vehicle_number')),
                        TextEntry::make('recipient_name')->label(__('inventory.fields.recipient_name')),
                        TextEntry::make('status')->label(__('inventory.fields.status')),
                        TextEntry::make('warehouseKeeper.name')->label(__('inventory.fields.warehouse_keeper')),
                        TextEntry::make('engineer.name')->label(__('inventory.fields.engineer')),
                        TextEntry::make('notes')->label(__('inventory.fields.notes'))->columnSpanFull(),
                        TextEntry::make('createdBy.name')->label(__('inventory.fields.created_by')),
                        TextEntry::make('created_at')->dateTime(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('gp_number')
            ->columns([
                TextColumn::make('gp_number')->label(__('inventory.fields.gp_number'))->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))->searchable(),
                TextColumn::make('workOrder.wo_number')->label(__('inventory.work_order'))->searchable(),
                TextColumn::make('issued_at')->label(__('inventory.fields.issued_at'))->dateTime()->sortable(),
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
            'index' => ListGatePasses::route('/'),
            'create' => CreateGatePass::route('/create'),
            'view' => ViewGatePass::route('/{record}'),
            'edit' => EditGatePass::route('/{record}/edit'),
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
