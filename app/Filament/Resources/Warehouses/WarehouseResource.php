<?php

namespace App\Filament\Resources\Warehouses;

use App\Models\Warehouse;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use App\Filament\Resources\Warehouses\Pages\ListWarehouses;
use App\Filament\Resources\Warehouses\Pages\CreateWarehouse;
use App\Filament\Resources\Warehouses\Pages\EditWarehouse;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use BackedEnum;
use UnitEnum;
use Filament\Support\Icons\Heroicon;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;
    
    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedHomeModern;
    
    public static function getNavigationGroup(): ?string { return __('inventory.nav.basic_data'); }

    public static function getModelLabel(): string { return __('inventory.warehouse'); }
    public static function getPluralModelLabel(): string { return __('inventory.warehouses'); }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')->label(__('inventory.fields.warehouse_name'))->required(),
                        TextInput::make('code')->label(__('inventory.fields.warehouse_code'))->required()->unique(ignoreRecord: true),
                        TextInput::make('location')->label(__('inventory.fields.location')),
                        Toggle::make('is_active')->label(__('inventory.fields.is_active'))->default(true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')->label(__('inventory.fields.name'))->searchable(),
                TextColumn::make('code')->label(__('inventory.fields.code'))->searchable(),
                TextColumn::make('location')->label(__('inventory.fields.location')),
                IconColumn::make('is_active')->label(__('inventory.fields.is_active'))->boolean(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWarehouses::route('/'),
            'create' => CreateWarehouse::route('/create'),
            'edit' => EditWarehouse::route('/{record}/edit'),
        ];
    }
}
