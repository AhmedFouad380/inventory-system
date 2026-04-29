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
    
    protected static string|UnitEnum|null $navigationGroup = 'البيانات الأساسية';

    public static function getModelLabel(): string { return 'مستودع'; }
    public static function getPluralModelLabel(): string { return 'المستودعات'; }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')->label('اسم المستودع')->required(),
                        TextInput::make('code')->label('كود المستودع')->required()->unique(ignoreRecord: true),
                        TextInput::make('location')->label('الموقع'),
                        Toggle::make('is_active')->label('نشط')->default(true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم')->searchable(),
                TextColumn::make('code')->label('الكود')->searchable(),
                TextColumn::make('location')->label('الموقع'),
                IconColumn::make('is_active')->label('نشط')->boolean(),
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
