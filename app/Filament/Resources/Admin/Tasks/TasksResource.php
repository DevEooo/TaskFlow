<?php

namespace App\Filament\Resources\Admin\Tasks;

use App\Filament\Resources\Admin\Tasks\Pages\CreateTasks;
use App\Filament\Resources\Admin\Tasks\Pages\EditTasks;
use App\Filament\Resources\Admin\Tasks\Pages\ListTasks;
use App\Filament\Resources\Admin\Tasks\Schemas\TasksForm;
use App\Filament\Resources\Admin\Tasks\Tables\TasksTable;
use App\Models\Tasks;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class TasksResource extends Resource
{
    protected static ?string $model = Tugas::class;
    protected static ?string $navigationLabel = 'Tugas';
    protected static ?string $slug = "tugas";
    protected static ?string $label = "Data Daftar Tugas";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Data';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    public static function form(Schema $schema): Schema
    {
        return TasksForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TasksTable::configure($table);
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
            'index' => ListTasks::route('/'),
            'create' => CreateTasks::route('/create'),
            'edit' => EditTasks::route('/{record}/edit'),
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
