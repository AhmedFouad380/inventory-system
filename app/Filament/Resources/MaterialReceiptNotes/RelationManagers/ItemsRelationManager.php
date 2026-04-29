<?php

namespace App\Filament\Resources\MaterialReceiptNotes\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;


use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('item_id')->label(__('inventory.item'))
                    ->searchable()->preload()->relationship('item', 'name')
                    ->required()
                    ->disabled(fn () => $this->getOwnerRecord()->status === 'approved'),
                TextInput::make('qty_received')->label(__('inventory.fields.qty'))
                    ->required()
                    ->numeric()
                    ->disabled(fn () => $this->getOwnerRecord()->status === 'approved'),
                TextInput::make('reel_number')
                    ->label(__('inventory.fields.reel_number'))
                    ->default(null)
                    ->disabled(fn () => $this->getOwnerRecord()->status === 'approved'),
                Textarea::make('notes')
                    ->label(__('inventory.fields.notes'))
                    ->default(null)
                    ->columnSpanFull()
                    ->disabled(fn () => $this->getOwnerRecord()->status === 'approved'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('item.name')->label(__('inventory.item'))
                    ->searchable(),
                TextColumn::make('qty_received')->label(__('inventory.fields.qty'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reel_number')->label(__('inventory.fields.reel_number'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()->hidden(fn () => $this->getOwnerRecord()->status === 'approved'),
            ])
            ->recordActions([
                EditAction::make()->hidden(fn () => $this->getOwnerRecord()->status === 'approved'),
                DeleteAction::make()->hidden(fn () => $this->getOwnerRecord()->status === 'approved'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->hidden(fn () => $this->getOwnerRecord()->status === 'approved'),
                ]),
            ]);
    }
}
