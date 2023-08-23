<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\View\View;
use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\CashTransactionRepository;
use App\Http\Requests\CashTransactionStoreRequest;
use App\Http\Requests\CashTransactionUpdateRequest;
use Carbon\Carbon;

class CashTransactionController extends Controller
{
    private $cashTransactionRepository, $startOfWeek, $endOfWeek;

    public function __construct(CashTransactionRepository $cashTransactionRepository)
    {
        $this->cashTransactionRepository = $cashTransactionRepository;
        $this->startOfWeek = now()->startOfWeek()->format('Y-m-d');
        $this->endOfWeek = now()->endOfWeek()->format('Y-m-d');
    }
    public function filter(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $coba = $request->all();
        $start_date = Carbon::parse($coba['start_date'])->startOfDay();
        $end_date = Carbon::parse($coba['end_date'])->endOfDay();

        $cashTransactions = CashTransaction::with('students:id,name')
        ->select('id', 'student_id', 'amount', 'category','date')
        ->whereBetween('date', [$start_date, $end_date])
        ->get();

        $students = Student::select('id', 'student_identification_number', 'name')
            ->whereDoesntHave(
                'cash_transactions',
                fn (Builder $query) => $query->select(['date'])
                    ->whereBetween('date', [$start_date, $end_date])
            )->get();
        // $cashTransactions = CashTransaction::whereBetween('date', [$start_date, $end_date])->get();
        if (request()->ajax()) {
                return datatables()->of($cashTransactions)
                    ->addIndexColumn()
                    ->addColumn('amount', fn ($model) => indonesianCurrency($model->amount))
                    ->addColumn('category', fn ($model) => $model->category)
                    ->addColumn('date', fn ($model) => date('d-m-Y', strtotime($model->date)))
                    ->addColumn('action', 'cash_transactions.datatable.action')
                    ->rawColumns(['action'])
                    ->toJson();
            }

        return view('cash_transactions.index', [
            'cashTransactions' => $cashTransactions,
            'data' => $this->cashTransactionRepository->results(),
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(): View|JsonResponse
    {
        $cashTransactions = CashTransaction::with('students:id,name')
            ->select('id', 'student_id', 'amount', 'category','date')
            // ->whereBetween('date', [$this->startOfWeek, $this->endOfWeek])
            ->latest()
            ->get();

        $students = Student::select('id', 'student_identification_number', 'name')
            ->whereDoesntHave(
                'cash_transactions',
                fn (Builder $query) => $query->select(['date'])
                    // ->whereBetween('date', [$this->startOfWeek, $this->endOfWeek])
            )->get();

        if (request()->ajax()) {
            return datatables()->of($cashTransactions)
                ->addIndexColumn()
                ->addColumn('amount', fn ($model) => indonesianCurrency($model->amount))
                ->addColumn('category', fn ($model) => $model->category)
                ->addColumn('date', fn ($model) => date('d-m-Y', strtotime($model->date)))
                ->addColumn('action', 'cash_transactions.datatable.action')
                ->rawColumns(['action'])
                ->toJson();
        }

        $cashTransactionTrashedCount = CashTransaction::onlyTrashed()->count();

        return view('cash_transactions.index', [
            'students' => $students,
            'data' => $this->cashTransactionRepository->results(),
            'cashTransactionTrashedCount' => $cashTransactionTrashedCount,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CashTransactionStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CashTransactionStoreRequest $request): RedirectResponse
    {
        foreach ($request->student_id as $student_id) {
            Auth::user()->cash_transactions()->create([
                'student_id' => $student_id,
                'amount' => $request->amount,
                'category' => $request->category,
                'date' => $request->date,
            ]);
        }

        return redirect()->route('cash-transactions.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CashTransactionUpdateRequest  $request
     * @param  \App\Models\CashTransaction  $cashTransaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CashTransactionUpdateRequest $request, CashTransaction $cashTransaction): RedirectResponse
    {
        $cashTransaction->update($request->validated());
        // Proses input category sebagai array
        $selectedCategories = $request->input('category', []);

        // Ubah array category menjadi JSON (jika diperlukan)
        $jsonCategories = json_encode($selectedCategories);

        // Simpan ke dalam basis data
        $cashTransaction->category = $jsonCategories;

        // Tambahkan logika untuk mengelola "Lain Lain"
        if (in_array('Lain Lain', $selectedCategories)) {
            $cashTransaction->lain_lain_value = $request->input('lain_lain_value');
            $cashTransaction->lain_lain_hidden = $request->input('lain_lain_hidden');
        } else {
            $cashTransaction->lain_lain_value = null;
            $cashTransaction->lain_lain_hidden = null;
        }

        return redirect()->route('cash-transactions.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CashTransaction  $cashTransaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(CashTransaction $cashTransaction): RedirectResponse
    {
        $cashTransaction->delete();

        return redirect()->route('cash-transactions.index')->with('success', 'Data berhasil dihapus!');
    }
    public function show($id)
    {
        $cashTransaction = CashTransaction::find($id);

        return view ('cash_transactions.show', compact('cashTransaction'));
    }

    public function edit($id)
    {
        $cashTransaction = CashTransaction::find($id);
        return view('cash_transactions.edit', compact('cashTransaction'));
    }
}
