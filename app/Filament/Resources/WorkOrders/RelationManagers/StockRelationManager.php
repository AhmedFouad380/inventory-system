<?php

namespace App\Filament\Resources\WorkOrders\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;


use Filament\Actions\CreateAction;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StockRelationManager extends RelationManager
{
    protected static string $relationship = 'stock';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('item_id')->label(__('inventory.item'))
                    ->searchable()->preload()->relationship('item', 'description')
                    ->required(),
                TextInput::make('qty_received')->label(__('inventory.fields.qty_received'))
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('qty_issued')->label(__('inventory.fields.qty_issued'))
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('qty_disposed')->label(__('inventory.fields.qty_disposed'))
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('qty_returned')->label(__('inventory.fields.qty_returned'))
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('qty_transfer_out')->label(__('inventory.fields.qty_transfer_out'))
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('qty_transfer_in')->label(__('inventory.fields.qty_transfer_in'))
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('balance')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('item.description')
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
                TextColumn::make('balance')
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
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make(),
                ]),
            ]);
    }
}
