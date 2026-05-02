<?php

namespace App\Filament\Resources\WorkOrders\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;


use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\AssociateAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
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

class GatePassesRelationManager extends RelationManager
{
    protected static string $relationship = 'gatePasses';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('gp_number')
                    ->required(),
                DateTimePicker::make('issued_at')
                    ->required(),
                TextInput::make('vehicle_number')
                    ->default(null),
                TextInput::make('recipient_name')
                    ->default(null),
                TextInput::make('driver_name')
                    ->default(null),
                TextInput::make('destination')
                    ->default(null),
                Select::make('status')
                    ->options(['draft' => 'Draft', 'issued' => 'Issued', 'confirmed' => 'Confirmed'])
                    ->default('draft')
                    ->required(),
                TextInput::make('prepared_by')
                    ->required()
                    ->numeric(),
                Select::make('warehouse_keeper_id')
                    ->searchable()->preload()->relationship('warehouseKeeper', 'name')
                    ->default(null),
                Select::make('engineer_id')
                    ->searchable()->preload()->relationship('engineer', 'name')
                    ->default(null),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('gp_number')
            ->columns([
                TextColumn::make('gp_number')->label(__('inventory.fields.gp_number'))->searchable(),
                TextColumn::make('warehouse.name')->label(__('inventory.warehouse'))->searchable(),
                TextColumn::make('issued_at')->label(__('inventory.fields.issued_at'))->dateTime()->sortable(),
                TextColumn::make('status')->label(__('inventory.fields.status'))->badge()->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
                    ->label(__('inventory.export_excel'))
                    ->color('success'),
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('view')
                    ->label(__('filament-actions::view.single.label'))
                    ->icon('heroicon-m-eye')
                    ->url(fn ($record) => \App\Filament\Resources\GatePasses\GatePassResource::getUrl('view', ['record' => $record]))
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
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
