<?php

namespace App\Filament\Resources\Admin\Shifts;

use App\Filament\Resources\Admin\Shifts\Pages\ListShifts;
use App\Filament\Resources\Admin\Shifts\Pages\CreateShifts;
use App\Filament\Resources\Admin\Shifts\Pages\EditShifts;
use App\Models\Shift;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Filament\Forms\Components;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

use UnitEnum;

class ShiftsResource extends Resource
{
    protected static ?string $model = Shift::class;
    protected static ?string $navigationLabel = 'Atur Shift Kerja';
    protected static ?string $slug = "atur-shift-kerja";
    protected static ?string $label = "Atur Shift Kerja";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Shift';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\TextInput::make('name')
                    ->label('Nama Shift (contoh: Pagi)')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true), // Nama harus unik
                
                Components\TimePicker::make('start_time')
                    ->label('Jam Mulai')
                    ->seconds(false) // Abaikan detik
                    ->required(),

                Components\TimePicker::make('end_time')
                    ->label('Jam Selesai')
                    ->seconds(false)
                    ->required(),
            ])->columns(2);
    }

    // Tabel untuk melihat daftar shift
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('name')
                    ->label('Nama Shift')
                    ->searchable()
                    ->sortable(),
                
                Columns\TextColumn::make('start_time')
                    ->label('Jam Mulai')
                    ->time('H:i') // Format jam 24 jam
                    ->sortable(),
                    
                Columns\TextColumn::make('end_time')
                    ->label('Jam Selesai')
                    ->time('H:i')
                    ->sortable(),
                    
                Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShifts::route('/'),
            'create' => CreateShifts::route('/create'),
            'edit' => EditShifts::route('/{record}/edit'),
        ];
    }


}
