<?php

namespace App\Filament\User\Resources\User\BuktiKerjas;

use App\Filament\User\Resources\User\BuktiKerjas\Pages\CreateBuktiKerja;
use App\Filament\User\Resources\User\BuktiKerjas\Pages\EditBuktiKerja;
use App\Filament\User\Resources\User\BuktiKerjas\Pages\ListBuktiKerjas;
use App\Filament\User\Resources\User\BuktiKerjas\Schemas\BuktiKerjaForm;
use App\Filament\User\Resources\User\BuktiKerjas\Tables\BuktiKerjasTable;
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
    protected static ?string $label = "Upload Bukti Kerja";
    protected static ?string $navigationLabel = 'Upload';
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Tugas';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCamera;

    public static function form(Schema $schema): Schema
    {
        return BuktiKerjaForm::configure($schema);
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
            'edit' => EditBuktiKerja::route('/{record}/edit'),
        ];
    }
}
