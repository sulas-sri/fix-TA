<?php

namespace App\Repositories;

use App\Contracts\ExpenseInterface;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;

class ExpenseRepository implements ExpenseInterface
{
    private $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function sumAmountBy(string $status, string $year = null, string $month = null): Int
    {
        $model = $this->model->select('date', 'amount');

        return $status === 'year'
            ? $model->whereYear('date', $year)->sum('amount')
            : $model->whereYear('date', date('Y'))->whereMonth('date', $month)->sum('amount');
    }

    public function results(): array
    {
        return [
            'totals' => [
                'thisMonth' => indonesianCurrency($this->sumAmountBy('month', month: date('m'))),
                'thisYear' => indonesianCurrency($this->sumAmountBy('year', year: date('Y'))),
            ]
        ];
    }

    public function sum(string $column, string $type): Int
    {
        $model = $this->model
            ->select('date', 'amount')
            ->whereYear('date', date('Y'));

        match ($type) {
            'thisDay' => $model->whereDay('date', date('d')),
            'thisWeek' => $model->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]),
            'thisMonth' => $model->whereMonth('date', date('m')),
            'thisYear' => $model->whereYear('date', date('Y'))
        };

        return $model->sum($column);
    }

    public function filterByDateStartAndEnd(string $start, string $end): array
    {
        $filteredResult = [];

        $startDate = date('Y-m-d', strtotime($start));
        $endDate = date('Y-m-d', strtotime($end));

        $transactions = $this->model->select('date', 'description', 'amount')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')->get();

        $filteredResult['transactions'] = $transactions;
        $filteredResult['sumOfAmount'] = $transactions->sum('amount');
        $filteredResult['startDate'] = date('d-m-Y', strtotime($startDate));
        $filteredResult['endDate'] = date('d-m-Y', strtotime($endDate));

        return $filteredResult;
    }
}
