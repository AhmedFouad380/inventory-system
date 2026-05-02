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
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialReceiptNotesRelationManager extends RelationManager
{
    protected static string $relationship = 'materialReceiptNotes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('mrn_number')
                    ->required(),
                Select::make('supplier_id')
                    ->searchable()->preload()->relationship('supplier', 'name')
                    ->default(null),
                DatePicker::make('mrn_date')
                    ->required(),
                TextInput::make('delivery_note_ref')
                    ->default(null),
                TextInput::make('vehicle_number')
                    ->default(null),
                TextInput::make('contract_ref')
                    ->default(null),
                Select::make('status')
                    ->options(['draft' => 'Draft', 'confirmed' => 'Confirmed', 'approved' => 'Approved'])
                    ->default('draft')
                    ->required(),
                TextInput::make('prepared_by')
                    ->required()
                    ->numeric(),
                Select::make('warehouse_keeper_id')
                    ->searchable()->preload()->relationship('warehouseKeeper', 'name')
                    ->default(null),
                TextInput::make('approved_by')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('approved_at'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('mrn_number')
            ->columns([
                TextColumn::make('mrn_number')->label(__('inventory.fields.mrn_number'))
                    ->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))
                    ->searchable(),
                TextColumn::make('supplier.name')->label(__('inventory.supplier'))
                    ->searchable(),
                TextColumn::make('mrn_date')->label(__('inventory.fields.mrn_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('status')->label(__('inventory.fields.status'))
                    ->badge()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('view')
                    ->label(__('filament-actions::view.single.label'))
                    ->icon('heroicon-m-eye')
                    ->url(fn ($record) => \App\Filament\Resources\MaterialReceiptNotes\MaterialReceiptNoteResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
