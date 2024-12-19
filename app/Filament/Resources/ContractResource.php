<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Models\Contract;
use App\Models\Land;
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

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 3; // Set the order in the side menu

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Contract Details')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'full_name') // Ensure 'full_name' exists in the User model
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('land_id', null)),

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

                        FileUpload::make('sponsorship_contract_path')
                            ->label('Sponsorship Contract')
                            ->directory('contracts/sponsorship')
                            ->preserveFilenames()
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $uniqueId = Str::uuid();
                                $extension = $file->getClientOriginalExtension();
                                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                return str_replace(' ', '_', $filename) . '_' . $uniqueId . '.' . $extension;
                            })
                            ->required(),

                        FileUpload::make('participation_contract_path')
                            ->label('Participation Contract')
                            ->directory('contracts/participation')
                            ->preserveFilenames()
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $uniqueId = Str::uuid();
                                $extension = $file->getClientOriginalExtension();
                                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                return str_replace(' ', '_', $filename) . '_' . $uniqueId . '.' . $extension;
                            })
                            ->required(),

                        FileUpload::make('personal_id_path')
                            ->label('Personal ID File')
                            ->directory('contracts/personal_ids')
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
                    ->label('Land Number')
                    ->url(fn($record) => route('filament.admin.resources.lands.edit', $record->land_id))
                    ->openUrlInNewTab(false)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('sponsorship_contract_path')
                    ->label('Sponsorship Contract')
                    ->formatStateUsing(fn($state) => basename($state))
                    ->url(fn($record) => Storage::url($record->sponsorship_contract_path), true),

                TextColumn::make('participation_contract_path')
                    ->label('Participation Contract')
                    ->formatStateUsing(fn($state) => basename($state))
                    ->url(fn($record) => Storage::url($record->participation_contract_path), true),

                TextColumn::make('personal_id_path')
                    ->label('Personal ID')
                    ->formatStateUsing(fn($state) => basename($state))
                    ->url(fn($record) => Storage::url($record->personal_id_path), true),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
