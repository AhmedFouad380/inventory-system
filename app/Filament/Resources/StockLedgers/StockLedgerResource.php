<?php

namespace App\Filament\Resources\StockLedgers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;


use App\Filament\Resources\StockLedgers\Pages\CreateStockLedger;
use App\Filament\Resources\StockLedgers\Pages\EditStockLedger;
use App\Filament\Resources\StockLedgers\Pages\ListStockLedgers;
use App\Filament\Resources\StockLedgers\Pages\ViewStockLedger;
use App\Models\StockLedger;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;


class StockLedgerResource extends Resource
{
    protected static ?string $model = StockLedger::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedListBullet;

    public static function getNavigationGroup(): ?string { return __('inventory.nav.inventory_reports'); }

    protected static ?string $recordTitleAttribute = 'id';

    public static function getModelLabel(): string { return __('inventory.ledger'); }
    public static function getPluralModelLabel(): string { return __('inventory.ledger'); }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('work_order_id')->label(__('inventory.work_order'))
                    ->searchable()->preload()->relationship('workOrder', 'wo_number')
                    ->required(),
                Select::make('item_id')->label(__('inventory.item'))->searchable()->preload()->relationship('item', 'description')
                    ->required(),
                TextInput::make('transaction_type')->label(__('inventory.fields.type'))
                    ->formatStateUsing(fn (string $state): string => __('inventory.enums.transaction_type.' . $state) ?? $state)
                    ->required(),
                TextInput::make('transaction_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('transaction_date')->label(__('inventory.fields.mrn_date'))
                    ->required(),
                TextInput::make('qty_in')->label(__('inventory.fields.qty'))
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('qty_out')->label(__('inventory.fields.qty'))
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('balance_after')->label(__('inventory.fields.balance'))
                    ->required()
                    ->numeric(),
                
                TextEntry::make('transaction_date')
                    ->date(),
                TextEntry::make('qty_in')
                    ->numeric(),
                TextEntry::make('qty_out')
                    ->numeric(),
                TextEntry::make('balance_after')
                    ->numeric(),
                TextEntry::make('createdBy.name')->label(__('inventory.fields.created_by'))
                    ,
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('workOrder.wo_number')->label(__('inventory.work_order'))
                    ->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))
                    ->searchable(),
                TextColumn::make('item.description')->label(__('inventory.item'))
                    ->searchable(),
                TextColumn::make('transaction_type')->label(__('inventory.fields.type'))
                    ->formatStateUsing(fn (string $state): string => __('inventory.enums.transaction_type.' . $state) ?? $state)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'mrn', 'transfer_in' => 'success',
                        'gate_pass', 'transfer_out' => 'warning',
                        'mdr', 'mrr' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('transaction_id')->label(__('inventory.fields.code'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('transaction_date')->label(__('inventory.fields.mrn_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('qty_in')->label(__('inventory.fields.qty_in'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('qty_out')->label(__('inventory.fields.qty_out'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('balance_after')->label(__('inventory.fields.balance'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('createdBy.name')->label(__('inventory.fields.created_by'))
                    
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('work_order_id')
                    ->label(__('inventory.work_order'))
                    ->relationship('workOrder', 'wo_number')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('warehouse_id')
                    ->label(__('inventory.warehouse'))
                    ->relationship('warehouse', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('item_id')
                    ->label(__('inventory.item'))
                    ->relationship('item', 'description')
                    ->searchable()
                    ->preload(),
                Filter::make('transaction_date')
                    ->form([
                        DatePicker::make('created_from')->label(__('inventory.fields.from_date')),
                        DatePicker::make('created_until')->label(__('inventory.fields.to_date')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('transaction_date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('transaction_date', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make(),
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
            'index' => ListStockLedgers::route('/'),
            'create' => CreateStockLedger::route('/create'),
            'view' => ViewStockLedger::route('/{record}'),
        ];
    }
}
