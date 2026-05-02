<?php

namespace App\Filament\Resources\SupplierReturns;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Section;

use App\Filament\Resources\SupplierReturns\Pages\CreateSupplierReturn;
use App\Filament\Resources\SupplierReturns\Pages\EditSupplierReturn;
use App\Filament\Resources\SupplierReturns\Pages\ListSupplierReturns;
use App\Filament\Resources\SupplierReturns\Pages\ViewSupplierReturn;
use App\Models\SupplierReturn;
use App\Models\WorkOrderStock;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierReturnResource extends Resource
{
    protected static ?string $model = SupplierReturn::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedArrowUturnLeft;

    public static function getNavigationGroup(): ?string { return __('inventory.nav.operations'); }

    protected static ?string $recordTitleAttribute = 'return_number';

    public static function getModelLabel(): string { return __('inventory.supplier_return'); }
    public static function getPluralModelLabel(): string { return __('inventory.supplier_returns'); }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('inventory.supplier_return'))
                    ->schema([
                        TextInput::make('return_number')->label(__('inventory.fields.sr_number'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->default(fn () => 'SRN-' . str_pad((int) (SupplierReturn::max('id') ?? 0) + 1, 5, '0', STR_PAD_LEFT))
                            ->disabled(fn ($record) => $record?->status === 'approved'),
                        
                        Select::make('work_order_id')->label(__('inventory.work_order'))
                            ->searchable()->preload()->relationship('workOrder', 'wo_number')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved')
                            ->live(),

                        Select::make('supplier_id')->label(__('inventory.supplier'))
                            ->relationship('supplier', 'name')
                            ->searchable()->preload()
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved'),

                        Select::make('warehouse_id')->label(__('inventory.warehouse'))
                            ->searchable()->preload()->relationship('warehouse', 'name')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'approved')
                            ->live(),

                        DatePicker::make('return_date')->label(__('inventory.fields.return_date'))
                            ->required()
                            ->default(now())
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
                    ])->columns(2)->columnSpanFull(),

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

                                TextInput::make('qty')->label(__('inventory.fields.qty'))
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
                            ])
                            ->columns(3)
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
                Section::make(__('inventory.supplier_return'))
                    ->schema([
                        TextEntry::make('return_number')->label(__('inventory.fields.sr_number')),
                        TextEntry::make('workOrder.wo_number')->label(__('inventory.work_order')),
                        TextEntry::make('supplier.name')->label(__('inventory.supplier')),
                        TextEntry::make('warehouse.name')->label(__('inventory.warehouse')),
                        TextEntry::make('return_date')->label(__('inventory.fields.return_date'))->date(),
                        TextEntry::make('status')->label(__('inventory.fields.status'))->badge(),
                        TextEntry::make('notes')->label(__('inventory.fields.notes'))->columnSpanFull(),
                        TextEntry::make('createdBy.name')->label(__('inventory.fields.created_by')),
                        TextEntry::make('created_at')->dateTime(),
                    ])->columns(2)->columnSpanFull(),

                Section::make(__('inventory.items'))
                    ->schema([
                        RepeatableEntry::make('items')
                            ->schema([
                                TextEntry::make('item.name')->label(__('inventory.item')),
                                TextEntry::make('qty')->label(__('inventory.fields.qty')),
                            ])
                            ->columns(2)
                            ->label(__('inventory.items')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('return_number')
            ->columns([
                TextColumn::make('return_number')->label(__('inventory.fields.sr_number'))->searchable(),
                TextColumn::make('workOrder.wo_number')->label(__('inventory.work_order'))->searchable(),
                TextColumn::make('supplier.name')->label(__('inventory.supplier'))->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))->searchable(),
                TextColumn::make('return_date')->label(__('inventory.fields.return_date'))->date()->sortable(),
                TextColumn::make('status')->label(__('inventory.fields.status'))->badge()->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
                    ExportBulkAction::make(),
                    \Filament\Actions\BulkAction::make('export_pdf_bulk')
                        ->label('تصدير PDF')
                        ->color('danger')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $rows = $records->map(fn ($item) => [
                                $item->return_number,
                                $item->status,
                                $item->return_date?->format('Y-m-d'),
                            ])->toArray();

                            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.inventory-report', [
                                'title' => __('inventory.supplier_returns'),
                                'headers' => [__('inventory.fields.sr_number'), __('inventory.fields.status'), __('inventory.fields.return_date')],
                                'data' => $rows,
                            ]);

                            return response()->streamDownload(fn () => print($pdf->output()), 'supplier-return-reports.pdf');
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
            'index' => ListSupplierReturns::route('/'),
            'create' => CreateSupplierReturn::route('/create'),
            'view' => ViewSupplierReturn::route('/{record}'),
            'edit' => EditSupplierReturn::route('/{record}/edit'),
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
