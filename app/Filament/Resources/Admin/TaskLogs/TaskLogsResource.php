<?php

namespace App\Filament\Resources\Admin\TaskLogs;

use App\Filament\Resources\Admin\TaskLogs\Pages\CreateTaskLogs;
use App\Filament\Resources\Admin\TaskLogs\Pages\EditTaskLogs;
use App\Filament\Resources\Admin\TaskLogs\Pages\ListTaskLogs;
use App\Filament\Resources\Admin\TaskLogs\Schemas\TaskLogsForm;
use App\Filament\Resources\Admin\TaskLogs\Tables\TaskLogsTable;
use App\Models\TaskLogs;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class TaskLogsResource extends Resource
{
    protected static ?string $model = TaskLogs::class;
    protected static ?string $navigationLabel = 'Log Tugas';
    protected static ?string $slug = "log-tugas";
    protected static ?string $label = "Data Log Tugas";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    public static function form(Schema $schema): Schema
    {
        return TaskLogsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TaskLogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTaskLogs::route('/'),
            'create' => CreateTaskLogs::route('/create'),
            'edit' => EditTaskLogs::route('/{record}/edit'),
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

