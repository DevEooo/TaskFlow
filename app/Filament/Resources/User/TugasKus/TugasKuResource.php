<?php

namespace App\Filament\Resources\User\TugasKus;

use App\Filament\Resources\User\TugasKus\Pages\EditTugasKu;
use App\Filament\Resources\User\TugasKus\Pages\ListTugasKus;
use App\Models\Tugas;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Filament\Actions\EditAction;

class TugasKuResource extends Resource
{
    protected static ?string $model = Tugas::class;
    protected static ?string $slug = "list-tugas";
    protected static ?string $navigationLabel = 'Tugas Saya';
    protected static ?string $label = "Daftar Tugas Saya";
    protected static string|UnitEnum|null $navigationGroup = 'Kelola';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function canCreate(): bool
    {
        return false;
    }
    public static function form(Schema $schema): Schema
    {
        // Form ini akan digunakan untuk 'Edit' (menyelesaikan tugas)
        return $schema->schema([
            // ... Form untuk menyelesaikan tugas (akan kita buat nanti)
        ]);
    }

    // Global Scope: Filter hanya tugas milik user yang login
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('created_at')
                    ->label('Ditugaskan')
                    ->date('d M Y')
                    ->sortable(),

                Columns\TextColumn::make('title')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->sortable(),

                Columns\TextColumn::make('location')
                    ->label('Penempatan')
                    ->badge()
                    ->color('info'), // badge warna biru terang

                Columns\TextColumn::make('task_description')
                    ->label('Deskripsi Singkat')
                    ->limit(30) // Batasi deskripsi agar tabel tidak terlalu lebar
                    ->tooltip(fn($state) => $state), // Tambahkan tooltip untuk melihat deskripsi penuh

                Columns\TextColumn::make('shift.name')
                    ->label('Shift Terkait')
                    ->placeholder('-'),

                Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'Pending' => 'warning',
                        'In Progress' => 'info',
                        'Complete' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Columns\TextColumn::make('completed_at')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-'),
            ])
            ->actions([
                EditAction::make()
                    ->label('Ambil / Selesaikan Tugas'),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => ListTugasKus::route('/'),
            // Edit page ini untuk proses penyelesaian tugas
            'edit' => EditTugasKu::route('/{record}/edit'),
        ];
    }
}
