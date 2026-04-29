<?php

namespace App\Filament\Resources\Items;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;


use App\Filament\Resources\Items\Pages\CreateItem;
use App\Filament\Resources\Items\Pages\EditItem;
use App\Filament\Resources\Items\Pages\ListItems;
use App\Filament\Resources\Items\Pages\ViewItem;
use App\Models\Item;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedCube;

    protected static string | UnitEnum | null $navigationGroup = 'البيانات الأساسية';

    protected static ?string $recordTitleAttribute = 'description';

    public static function getModelLabel(): string { return __('inventory.item'); }
    public static function getPluralModelLabel(): string { return __('inventory.items'); }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label(__('inventory.fields.name'))->required(),
                TextInput::make('item_code')->label(__('inventory.fields.item_code'))
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('description')->label(__('inventory.fields.description'))
                    ->required(),
                Select::make('unit')->label(__('inventory.fields.unit'))
                    ->options([
                        'pcs' => 'Pieces (pcs)',
                        'meter' => 'Meter (m)',
                        'kg' => 'Kilogram (kg)',
                        'roll' => 'Roll',
                        'box' => 'Box',
                        'drum' => 'Drum',
                        'set' => 'Set',
                        'bag' => 'Bag',
                        'liter' => 'Liter (L)',
                    ])
                    ->required()
                    ->default('pcs'),
                Select::make('category_id')->label(__('inventory.category'))
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                Toggle::make('is_active')->label(__('inventory.fields.is_active'))
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')->label(__('inventory.fields.name')),
                TextEntry::make('item_code')->label(__('inventory.fields.item_code')),
                TextEntry::make('description')->label(__('inventory.fields.description')),
                TextEntry::make('unit')->label(__('inventory.fields.unit')),
                TextEntry::make('category.name')->label(__('inventory.category'))
                    ->placeholder('-'),
                IconEntry::make('is_active')->label(__('inventory.fields.is_active'))
                    ->boolean(),
                TextEntry::make('created_at')->dateTime(),
                TextEntry::make('updated_at')->dateTime(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('name')->label(__('inventory.fields.name'))->searchable()->sortable(),
                TextColumn::make('item_code')->label(__('inventory.fields.item_code'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')->label(__('inventory.fields.description'))
                    ->searchable(),
                TextColumn::make('unit')->label(__('inventory.fields.unit'))
                    ->sortable(),
                TextColumn::make('category.name')->label(__('inventory.category'))
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')->label(__('inventory.fields.is_active'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('category_id')
                    ->label(__('inventory.category'))
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
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
            'index' => ListItems::route('/'),
            'create' => CreateItem::route('/create'),
            'view' => ViewItem::route('/{record}'),
            'edit' => EditItem::route('/{record}/edit'),
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
