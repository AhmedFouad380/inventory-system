<?php

namespace App\Filament\Resources\GatePasses;

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
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class GatePassResource extends Resource
{
    protected static ?string $model = GatePass::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedTruck;

    public static function getNavigationGroup(): ?string
    {
        return __('inventory.nav.operations');
    }

    protected static ?string $recordTitleAttribute = 'gp_number';

    public static function getModelLabel(): string
    {
        return __('inventory.gate_pass');
    }

    public static function getPluralModelLabel(): string
    {
        return __('inventory.gate_passes');
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make('Today')
                ->icon('heroicon-o-calendar')
                ->group(__('inventory.gate_passes'))
                ->sort(1)
                ->url(static::getUrl('index'))
                ->isActiveWhen(
                    fn (): bool =>
                    request()->routeIs('filament.admin.resources.gate-passes.*')
                    && ! request()->has('year')
                ),

            NavigationItem::make('2026')
                ->icon('heroicon-o-calendar-days')
                ->group(__('inventory.gate_passes'))
                ->sort(2)
                ->url(static::getUrl('index', ['year' => 2026]))
                ->isActiveWhen(
                    fn (): bool => request()->integer('year') === 2026
                ),

            NavigationItem::make('2025')
                ->icon('heroicon-o-calendar-days')
                ->group(__('inventory.gate_passes'))
                ->sort(3)
                ->url(static::getUrl('index', ['year' => 2025]))
                ->isActiveWhen(
                    fn (): bool => request()->integer('year') === 2025
                ),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('inventory.gate_pass'))
                    ->schema([
                        TextInput::make('gp_number')
                            ->label(__('inventory.fields.gp_number'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->default(fn () => str_pad((int) (\App\Models\GatePass::max('id') ?? 0) + 1, 5, '0', STR_PAD_LEFT))
                            ->disabled(fn ($record) => $record?->status === 'approved'),

                        Select::make('warehouse_id')
                            ->label(__('inventory.warehouse'))
                            ->searchable()
                            ->preload()
                            ->relationship('warehouse', 'name')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved')
                            ->live(),

                        Select::make('work_order_id')
                            ->label(__('inventory.work_order'))
                            ->searchable()
                            ->preload()
                            ->relationship('workOrder', 'wo_number')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved')
                            ->live(),

                        DateTimePicker::make('issued_at')
                            ->label(__('inventory.fields.issued_at'))
                            ->required()
                            ->default(now())
                            ->disabled(fn ($record) => $record?->status === 'approved'),

                        Select::make('vehicle_number_id')
                            ->label(__('inventory.fields.vehicle_number'))
                            ->options(fn () => \App\Models\VehicleNumber::pluck('value', 'id'))
                            ->searchable()
                            ->preload()
                            ->disabled(fn ($record) => $record?->status === 'approved'),

                        Select::make('recipient_id')
                            ->label(__('inventory.fields.recipient_name'))
                            ->options(fn () => \App\Models\Recipient::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->disabled(fn ($record) => $record?->status === 'approved'),

                        Select::make('driver_id')
                            ->label(__('inventory.fields.driver_name'))
                            ->options(fn () => \App\Models\Driver::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->disabled(fn ($record) => $record?->status === 'approved'),

                        Select::make('destination_id')
                            ->label(__('inventory.fields.destination'))
                            ->options(fn () => \App\Models\Destination::pluck('value', 'id'))
                            ->searchable()
                            ->preload()
                            ->disabled(fn ($record) => $record?->status === 'approved'),

                        Select::make('status')
                            ->label(__('inventory.fields.status'))
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

                        Select::make('engineer_id')
                            ->label(__('inventory.fields.engineer'))
                            ->searchable()
                            ->preload()
                            ->relationship('engineer', 'name')
                            ->disabled(fn ($record) => $record?->status === 'approved'),

                        Textarea::make('notes')
                            ->label(__('inventory.fields.notes'))
                            ->columnSpanFull()
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('inventory.items'))
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('item_id')
                                    ->label(__('inventory.item'))
                                    ->required()
                                    ->columnSpan(2)
                                    ->options(function (Get $get) {
                                        $workOrderId = $get('../../work_order_id');
                                        $warehouseId = $get('../../warehouse_id');

                                        if (! $workOrderId || ! $warehouseId) {
                                            return [];
                                        }

                                        return WorkOrderStock::where('work_order_id', $workOrderId)
                                            ->where('warehouse_id', $warehouseId)
                                            ->where('balance', '>', 0)
                                            ->join('items', 'items.id', '=', 'work_order_stocks.item_id')
                                            ->pluck('items.name', 'items.id');
                                    })
                                    ->live()
                                    ->disabled(fn ($record) => $record?->status === 'approved'),

                                TextInput::make('qty_issued')
                                    ->label(__('inventory.fields.qty'))
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(1)
                                    ->hint(function (Get $get) {
                                        $itemId = $get('item_id');
                                        $workOrderId = $get('../../work_order_id');
                                        $warehouseId = $get('../../warehouse_id');

                                        if (! $itemId || ! $workOrderId || ! $warehouseId) {
                                            return null;
                                        }

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

                                            if (! $itemId || ! $workOrderId || ! $warehouseId) {
                                                return;
                                            }

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

                                TextInput::make('drum_number')
                                    ->label(__('inventory.fields.drum_number'))
                                    ->columnSpan(1)
                                    ->disabled(fn ($record) => $record?->status === 'approved'),

                                TextInput::make('place')
                                    ->label(__('inventory.fields.place'))
                                    ->columnSpan(2)
                                    ->disabled(fn ($record) => $record?->status === 'approved'),
                            ])
                            ->columns(6)
                            ->defaultItems(1)
                            ->label(__('inventory.items'))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                    ])
                    ->columnSpanFull(),
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
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('inventory.items'))
                    ->schema([
                        RepeatableEntry::make('items')
                            ->schema([
                                TextEntry::make('item.name')->label(__('inventory.item')),
                                TextEntry::make('qty_issued')->label(__('inventory.fields.qty')),
                                TextEntry::make('drum_number')->label(__('inventory.fields.drum_number')),
                                TextEntry::make('place')->label(__('inventory.fields.place')),
                            ])
                            ->columns(4)
                            ->label(__('inventory.items')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if ($year = request()->integer('year')) {
                    $query->whereYear('issued_at', $year);

                    return;
                }

                $query->whereDate('issued_at', today());
            })
            ->recordTitleAttribute('gp_number')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('gp_number')
                    ->label(__('inventory.fields.gp_number'))
                    ->searchable(),

                TextColumn::make('warehouse.name')
                    ->label(__('inventory.warehouse'))
                    ->searchable(),

                TextColumn::make('workOrder.wo_number')
                    ->label(__('inventory.work_order'))
                    ->searchable(),

                TextColumn::make('issued_at')
                    ->label(__('inventory.fields.issued_at'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('inventory.fields.status'))
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                \App\Filament\Tables\Filters\DateRangeFilter::make('created_at'),
                \App\Filament\Tables\Filters\DateRangeFilter::make('issued_at', 'تاريخ الإصدار'),
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
                    ExportBulkAction::make(),

                    \Filament\Actions\BulkAction::make('export_pdf_bulk')
                        ->label('تصدير PDF')
                        ->color('danger')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $rows = $records->map(fn ($item) => [
                                $item->gp_number,
                                $item->status,
                                $item->issued_at?->format('Y-m-d'),
                            ])->toArray();

                            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.inventory-report', [
                                'title' => __('inventory.gate_passes'),
                                'headers' => [
                                    __('inventory.fields.gp_number'),
                                    __('inventory.fields.status'),
                                    __('inventory.fields.issued_at'),
                                ],
                                'data' => $rows,
                            ]);

                            return response()->streamDownload(
                                fn () => print($pdf->output()),
                                'gate-pass-reports.pdf'
                            );
                        }),
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