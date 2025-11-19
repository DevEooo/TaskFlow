<?php

namespace App\Filament\Resources\WorkProofs;

use App\Filament\Resources\WorkProofs\Pages\CreateWorkProofs;
use App\Filament\Resources\WorkProofs\Pages\EditWorkProofs;
use App\Filament\Resources\WorkProofs\Pages\ListWorkProofs;
use App\Filament\Resources\WorkProofs\Pages\ViewWorkProofs;
use App\Filament\Resources\WorkProofs\Schemas\WorkProofsForm;
use App\Filament\Resources\WorkProofs\Schemas\WorkProofsInfolist;
use App\Filament\Resources\WorkProofs\Tables\WorkProofsTable;
use App\Models\WorkProofs;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WorkProofsResource extends Resource
{
    protected static ?string $model = WorkProofs::class;
    protected static ?string $navigationLabel = 'Bukti Kerja';
    protected static ?string $slug = "bukti-kerja";
    protected static ?string $label = "Data Bukti Kerja";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquaresPlus;

    public static function form(Schema $schema): Schema
    {
        return WorkProofsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkProofsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkProofsTable::configure($table);
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
            'index' => ListWorkProofs::route('/'),
            'create' => CreateWorkProofs::route('/create'),
            'view' => ViewWorkProofs::route('/{record}'),
            'edit' => EditWorkProofs::route('/{record}/edit'),
        ];
    }
}
