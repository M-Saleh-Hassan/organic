<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandResource\Pages;
use App\Filament\Resources\LandResource\RelationManagers;
use App\Models\Land;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LandResource extends Resource
{
    protected static ?string $model = Land::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 2; // Set the order in the side menu

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Land Details')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'full_name') // Replace 'full_name' with the correct field from User
                            ->required()
                            ->searchable(),

                        TextInput::make('land_number')
                            ->label('Land Number')
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('size')
                            ->label('Size')
                            ->numeric()
                            ->required(),

                        TextInput::make('number_of_pits')
                            ->label('Number of Pits')
                            ->numeric()
                            ->required(),

                        TextInput::make('number_of_palms')
                            ->label('Number of Palms')
                            ->numeric()
                            ->required(),

                        TextInput::make('cultivation_count')
                            ->label('Cultivation Count')
                            ->numeric()
                            ->required(),

                        TextInput::make('missing_count')
                            ->label('Missing Count')
                            ->numeric()
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
                    ->url(fn ($record) => route('filament.admin.resources.users.edit', $record->user_id))
                    ->openUrlInNewTab(false) // Optional: open in the same tab
                    ->sortable()
                    ->searchable(),

                TextColumn::make('land_number')
                    ->label('Land Number')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('size')
                    ->label('Size')
                    ->sortable(),

                TextColumn::make('number_of_pits')
                    ->label('Pits'),

                TextColumn::make('number_of_palms')
                    ->label('Palms'),

                TextColumn::make('cultivation_count')
                    ->label('Cultivation Count'),

                TextColumn::make('missing_count')
                    ->label('Missing Count'),

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
            'index' => Pages\ListLands::route('/'),
            'create' => Pages\CreateLand::route('/create'),
            'edit' => Pages\EditLand::route('/{record}/edit'),
        ];
    }
}
