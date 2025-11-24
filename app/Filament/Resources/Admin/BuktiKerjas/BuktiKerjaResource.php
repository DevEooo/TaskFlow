<?php

namespace App\Filament\Resources\Admin\BuktiKerjas;

use App\Filament\Resources\Admin\BuktiKerjas\Pages\CreateBuktiKerja;
use App\Filament\Resources\Admin\BuktiKerjas\Pages\EditBuktiKerja;
use App\Filament\Resources\Admin\BuktiKerjas\Pages\ListBuktiKerjas;
use App\Filament\Resources\Admin\BuktiKerjas\Pages\ViewBuktiKerja;
use App\Filament\Resources\Admin\BuktiKerjas\Schemas\BuktiKerjaForm;
use App\Filament\Resources\Admin\BuktiKerjas\Schemas\BuktiKerjaInfolist;
use App\Filament\Resources\Admin\BuktiKerjas\Tables\BuktiKerjasTable;
use App\Models\BuktiKerja;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BuktiKerjaResource extends Resource
{
    protected static ?string $model = BuktiKerja::class;
    protected static ?string $slug = "bukti-kerja";
    protected static ?string $label = "Data Bukti Kerja";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquaresPlus;

    public static function form(Schema $schema): Schema
    {
        return BuktiKerjaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BuktiKerjaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BuktiKerjasTable::configure($table);
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
            'index' => ListBuktiKerjas::route('/'),
            'create' => CreateBuktiKerja::route('/create'),
            'view' => ViewBuktiKerja::route('/{record}'),
            'edit' => EditBuktiKerja::route('/{record}/edit'),
        ];
    }
}
