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
use Carbon\Carbon;
use Filament\Schemas\Components\Utilities\Get;

class UserAbsensiResource extends Resource
{

    protected static ?string $model = Absensi::class;
    protected static ?string $slug = "absensi-karyawan";
    protected static ?string $label = "Absensi Kehadiran";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;
    public static function getUrl(string|null $name = null, array $parameters = [], bool $isAbsolute = true, string|null $panel = null, Model|null $tenant = null, bool $shouldGuessMissingParameters = false): string
    {
        if ($name === 'index') {
            return parent::getUrl('create', $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
        }
        return parent::getUrl($name, $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }
    public static function getTodayAbsensiStatus(): array
    {
        $userId = auth()->id();
        if (!$userId) {
            return ['status' => 'unauthenticated', 'absensi' => null];
        }

        $today = Carbon::today()->toDateString();
        $absensi = Absensi::where('user_id', $userId)
            ->where(fn($query) => $query->whereDate('check_in', $today)->orWhereDate('check_out', $today))
            ->first();

        if (!$absensi) {
            return ['status' => 'pending_in', 'absensi' => null];
        }
        if ($absensi->check_out) {
            return ['status' => 'done', 'absensi' => $absensi];
        }
        return ['status' => 'pending_out', 'absensi' => $absensi];
    }
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Status Kehadiran Hari Ini')
                ->schema([
                    Components\Placeholder::make('status_text')
                        ->label('')
                        ->content(function () {
                            $data = self::getTodayAbsensiStatus();
                            $absensi = $data['absensi'];

                            switch ($data['status']) {
                                case 'done':
                                    $checkIn = Carbon::parse($absensi->check_in)->format('H:i');
                                    $checkOut = Carbon::parse($absensi->check_out)->format('H:i');
                                    return "Status: Selesai (Check-in: {$checkIn}, Check-out: {$checkOut}). Tidak ada aksi yang diperlukan.";
                                case 'pending_out':
                                    $checkIn = Carbon::parse($absensi->check_in)->format('H:i');
                                    return "Status: Sedang Bekerja (Check-in: {$checkIn}). Anda harus Check Out untuk menyelesaikan hari.";
                                case 'pending_in':
                                default:
                                    return 'Anda belum Check-in hari ini. Silakan Check In.';
                            }
                        })
                        ->extraAttributes(function () {
                            $status = self::getTodayAbsensiStatus()['status'];
                            $color = match ($status) {
                                'done' => 'success',
                                'pending_out' => 'info',
                                default => 'warning',
                            };

                            return [
                                'class' => "p-4 rounded-lg text-lg font-bold text-{$color}-600 bg-{$color}-50 border border-{$color}-200",
                            ];
                        }),
                ])->columns(1),

            Section::make('Input Kehadiran')
                ->hidden(fn() => self::getTodayAbsensiStatus()['status'] === 'done')
                ->schema([
                    Components\Radio::make('status')
                        ->label('Tipe Absensi')
                        ->live()
                        ->options(function () {
                            $status = self::getTodayAbsensiStatus()['status'];
                            $options = [
                                'check_in' => 'Check In (Masuk)',
                                'check_out' => 'Check Out (Pulang)',
                            ];

                            if ($status === 'pending_out') {
                                unset($options['check_in']);
                            } elseif ($status === 'pending_in') {
                                unset($options['check_out']);
                            }
                            return $options;
                        })
                        ->default(function () {
                            $status = self::getTodayAbsensiStatus()['status'];
                            if ($status === 'pending_out') {
                                return 'check_out';
                            } elseif ($status === 'pending_in') {
                                return 'check_in';
                            }
                            return null;
                        })
                        ->required()
                        ->inline(),

                    Components\Textarea::make('notes')
                        ->label('Catatan/Keterangan')
                        ->rows(2)
                        ->helperText(function (Get $get) {
                            $status = $get('status');
                            if ($status === 'check_in') {
                                return 'Tuliskan rencana/agenda kerja utama Anda hari ini (misalnya: meeting klien, menyelesaikan laporan X).';
                            } elseif ($status === 'check_out') {
                                return 'Tuliskan ringkasan hasil kerja/pencapaian utama Anda hari ini.';
                            }
                            return 'Diisi saat Check In atau Check Out.';
                        })
                        ->columnSpanFull(),
                ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAbsensis::route('/'),
            'create' => CreateAbsensi::route('/create'),
        ];
    }

    public static function canViewAny(): bool
    {
        return true;
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