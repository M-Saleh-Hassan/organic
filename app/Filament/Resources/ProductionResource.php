<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductionResource\Pages;
use App\Filament\Resources\ProductionResource\RelationManagers\DetailsRelationManager;
use App\Models\Land;
use App\Models\Production;
use App\Rules\UniqueUserLandRule;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 5; // Set the order in the side menu

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Production Details')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'full_name') // Assuming 'full_name' exists in User model
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('land_id', null))
                            ->rules(function (callable $get) {
                                return [
                                    new UniqueUserLandRule('productions', $get('user_id'), $get('land_id')),
                                ];
                            }),

                        Select::make('land_id')
                            ->label('Land')
                            ->options(function (callable $get) {
                                $userId = $get('user_id');
                                if ($userId) {
                                    return Land::where('user_id', $userId)->pluck('land_number', 'id');
                                }
                                return [];
                            })
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search, callable $get) {
                                $userId = $get('user_id');
                                return Land::where('user_id', $userId)
                                    ->where('land_number', 'like', "%{$search}%")
                                    ->pluck('land_number', 'id');
                            })
                            ->required(),

                        Textarea::make('description')
                            ->label('Description')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.full_name')
                    ->label('User')
                    ->url(fn($record) => route('filament.admin.resources.users.edit', $record->user_id))
                    ->openUrlInNewTab(false)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('land.land_number')
                    ->label('Land')
                    ->url(fn($record) => route('filament.admin.resources.lands.edit', $record->land_id))
                    ->openUrlInNewTab(false)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'full_name')
                    ->searchable(),
                SelectFilter::make('land_id')
                    ->label('Land')
                    ->relationship('land', 'land_number')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductions::route('/'),
            'create' => Pages\CreateProduction::route('/create'),
            'edit' => Pages\EditProduction::route('/{record}/edit'),
        ];
    }
}
