<?php

namespace App\Filament\Resources\MediaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';
    protected static ?string $recordTitleAttribute = 'file_path'; // Adjust this to your model's attribute

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('file_path')
                    ->label('File Path')
                    ->directory('media-images')
                    ->preserveFilenames()
                    ->getUploadedFileNameForStorageUsing(function ($file) {
                        $uniqueId = Str::uuid();
                        $extension = $file->getClientOriginalExtension();
                        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        return str_replace(' ', '_', $filename) . '_' . $uniqueId . '.' . $extension;
                    })
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif'])
                    ->required(),
                DatePicker::make('date')
                    ->label('Date')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file_path')
            ->columns([
                TextColumn::make('file_path')
                    ->label('File Path')
                    ->formatStateUsing(fn($state) => basename($state))
                    ->url(fn($record) => Storage::url($record->file_path), true),
                TextColumn::make('date')
                    ->label('Date')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
