<?php

namespace App\Filament\Resources\User\Absensis;

use App\Filament\Resources\User\Absensis\Pages\CreateAbsensi;
use App\Filament\Resources\User\Absensis\Pages\ListAbsensis;
use App\Models\Absensi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components;
use Filament\Schemas\Components\Section;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;
    protected static ?string $slug = "absensi-karyawan";
    protected static ?string $label = "Absensi Kehadiran";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    // 1. Tambahkan/Ubah Metode ini: PENTING UNTUK REDIRECT INDEX -> CREATE
    public static function getUrl(string|null $name = null, array $parameters = [], bool $isAbsolute = true, string|null $panel = null, Model|null $tenant = null, bool $shouldGuessMissingParameters = false): string
    {
        // Logika pengalihan (redirect) tetap sama
        // Kita memaksa semua akses mengarah ke route 'create'
        return parent::getUrl('create', $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }

    // 2. Metode Form: Panggil skema Form Anda di sini
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
           Section::make('Input Kehadiran')
                ->schema([
                    // FIELD KRUSIAL: STATUS (Untuk Check-in/Check-out)
                    Components\Radio::make('status')
                        ->label('Tipe Absensi')
                        ->options([
                            'check_in' => 'Check In (Masuk)',
                            'check_out' => 'Check Out (Pulang)',
                        ])
                        ->required()
                        ->inline(), // Tampilkan dalam satu baris

                    // Catatan Harian (Diperlukan untuk laporan)
                    Components\Textarea::make('notes')
                        ->label('Catatan/Keterangan')
                        ->rows(2)
                        ->helperText('Diisi saat Check In (misalnya: agenda hari ini) atau Check Out (misalnya: hasil kerja hari ini).')
                        ->columnSpanFull(),
                ])->columns(1), // Semua field tampil dalam satu kolom
        ]);
    }

    // 3. Metode Table: Wajib ada, tapi dikosongkan
    public static function table(Table $table): Table
    {
        return $table
            ->columns([]); // Kosongkan kolom agar tidak menampilkan data
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // 4. Metode Pages: Hanya butuh 'create' yang diarahkan ke root path
    public static function getPages(): array
    {
        return [
            // Hapus 'index' dan 'edit'. Route 'create' kita set sebagai root.
             'index' => ListAbsensis::route('/'),
            'create' => CreateAbsensi::route('/create'),
        ];
    }
    // Matikan kemampuan untuk View dan Edit agar user tidak bisa memanipulasi data yang sudah masuk
    public static function canViewAny(): bool
    {
        return true;
    } // Tetap true agar link muncul
    public static function canEdit(Model $record): bool
    {
        return false;
    }
    public static function canDelete(Model $record): bool
    {
        return false;
    }

}
