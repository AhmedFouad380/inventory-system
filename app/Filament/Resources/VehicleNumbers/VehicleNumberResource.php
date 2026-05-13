<?php

namespace App\Filament\Resources\VehicleNumbers;

use App\Filament\Resources\VehicleNumbers\Pages;
use App\Models\VehicleNumber;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Schemas\Schema;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class VehicleNumberResource extends Resource
{
    protected static ?string $model = VehicleNumber::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-truck';
    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('value')->required()->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('value')->searchable()->sortable(),
                TextColumn::make('created_at')->label('Created')->dateTime()->toggleable(isToggledHiddenByDefault: true),
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
            ]);;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicleNumbers::route('/'),
            'create' => Pages\CreateVehicleNumber::route('/create'),
            'edit' => Pages\EditVehicleNumber::route('/{record}/edit'),
        ];
    }
}
