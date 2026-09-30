<?php

namespace App\Filament\Resources\CashExpenses;

use App\Filament\Resources\CashExpenses\Pages\CreateCashExpense;
use App\Filament\Resources\CashExpenses\Pages\EditCashExpense;
use App\Filament\Resources\CashExpenses\Pages\ListCashExpenses;
use App\Filament\Resources\CashExpenses\Schemas\CashExpenseForm;
use App\Filament\Resources\CashExpenses\Tables\CashExpensesTable;
use App\Models\CashExpense;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CashExpenseResource extends Resource
{
    protected static ?string $model = CashExpense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpOnSquare;

protected static ?string $navigationLabel = 'Pengeluaran Kas';

protected static ?string $modelLabel = 'Pengeluaran Kas';

protected static ?string $pluralModelLabel = 'Pengeluaran Kas';

protected static ?string $recordTitleAttribute = 'description';

    public static function form(Schema $schema): Schema
    {
        return CashExpenseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CashExpensesTable::configure($table);
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
            'index' => ListCashExpenses::route('/'),
            'create' => CreateCashExpense::route('/create'),
            'edit' => EditCashExpense::route('/{record}/edit'),
        ];
    }
}
