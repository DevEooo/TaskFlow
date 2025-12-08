<?php

namespace App\Filament\Resources\Admin\JadwalShifts;

use Filament\Tables\Filters\SelectFilter;
use App\Models\JadwalShift;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;
use Filament\Tables\Columns;
use Filament\Forms\Components;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Validation\Rules\Unique;
use Filament\Actions\EditAction; 
use Filament\Actions\DeleteAction; 

class JadwalShiftResource extends Resource
{
    protected static ?string $model = JadwalShift::class;
    protected static ?string $navigationLabel = 'Jadwal Shift';
    protected static ?string $slug = "jadwal-shift";
    protected static ?string $label = "Jadwal Shift Karyawan";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Shift';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('shift')->with('shift');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Karyawan')
                    ->required()
                    ->placeholder('Pilih Karyawan (Role User)'),
                
                Components\Select::make('shift_id')
                    ->relationship('shift', 'name')
                    ->label('Shift Kerja')
                    ->required(),
                    
                Components\DatePicker::make('date')
                    ->label('Tanggal Shift')
                    ->minDate(now()->subMonth())
                    ->required()
                    ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule, Get $get) {
                        return $rule->where('user_id', $get('user_id')); 
                    }),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                    
                Columns\TextColumn::make('user.name')
                    ->label('Karyawan')
                    ->searchable()
                    ->sortable(),
                
                Columns\TextColumn::make('shift.name')
                    ->label('Shift')
                    ->badge()
                    ->sortable(),
                    
                Columns\TextColumn::make('shift.start_time')
                    ->label('Jam Mulai')
                    ->time('H:i'),
                    
                Columns\TextColumn::make('shift.end_time')
                    ->label('Jam Selesai')
                    ->time('H:i'),
            ])
            ->filters([
                SelectFilter::make('shift_id')
                    ->relationship('shift', 'name')
                    ->label('Filter Jadwal Shift')
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(), 
            ])
            ->defaultSort('date', 'desc');
            
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwalShifts::route('/'),
            'edit' => Pages\EditJadwalShift::route('/{record}/edit'),
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
