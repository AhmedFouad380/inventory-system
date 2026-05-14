<?php

namespace App\Filament\Resources\SiteEngineers;

use App\Filament\Resources\SiteEngineers\Pages\CreateSiteEngineers;
use App\Filament\Resources\SiteEngineers\Pages\EditSiteEngineers;
use App\Filament\Resources\SiteEngineers\Pages\ListSiteEngineers;
use App\Filament\Resources\SiteEngineers\Schemas\SiteEngineersForm;
use App\Filament\Resources\SiteEngineers\Tables\SiteEngineersTable;
use App\Models\SiteEngineer;
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
class SiteEngineersResource extends Resource
{
    protected static ?string $model = SiteEngineer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    public static function getNavigationGroup(): ?string { return __('inventory.settings'); }

    public static function getModelLabel(): string { return __('inventory.site_engineer'); }
    public static function getPluralModelLabel(): string { return __('inventory.site_engineers'); }

    protected static ?string $recordTitleAttribute = 'SiteEngineer';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('emp_number')
                    ->label('Emp Number')
                    ->required()
                    ->maxLength(255),
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
            'index' => ListSiteEngineers::route('/'),
            'create' => CreateSiteEngineers::route('/create'),
            'edit' => EditSiteEngineers::route('/{record}/edit'),
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
