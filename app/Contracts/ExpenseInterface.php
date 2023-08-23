<?php

namespace App\Contracts;

interface ExpenseInterface
{
    public function sumAmountBy(string $status, string $year = null, string $month = null): Int;
    public function results(): array;
}
