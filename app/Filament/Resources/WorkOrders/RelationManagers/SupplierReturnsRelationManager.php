<?php

namespace App\Filament\Resources\WorkOrders\RelationManagers;

use App\Filament\Resources\SupplierReturns\SupplierReturnResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;

class SupplierReturnsRelationManager extends RelationManager
{
    protected static string $relationship = 'supplierReturns';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('return_number')
            ->columns([
                TextColumn::make('return_number')->label(__('inventory.fields.sr_number'))->searchable(),
                TextColumn::make('supplier.name')->label(__('inventory.supplier'))->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))->searchable(),
                TextColumn::make('return_date')->label(__('inventory.fields.return_date'))->date()->sortable(),
                TextColumn::make('status')->label(__('inventory.fields.status'))->badge(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                \Filament\Actions\Action::make('view')
                    ->label(__('filament-actions::view.single.label'))
                    ->icon('heroicon-m-eye')
                    ->url(fn ($record) => SupplierReturnResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make(),
                ]),
            ]);
    }
}
