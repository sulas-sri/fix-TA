<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Repositories\ExpenseRepository;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class TransactionController extends Controller
{
    private $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function filter(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $coba = $request->all();
        $start_date = Carbon::parse($coba['start_date'])->startOfDay();
        $end_date = Carbon::parse($coba['end_date'])->endOfDay();

        $transactions = Transaction::whereBetween('date', [$start_date, $end_date])->get();
        if (request()->ajax()) {
                return datatables()->of($transactions)
                    ->addIndexColumn()
                    ->addColumn('date', fn ($model) => date('d-m-Y', strtotime($model->date)))
                    ->addColumn('description', fn ($model) => $model->description)
                    ->addColumn('amount', fn ($model) => indonesianCurrency($model->amount))
                    ->addColumn('action', 'transactions.datatable.action')
                    ->rawColumns(['action'])
                    ->toJson();
            }

        return view('transactions.index', [
            'transactions' => $transactions,
            'data' => $this->expenseRepository->results(),
        ]);

    }
    /**
     * Menampilkan daftar transaksi keuangan.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View|JsonResponse
    {
        // Menghitung jumlah pemasukan
        // $incomeAmount = Transaction::where('type', 'Pemasukan')->sum('amount');

        // // Menghitung jumlah pengeluaran
        // $expenseAmount = Transaction::where('type', 'Pengeluaran')->sum('amount');

        // Mengambil data transaksi untuk ditampilkan di tabel
        $transactions = Transaction::select('id', 'date', 'description','amount')
            ->latest()
            ->get();


            if (request()->ajax()) {
                return datatables()->of($transactions)
                    ->addIndexColumn()
                    ->addColumn('date', fn ($model) => date('d-m-Y', strtotime($model->date)))
                    ->addColumn('description', fn ($model) => $model->description)
                    ->addColumn('amount', fn ($model) => indonesianCurrency($model->amount))
                    ->addColumn('action', 'transactions.datatable.action')
                    ->rawColumns(['action'])
                    ->toJson();
            }

            return view('transactions.index', [
                'transactions' => $transactions,
                'data' => $this->expenseRepository->results(),
            ]);
    }

    /**
     * Menampilkan formulir tambah transaksi keuangan.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Menyimpan transaksi keuangan baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TransactionStoreRequest $request)
    {
        // Create a new Transaction model and fill it with the form data
        $transaction = new Transaction([
            'date' => $request->date,
            'amount' => $request->amount,
            'description' => $request->description,
            // Fill other attributes as needed
        ]);

        // Ubah format tanggal menjadi 'YYYY-MM-DD' menggunakan Carbon
        $transaction->date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

        // Save the transaction to the database
        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir edit transaksi keuangan.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\View\View
     */
    // public function edit(Transaction $transaction)
    // {
    //     return view('transactions.edit', compact('transaction'));
    // }

    /**
     * Memperbarui transaksi keuangan dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TransactionUpdateRequest $request, Transaction $transaction)
    {
        $transaction->update([
            'date' => $request->date,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi keuangan berhasil diperbarui!');
    }

    /**
     * Menghapus transaksi keuangan dari database.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi keuangan berhasil dihapus!');
    }

    public function show($id)
    {
        $transaction = Transaction::find($id);

        return view ('transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::find($id);
        return view('transactions.edit', compact('transaction'));
    }
}
