<?php

namespace App\Filament\Resources\WorkOrders;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;


use App\Filament\Resources\WorkOrders\Pages\CreateWorkOrder;
use App\Filament\Resources\WorkOrders\Pages\EditWorkOrder;
use App\Filament\Resources\WorkOrders\Pages\ListWorkOrders;
use App\Filament\Resources\WorkOrders\Pages\ViewWorkOrder;
use App\Filament\Resources\WorkOrders\RelationManagers;
use App\Models\WorkOrder;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkOrderResource extends Resource
{
    protected static ?string $model = WorkOrder::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function getNavigationGroup(): ?string { return __('inventory.nav.operations'); }

    protected static ?string $recordTitleAttribute = 'wo_number';

    public static function getModelLabel(): string
    {
        return __('inventory.work_order');
    }

    public static function getPluralModelLabel(): string
    {
        return __('inventory.work_orders');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('wo_number')
                    ->label(__('inventory.fields.wo_number'))
                    ->required(),
                Select::make('project_id')
                    ->label(__('inventory.project'))
                    ->searchable()->preload()->relationship('project', 'name')
                    ->required(),
                Select::make('site_id')
                    ->label(__('inventory.site'))
                    ->searchable()->preload()->relationship('site', 'name'),
                Select::make('contractor_id')
                    ->label(__('inventory.contractor'))
                    ->searchable()->preload()->relationship('contractor', 'name'),
                TextInput::make('contract_ref')->label(__('inventory.fields.contract_ref')),
                Select::make('status')
                    ->label(__('inventory.fields.status'))
                    ->options([
                        'open' => __('inventory.enums.status.open'),
                        'closed' => __('inventory.enums.status.closed'),
                        'suspended' => __('inventory.enums.status.suspended'),
                    ])
                    ->required()
                    ->default('open'),
                DatePicker::make('opened_at')
                    ->label(__('inventory.fields.opened_at'))
                    ->required(),
                DatePicker::make('closed_at')
                    ->label(__('inventory.fields.closed_at')),
                
                Textarea::make('notes')->label(__('inventory.fields.notes'))
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('wo_number'),
                TextEntry::make('project.name')
                    ->label('Project'),
                TextEntry::make('site.name')
                    ->label('Site')
                    ->placeholder('-'),
                TextEntry::make('contractor.name')
                    ->label('Contractor')
                    ->placeholder('-'),
                TextEntry::make('contract_ref')
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('opened_at')
                    ->date(),
                TextEntry::make('closed_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('createdBy.name')
                    ->label(__('inventory.fields.created_by')),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn ($record): bool => $record?->trashed() ?? false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('wo_number')
            ->columns([
                TextColumn::make('wo_number')
                    ->searchable(),
                TextColumn::make('project.name')->label(__('inventory.project'))
                    ->searchable(),
                TextColumn::make('site.name')->label(__('inventory.site'))
                    ->searchable(),
                TextColumn::make('contractor.name')->label(__('inventory.contractor'))
                    ->searchable(),
                TextColumn::make('contract_ref')->label(__('inventory.fields.contract_ref'))
                    ->searchable(),
                TextColumn::make('status')->label(__('inventory.fields.status'))
                    ->searchable(),
                TextColumn::make('opened_at')->label(__('inventory.fields.opened_at'))
                    ->date()
                    ->sortable(),
                TextColumn::make('closed_at')->label(__('inventory.fields.closed_at'))
                    ->date()
                    ->sortable(),
                TextColumn::make('createdBy.name')->label(__('inventory.fields.created_by'))
                    
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
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
            RelationManagers\MaterialReceiptNotesRelationManager::class,
            RelationManagers\GatePassesRelationManager::class,
            RelationManagers\StockRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkOrders::route('/'),
            'create' => CreateWorkOrder::route('/create'),
            'view' => ViewWorkOrder::route('/{record}'),
            'edit' => EditWorkOrder::route('/{record}/edit'),
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
