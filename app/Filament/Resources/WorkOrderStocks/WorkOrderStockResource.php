<?php

namespace App\Filament\Resources\WorkOrderStocks;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;


use App\Filament\Resources\WorkOrderStocks\Pages\CreateWorkOrderStock;
use App\Filament\Resources\WorkOrderStocks\Pages\EditWorkOrderStock;
use App\Filament\Resources\WorkOrderStocks\Pages\ListWorkOrderStocks;
use App\Filament\Resources\WorkOrderStocks\Pages\ViewWorkOrderStock;
use App\Models\WorkOrderStock;
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
use Illuminate\Database\Eloquent\Builder;

class WorkOrderStockResource extends Resource
{
    protected static ?string $model = WorkOrderStock::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedCircleStack;

    public static function getNavigationGroup(): ?string { return __('inventory.nav.inventory_reports'); }

    protected static ?string $recordTitleAttribute = 'id';

    public static function getModelLabel(): string { return __('inventory.stock'); }
    public static function getPluralModelLabel(): string { return __('inventory.stock'); }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('work_order_id')->label(__('inventory.work_order'))
                    ->searchable()->preload()->relationship('workOrder', 'wo_number')
                    ->required(),
                Select::make('item_id')->label(__('inventory.item'))->searchable()->preload()->relationship('item', 'description')
                    ->required(),
                TextInput::make('qty_received')->label(__('inventory.fields.qty_received'))
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('qty_issued')->label(__('inventory.fields.qty_issued'))
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('qty_disposed')->label(__('inventory.fields.qty_disposed'))
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('qty_returned')->label(__('inventory.fields.qty_returned'))
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('qty_transfer_out')->label(__('inventory.fields.qty_transfer_out'))
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('qty_transfer_in')->label(__('inventory.fields.qty_transfer_in'))
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('balance')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('workOrder.wo_number')->label(__('inventory.work_order')),
                TextEntry::make('item.description')->label(__('inventory.item')),
                TextEntry::make('qty_received')
                    ->numeric(),
                TextEntry::make('qty_issued')
                    ->numeric(),
                TextEntry::make('qty_disposed')
                    ->numeric(),
                TextEntry::make('qty_returned')
                    ->numeric(),
                TextEntry::make('qty_transfer_out')
                    ->numeric(),
                TextEntry::make('qty_transfer_in')
                    ->numeric(),
                TextEntry::make('balance')
                    ->numeric(),
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
            ->columns([
                TextColumn::make('workOrder.wo_number')->label(__('inventory.work_order'))
                    ->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))
                    ->searchable(),
                TextColumn::make('item.description')->label(__('inventory.item'))
                    ->searchable(),
                TextColumn::make('qty_received')->label(__('inventory.fields.qty_received'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('qty_issued')->label(__('inventory.fields.qty_issued'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('qty_disposed')->label(__('inventory.fields.qty_disposed'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('qty_returned')->label(__('inventory.fields.qty_returned'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('qty_transfer_out')->label(__('inventory.fields.qty_transfer_out'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('qty_transfer_in')->label(__('inventory.fields.qty_transfer_in'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('balance')->label(__('inventory.fields.balance'))
                    ->numeric()
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
            'index' => ListWorkOrderStocks::route('/'),
            'create' => CreateWorkOrderStock::route('/create'),
            'view' => ViewWorkOrderStock::route('/{record}'),
        ];
    }
}
