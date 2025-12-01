<?php

namespace App\Filament\Resources\User;

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
use Carbon\Carbon;

class UserAbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;
    protected static ?string $slug = "absensi-karyawan";
    protected static ?string $label = "Absensi Kehadiran";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public static function canViewAny(): bool
    {
        return true;
    } 

     
    public static function getUrl(string|null $name = null, array $parameters = [], bool $isAbsolute = true, string|null $panel = null, Model|null $tenant = null, bool $shouldGuessMissingParameters = false): string
    {
        if ($name === 'index') {
            return parent::getUrl('create', $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
        }
        return parent::getUrl($name, $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }
 
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
             
            Section::make('Status Kehadiran Hari Ini')
                ->schema([
                    Components\Placeholder::make('status_text')
                        ->label('') 
                         
                        ->content(function () {
                            $userId = auth()->id();
                            
                             
                            if (!$userId) {
                                return 'Memuat status kehadiran... (Sesi belum terdeteksi)';
                            }

                            $today = Carbon::today()->toDateString();
                            
                            $currentAbsensi = Absensi::where('user_id', $userId)
                                ->where(function ($query) use ($today) {
                                    $query->whereDate('check_in_time', $today)
                                          ->orWhereDate('check_out_time', $today);
                                })
                                ->first();

                            $statusMessage = 'Anda belum Check-in hari ini.';
                            $statusColor = 'warning'; 

                            if ($currentAbsensi) {
                                $checkInTime = $currentAbsensi->check_in_time 
                                    ? Carbon::parse($currentAbsensi->check_in_time)->format('H:i') 
                                    : '-';
                                
                                if ($currentAbsensi->check_out_time) {
                                    $checkOutTime = Carbon::parse($currentAbsensi->check_out_time)->format('H:i');
                                    $statusMessage = "Status: Selesai (Check-in: {$checkInTime}, Check-out: {$checkOutTime})";
                                    $statusColor = 'success'; 
                                } else {
                                    $statusMessage = "Status: Sedang Bekerja (Check-in: {$checkInTime})";
                                    $statusColor = 'info'; 
                                }
                            }
                            
                            return $statusMessage;
                        })
                        ->extraAttributes(function (Components\Placeholder $component) {
                            // Logic ini tetap dijalankan di Livewire, kita bisa set warna berdasarkan status
                            $status = 'warning'; // Default
                            
                            $userId = auth()->id();
                            if ($userId) {
                                $currentAbsensi = Absensi::where('user_id', $userId)
                                    ->where(function ($query) {
                                        $today = Carbon::today()->toDateString();
                                        $query->whereDate('check_in_time', $today)
                                              ->orWhereDate('check_out_time', $today);
                                    })
                                    ->first();
                                
                                if ($currentAbsensi) {
                                    $status = $currentAbsensi->check_out_time ? 'success' : 'info';
                                }
                            }

                            return [
                                'class' => "p-4 rounded-lg text-lg font-bold text-{$status}-600 bg-{$status}-50 border border-{$status}-200",
                            ];
                        }),
                ])
                ->columnSpan('full'),

            // --- SECTION INPUT (LAMA) ---
            Section::make('Input Kehadiran')
                ->schema([
                    Components\Radio::make('status')
                        ->label('Tipe Absensi')
                        ->options([
                            'check_in' => 'Check In (Masuk)',
                            'check_out' => 'Check Out (Pulang)',
                        ])
                        ->required()
                        ->inline(),

                    Components\Textarea::make('notes')
                        ->label('Catatan/Keterangan')
                        ->rows(2)
                        ->helperText('Isi catatan harian jika diperlukan.')
                        ->columnSpanFull(),
                ])
                ->columns(1),
        ]);
    }

    // =========================================================================
    // 3. KONFIGURASI LAINNYA
    // =========================================================================

    public static function table(Table $table): Table
    {
        return $table->columns([]); // Tabel kosong
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAbsensis::route('/'),
            'create' => CreateAbsensi::route('/create'),
        ];
    }
    
    // Matikan edit/delete karena ini hanya form input log
    public static function canEdit(Model $record): bool { return false; }
    public static function canDelete(Model $record): bool { return false; }
}