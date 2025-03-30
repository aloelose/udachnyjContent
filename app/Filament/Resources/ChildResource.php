<?php

// app/Filament/Resources/ChildResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\ChildResource\Pages;
use App\Models\Child;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\NumberInput;

class ChildResource extends Resource
{
    protected static ?string $model = Child::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(255),
                NumberInput::make('age')
                    ->label('Age')
                    ->required()
                    ->minValue(1)
                    ->maxValue(100),
                TextInput::make('status')
                    ->label('Status')
                    ->nullable(),
                TextInput::make('pmpk_code')
                    ->label('PMPK Code')
                    ->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('age')->sortable(),
                Tables\Columns\TextColumn::make('status')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChildren::route('/'),
            'create' => Pages\CreateChild::route('/create'),
            'edit' => Pages\EditChild::route('/{record}/edit'),
        ];
    }
}

