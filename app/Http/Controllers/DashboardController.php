<?php

namespace App\Http\Controllers;

use App\Models\CashTransaction;
use App\Models\SchoolClass;
use App\Models\SchoolMajor;
use App\Models\Student;
use App\Models\Transaction;
use App\Repositories\CashTransactionReportRepository;
use App\Repositories\CashTransactionRepository;
use App\Repositories\ExpenseRepository;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private CashTransactionRepository $cashTransactionRepository,
        private CashTransactionReportRepository $cashTransactionReportRepository,
        private ExpenseRepository $expenseRepository,
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke(): View
    {
        $amountThisMonth = indonesianCurrency($this->cashTransactionRepository->sumAmountBy('month', month: date('m')));
        $filteredResult = [];
        $startDate = request()->get('start_date');
        $endDate = request()->get('end_date');

        if (request()->has('start_date') && request()->has('end_date')) {
            if ($startDate === null && $endDate === null) {
                return redirect()->back()->with('warning', 'Tanggal awal atau tanggal akhir tidak boleh kosong!');
            }

            $filteredResult = $this->cashTransactionReportRepository->filterByDateStartAndEnd($startDate, $endDate);
        }

        $sumIncome = [
            'thisDay' => indonesianCurrency($this->cashTransactionReportRepository->sum('amount', 'thisDay')),
            'thisWeek' => indonesianCurrency($this->cashTransactionReportRepository->sum('amount', 'thisWeek')),
            'thisMonth' => indonesianCurrency($this->cashTransactionReportRepository->sum('amount', 'thisMonth')),
            'thisYear' => indonesianCurrency($this->cashTransactionReportRepository->sum('amount', 'thisYear')),
        ];

        $sumExpense = [
            'thisDay' => indonesianCurrency($this->expenseRepository->sum('amount', 'thisDay')),
            'thisWeek' => indonesianCurrency($this->expenseRepository->sum('amount', 'thisWeek')),
            'thisMonth' => indonesianCurrency($this->expenseRepository->sum('amount', 'thisMonth')),
            'thisYear' => indonesianCurrency($this->expenseRepository->sum('amount', 'thisYear')),
        ];

        return view('dashboard.index', [
            'studentCount' => Student::count(),
            'schoolClassCount' => SchoolClass::count(),
            'sumIncome' => $sumIncome,
            'sumExpense' => $sumExpense,
            'filteredResult' => $filteredResult
        ]);
    }
}
