<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancialResource\Pages;
use App\Filament\Resources\FinancialResource\RelationManagers;
use App\Filament\Resources\FinancialResource\RelationManagers\RecordsRelationManager;
use App\Models\Financial;
use App\Models\Land;
use App\Rules\UniqueUserLandRule;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FinancialResource extends Resource
{
    protected static ?string $model = Financial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 6; // Set the order in the side menu

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Financial Details')
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
                                    new UniqueUserLandRule('financials', $get('user_id'), $get('land_id')),
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

                        FileUpload::make('file_path')
                            ->label('Financial Document')
                            ->directory('financial-documents')
                            ->preserveFilenames()
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $uniqueId = Str::uuid();
                                $extension = $file->getClientOriginalExtension();
                                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                return str_replace(' ', '_', $filename) . '_' . $uniqueId . '.' . $extension;
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

                TextColumn::make('file_path')
                    ->label('Document')
                    ->formatStateUsing(fn($state) => basename($state))
                    ->url(fn($record) => Storage::url($record->file_path), true),

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
            RecordsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinancials::route('/'),
            'create' => Pages\CreateFinancial::route('/create'),
            'edit' => Pages\EditFinancial::route('/{record}/edit'),
        ];
    }
}
