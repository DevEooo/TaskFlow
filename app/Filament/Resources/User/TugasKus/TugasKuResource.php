<?php

namespace App\Filament\Resources\User\TugasKus;

use App\Filament\Resources\User\TugasKus\Pages\EditTugasKu;
use App\Filament\Resources\User\TugasKus\Pages\ListTugasKus;
use App\Filament\Resources\User\TugasKus\Schemas\TugasKuForm;
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
use Filament\Tables\Filters\SelectFilter;

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
        return TugasKuForm::configure($schema);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
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
                    ->color('info'),

                Columns\TextColumn::make('task_description')
                    ->label('Deskripsi Singkat')
                    ->limit(30)
                    ->tooltip(fn($state) => $state)
                    ->placeholder('Tidak ada deskripsi'),

                Columns\TextColumn::make('shift.name')
                    ->label('Shift Terkait')
                    ->placeholder('Tidak ada'),

                Columns\TextColumn::make('deadline_at')
                    ->label('Batas Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->color(
                        fn($record) =>
                        ($record->status !== 'Complete' && now() > $record->deadline_at) ? 'danger' :
                        ($record->status !== 'Complete' && now()->diffInHours($record->deadline_at, false) < 2 ? 'warning' : 'gray')
                    )
                    ->description(
                        fn($record) =>
                        ($record->status !== 'Complete' && now() > $record->deadline_at) ? 'Terlewat!' : ''
                    ),

                Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'Pending' => 'warning',
                        'Dalam Proses' => 'info',
                        'Selesai' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Columns\TextColumn::make('completed_at')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'In Progress' => 'Dalam Proses',
                        'Complete' => 'Selesai',
                    ])
                    ->label('Status Tugas'),
                SelectFilter::make('task_type')
                    ->options([
                        'active' => 'Tugas Aktif',
                        'completed' => 'Telah diselesaikan',
                        'missed' => 'Terlewat',
                    ])
                    ->label('Jenis Tugas')
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            'active' => $query->where('status', '!=', 'Selesai')->where(function ($q) {
                                $q->whereNull('deadline_at')->orWhere('deadline_at', '>=', now());
                            }),
                            'completed' => $query->where('status', '=', 'Selesai'),
                            'missed' => $query->where('status', '!=', 'Selesai')->where('deadline_at', '<', now()),
                            default => $query,
                        };
                    }),
                SelectFilter::make('schedule_type')
                    ->options([
                        'today' => 'Hari Ini',
                        'past' => 'Lampau',
                        'upcoming' => 'Mendatang',
                    ])
                    ->label('Jenis Jadwal')
                    ->default('today')
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            'today' => $query->whereDate('deadline_at', today()),
                            'past' => $query->whereDate('deadline_at', '<', today()),
                            'upcoming' => $query->whereDate('deadline_at', '>', today()),
                            default => $query->whereDate('deadline_at', today()),
                        };
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                EditAction::make()
                    ->label('Selesaikan')
                    ->visible(fn ($record) => $record->status !== 'Complete'),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => ListTugasKus::route('/'),
            'edit' => EditTugasKu::route('/{record}/edit'),
        ];
    }
}
