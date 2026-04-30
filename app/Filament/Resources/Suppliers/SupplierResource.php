<?php

namespace App\Filament\Resources\Suppliers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use App\Filament\Resources\Suppliers\Pages\CreateSupplier;
use App\Filament\Resources\Suppliers\Pages\EditSupplier;
use App\Filament\Resources\Suppliers\Pages\ListSuppliers;
use App\Filament\Resources\Suppliers\Pages\ViewSupplier;
use App\Models\Supplier;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    public static function getNavigationGroup(): ?string { return __('inventory.nav.basic_data'); }

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string { return __('inventory.supplier'); }
    public static function getPluralModelLabel(): string { return __('inventory.suppliers'); }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label(__('inventory.fields.name'))
                    ->required(),
                TextInput::make('contact_person')->label(__('inventory.fields.contact_person')),
                TextInput::make('phone')->label(__('inventory.fields.phone')),
                TextInput::make('email')->label(__('inventory.fields.email'))
                    ->email(),
                Textarea::make('address')->label(__('inventory.fields.address'))
                    ->columnSpanFull(),
                Toggle::make('is_active')->label(__('inventory.fields.is_active'))
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->label(__('inventory.fields.name'))
                    ->searchable(),
                TextColumn::make('contact_person')->label(__('inventory.fields.contact_person'))
                    ->searchable(),
                TextColumn::make('phone')->label(__('inventory.fields.phone'))
                    ->searchable(),
                TextColumn::make('email')->label(__('inventory.fields.email'))
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label(__('inventory.fields.is_active'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
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
            'index' => ListSuppliers::route('/'),
            'create' => CreateSupplier::route('/create'),
            'view' => ViewSupplier::route('/{record}'),
            'edit' => EditSupplier::route('/{record}/edit'),
        ];
    }
}
