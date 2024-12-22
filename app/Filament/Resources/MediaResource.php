<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Filament\Resources\MediaResource\RelationManagers;
use App\Filament\Resources\MediaResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\MediaResource\RelationManagers\VideosRelationManager;
use App\Models\Land;
use App\Models\Media;
use App\Rules\UniqueUserLandRule;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 7; // Set the order in the side menu

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Media Details')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'full_name')
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('land_id', null))
                            ->rules(function (callable $get) {
                                return [
                                    new UniqueUserLandRule('media', $get('user_id'), $get('land_id')),
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
            VideosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
