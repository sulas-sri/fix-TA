<?php

namespace App\Http\Controllers;

use App\Models\CashTransaction;
use App\Models\Transaction;
use App\Repositories\CashTransactionReportRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use PHPUnit\Event\Tracer\Tracer;

class CashTransactionReportController extends Controller
{
    public function __construct(
        private  CashTransactionReportRepository $cashTransactionReportRepository
    ) {
    }

    public function index()
    {
        $startDate = request()->get('start_date'); // Tambahkan baris ini
        $endDate = request()->get('end_date');     // Tambahkan baris ini

        // Ambil data pemasukan dari tabel cash_transactions
        $pemasukan = CashTransaction::select('id', 'student_id', 'amount', 'category', 'date')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        // Ambil data pengeluaran dari tabel transactions
        $pengeluaran = Transaction::select('id', 'date', 'description', 'amount')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        // Gabungkan data pemasukan dan pengeluaran dalam satu collection
        $data = new Collection([...$pemasukan, ...$pengeluaran]);

        // Anda juga dapat mengurutkan collection berdasarkan tanggal jika diperlukan
        $data = $data->sortBy('date');

        // ...

        return view('rekapitulasi.index', [
            'data' => $data,
            // ...
        ]);
    }



    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): View|RedirectResponse
    {
        $filteredResult = [];
        $startDate = request()->get('start_date');
        $endDate = request()->get('end_date');

        if (request()->has('start_date') && request()->has('end_date')) {
            if ($startDate === null && $endDate === null) {
                return redirect()->back()->with('warning', 'Tanggal awal atau tanggal akhir tidak boleh kosong!');
            }

            $filteredResult = $this->cashTransactionReportRepository->filterByDateStartAndEnd($startDate, $endDate);
        }

        $sum = [
            'thisDay' => indonesianCurrency($this->cashTransactionReportRepository->sum('amount', 'thisDay')),
            'thisWeek' => indonesianCurrency($this->cashTransactionReportRepository->sum('amount', 'thisWeek')),
            'thisMonth' => indonesianCurrency($this->cashTransactionReportRepository->sum('amount', 'thisMonth')),
            'thisYear' => indonesianCurrency($this->cashTransactionReportRepository->sum('amount', 'thisYear')),
        ];

        return view('reports.index', [
            'sum' => $sum,
            'filteredResult' => $filteredResult
        ]);
    }
}
