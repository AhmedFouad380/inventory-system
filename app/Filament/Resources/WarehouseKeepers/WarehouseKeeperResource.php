<?php

namespace App\Filament\Resources\WarehouseKeepers;

use App\Filament\Resources\WarehouseKeepers\Pages\CreateWarehouseKeeper;
use App\Filament\Resources\WarehouseKeepers\Pages\EditWarehouseKeeper;
use App\Filament\Resources\WarehouseKeepers\Pages\ListWarehouseKeepers;
use App\Filament\Resources\WarehouseKeepers\Schemas\WarehouseKeeperForm;
use App\Filament\Resources\WarehouseKeepers\Tables\WarehouseKeepersTable;
use App\Models\WarehouseKeeper;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class WarehouseKeeperResource extends Resource
{
    protected static ?string $model = WarehouseKeeper::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    public static function getNavigationGroup(): ?string { return __('inventory.settings'); }

    public static function getModelLabel(): string { return __('inventory.warehouse_keeper'); }
    public static function getPluralModelLabel(): string { return __('inventory.warehouse_keepers'); }

    protected static ?string $recordTitleAttribute = 'WarehouseKeeper';

     public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('emp_number')
                    ->label('Emp Number')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListWarehouseKeepers::route('/'),
            'create' => CreateWarehouseKeeper::route('/create'),
            'edit' => EditWarehouseKeeper::route('/{record}/edit'),
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
