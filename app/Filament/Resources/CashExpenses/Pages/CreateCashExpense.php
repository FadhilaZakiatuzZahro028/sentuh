<?php

namespace App\Filament\Resources\CashExpenses\Pages;

use App\Filament\Resources\CashExpenses\CashExpenseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCashExpense extends CreateRecord
{
    protected static string $resource = CashExpenseResource::class;
}
