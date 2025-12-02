<?php

namespace App\Filament\Resources\User\Absensis;

use App\Filament\Resources\User\Absensis\Pages\CreateAbsensi;
use App\Filament\Resources\User\Absensis\Pages\ListAbsensis;
use App\Models\Absensi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components;
use Filament\Schemas\Components\Section;
use Carbon\Carbon; // Tambahkan import Carbon untuk manipulasi tanggal

class UserAbsensiResource extends Resource
{

    protected static ?string $model = Absensi::class;
    protected static ?string $slug = "absensi-karyawan";
    protected static ?string $label = "Absensi Kehadiran";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    // 1. Metode getUrl (Dipertahankan agar redirect ke 'create')
    public static function getUrl(string|null $name = null, array $parameters = [], bool $isAbsolute = true, string|null $panel = null, Model|null $tenant = null, bool $shouldGuessMissingParameters = false): string
    {
        // Kita memaksa semua akses mengarah ke route 'create'
        if ($name === 'index') {
            return parent::getUrl('create', $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
        }
        return parent::getUrl($name, $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }

    // 2. Metode Form: Ditambahkan Section Status Dinamis
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            // --- SECTION STATUS KEHADIRAN HARI INI (BARU) ---
            Section::make('Status Kehadiran Hari Ini')
                ->schema([
                    Components\Placeholder::make('status_text')
                        ->label('') 
                        // ⭐ LOGIKA DINAMIS DIISOLASI DALAM CLOSURE INI
                        ->content(function () {
                            $userId = auth()->id();
                            
                            // Cek keamanan jika Auth belum siap (mencegah Resource hilang)
                            if (!$userId) {
                                return 'Memuat status kehadiran...';
                            }

                            $today = Carbon::today()->toDateString();
                            
                            // Query data absensi hari ini (menggunakan 'check_in' dan 'check_out' sesuai CreateAbsensi.php)
                            $currentAbsensi = Absensi::where('user_id', $userId)
                                ->where(function ($query) use ($today) {
                                    // Cek berdasarkan tanggal check_in atau check_out
                                    $query->whereDate('check_in', $today) 
                                          ->orWhereDate('check_out', $today);
                                })
                                ->first();

                            $statusMessage = 'Anda belum Check-in hari ini.';
                            
                            if ($currentAbsensi) {
                                $checkInTime = $currentAbsensi->check_in 
                                    ? Carbon::parse($currentAbsensi->check_in)->format('H:i') 
                                    : '-';
                                
                                if ($currentAbsensi->check_out) {
                                    $checkOutTime = Carbon::parse($currentAbsensi->check_out)->format('H:i');
                                    $statusMessage = "Status: Selesai (Check-in: {$checkInTime}, Check-out: {$checkOutTime})";
                                } else {
                                    $statusMessage = "Status: Sedang Bekerja (Check-in: {$checkInTime})";
                                }
                            }
                            
                            return $statusMessage;
                        })
                        // Logika warna dipindahkan ke extraAttributes closure
                        ->extraAttributes(function (Components\Placeholder $component) {
                            $status = 'warning'; 
                            
                            $userId = auth()->id();
                            if ($userId) {
                                $today = Carbon::today()->toDateString();
                                $currentAbsensi = Absensi::where('user_id', $userId)
                                    ->where(function ($query) use ($today) {
                                        $query->whereDate('check_in', $today)
                                              ->orWhereDate('check_out', $today);
                                    })
                                    ->first();
                                
                                if ($currentAbsensi) {
                                    $status = $currentAbsensi->check_out ? 'success' : 'info';
                                }
                            }

                            return [
                                'class' => "p-4 rounded-lg text-lg font-bold text-{$status}-600 bg-{$status}-50 border border-{$status}-200",
                            ];
                        }),
                ])->columns(1), 
            // --- END OF SECTION STATUS ---


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

    // 4. Metode Pages: Dipertahankan
    public static function getPages(): array
    {
        return [
            'index' => ListAbsensis::route('/'),
            'create' => CreateAbsensi::route('/create'),
        ];
    }

    // Matikan kemampuan untuk View dan Edit agar user tidak bisa memanipulasi data yang sudah masuk
    public static function canViewAny(): bool
    {
        return true; // Tetap true agar link muncul
    } 
    public static function canEdit(Model $record): bool
    {
        return false;
    }
    public static function canDelete(Model $record): bool
    {
        return false;
    }
}