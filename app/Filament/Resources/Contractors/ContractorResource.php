<?php

namespace App\Filament\Resources\Contractors;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use App\Filament\Resources\Contractors\Pages\CreateContractor;
use App\Filament\Resources\Contractors\Pages\EditContractor;
use App\Filament\Resources\Contractors\Pages\ListContractors;
use App\Filament\Resources\Contractors\Pages\ViewContractor;
use App\Models\Contractor;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractorResource extends Resource
{
    protected static ?string $model = Contractor::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationGroup(): ?string { return __('inventory.nav.basic_data'); }

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string { return __('inventory.contractor'); }
    public static function getPluralModelLabel(): string { return __('inventory.contractors'); }

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
                TextColumn::make('createdBy.name')->label(__('inventory.fields.created_by'))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
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
            'index' => ListContractors::route('/'),
            'create' => CreateContractor::route('/create'),
            'view' => ViewContractor::route('/{record}'),
            'edit' => EditContractor::route('/{record}/edit'),
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
