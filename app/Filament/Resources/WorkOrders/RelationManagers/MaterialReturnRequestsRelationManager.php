<?php

namespace App\Filament\Resources\WorkOrders\RelationManagers;

use App\Filament\Resources\MaterialReturnRequests\MaterialReturnRequestResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Tables\Actions\CreateAction;

class MaterialReturnRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'materialReturnRequests';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('mrr_number')
            ->columns([
                TextColumn::make('mrr_number')->label(__('inventory.fields.mrr_number'))->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))->searchable(),
                TextColumn::make('mrr_date')->label(__('inventory.fields.mrr_date'))->date()->sortable(),
                TextColumn::make('status')->label(__('inventory.fields.status'))->badge(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
                    ->label(__('inventory.export_excel'))
                    ->color('success'),
                CreateAction::make(),
            ])
            ->recordActions([
                Action::make('view')
                    ->label(__('filament-actions::view.single.label'))
                    ->icon('heroicon-m-eye')
                    ->url(fn ($record) => MaterialReturnRequestResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
