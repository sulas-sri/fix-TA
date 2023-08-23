<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Billing;
use App\Models\Student;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BillingRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\BillingStoreRequest;
use App\Http\Requests\BillingUpdateRequest;
use App\Notifications\TelegramNotification;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Telegram\Bot\Api;
use Str;
use Midtrans;

class BillingController extends Controller
{
    private $billingRepository, $startOfWeek, $endOfWeek;

    public function __construct(BillingRepository $billingRepository)
    {
        $this->billingRepository = $billingRepository;
        $this->startOfWeek = now()->startOfWeek()->format('Y-m-d');
        $this->endOfWeek = now()->endOfWeek()->format('Y-m-d');

        // Set your Merchant Server Key
        Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Midtrans\Config::$is3ds = true;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(): View|JsonResponse
    {
        $billings = Billing::with('students:id,name')
            ->select('id', 'student_id', 'id_telegram', 'bill', 'kategori_tagihan','date')
            ->whereBetween('date', [$this->startOfWeek, $this->endOfWeek])
            ->latest()
            ->get();

        $students = Student::select('id', 'student_identification_number', 'name')
            ->whereDoesntHave(
                'billings',
                fn (Builder $query) => $query->select(['date'])
                    ->whereBetween('date', [$this->startOfWeek, $this->endOfWeek])
            )->get();

        if (request()->ajax()) {
            return datatables()->of($billings)
                ->addIndexColumn()
                ->addColumn('bill', fn ($model) => indonesianCurrency($model->bill))
                ->addColumn('date', fn ($model) => date('d-m-Y', strtotime($model->date)))
                ->addColumn('id_telegram', fn ($model) => $model->id_telegram)
                ->addColumn('kategori_tagihan', fn ($model) => $model->kategori_tagihan)
                ->addColumn('notification', 'billings.datatable.notification')
                ->rawColumns(['notification'])
                ->addColumn('action', 'billings.datatable.action')
                ->rawColumns(['action'])
                ->toJson();
        }

        $billingTrashedCount = Billing::onlyTrashed()->count();

        return view('billings.index', [
            'billings' => $billings,
            'students' => $students,
            'data' => $this->billingRepository->results(),
            'billingTrashedCount' => $billingTrashedCount
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\BillingStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BillingStoreRequest $request): RedirectResponse
    {
        // dd($request->all());
        foreach ($request->student_id as $student_id) {
            $kategoryString = implode(',', $request->kategory_tagihan);

            // foreach ($request->kategory_tagihan as $coba) {
            //     $billing = Auth::user()->billings()->create([
            //         'student_id' => $student_id,
            //         'bill' => $request->bill,
            //         'date' => $request->date,
            //         'kategori_tagihan' => $coba,
            //         'id_telegram' => $request->id_telegram,
            //     ]);
            // }
            $billing = Auth::user()->billings()->create([
                'student_id' => $student_id,
                'bill' => $request->bill,
                'date' => $request->date,
                'kategori_tagihan' => $kategoryString,
                'id_telegram' => $request->id_telegram,
            ]);

            // $this->getSnapRedirect($billing);
        }

        return redirect()->route('billings.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function __invoke()
    {
        // Logika dan proses untuk halaman index billings
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\BillingUpdateRequest  $request
     * @param  \App\Models\Billing  $billing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BillingUpdateRequest $request, Billing $billing): RedirectResponse
    {
        $billing->update($request->validated());
        $selectedCategories = $request->input('kategori_tagihan', []);

        // Ubah array category menjadi JSON (jika diperlukan)
        $jsonCategories = json_encode($selectedCategories);

        // Simpan ke dalam basis data
        $billing->category = $jsonCategories;

        // Tambahkan logika untuk mengelola "Lain Lain"
        if (in_array('Lain Lain', $selectedCategories)) {
            $billing->lain_lain_value = $request->input('lain_lain_value');
            $billing->lain_lain_hidden = $request->input('lain_lain_hidden');
        } else {
            $billing->lain_lain_value = null;
            $billing->lain_lain_hidden = null;
        }

        return redirect()->route('billings.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Billing  $billing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Billing $billing): RedirectResponse
    {
        $billing->delete();

        return redirect()->route('billings.index')->with('success', 'Data berhasil dihapus!');
    }

    public function sendNotification(Billing $billing)
    {
        // Pastikan ID Telegram tidak kosong
        if ($billing->id_telegram) {
            // Mengirim notifikasi ke chat ID yang telah ditentukan
            $billing->notify(new TelegramNotification($billing->bill, $billing->kategori_tagihan, $billing->id_telegram));
            return redirect()->route('billings.index')->with('success', 'Notifikasi telah dikirim!');
        } else {
            return redirect()->route('billings.index')->with('error', 'Gagal mengirim notifikasi. Tagihan tidak memiliki ID Telegram.');
        }
    }

    // public function sendNotificationToAll()
    // {
    //     // Ambil semua data tagihan
    //     $billings = Billing::all();

    //     // Buat array untuk menyimpan data tagihan yang berhasil dikirim notifikasi
    //     $successBillings = [];

    //     // Looping untuk mengirim notifikasi menggunakan TelegramNotification untuk setiap data tagihan
    //     foreach ($billings as $billing) {
    //         // Pastikan ID Telegram tidak kosong sebelum mengirim notifikasi
    //         if ($billing->id_telegram) {
    //             $billing->notify(new TelegramNotification($billing->bill, $billing->kategori_tagihan, $billing->id_telegram));
    //             $successBillings[] = $billing;
    //         }
    //     }

    //     // Jika ada data tagihan yang berhasil dikirim notifikasi, tampilkan pesan berhasil
    //     if (count($successBillings) > 0) {
    //         return response()->json(['success' => true]);
    //     } else {
    //         return response()->json(['success' => false]);
    //     }
    // }

    // public function getSnapRedirect(Billing $billing)
    // {
    //     $orderId = $billing->id.'-'.Str::random(5);
    //     $billing->midtrans_booking_code = $orderId;

    //     $transaction_details = [
    //         'order_id' => $orderId,
    //         'gross_amount' => $billing->bill
    //     ];

    //     $items_details[] = [
    //         'id' => $orderId,
    //         'name' => $billing->category
    //     ];

    //     $userData = [
    //         "first_name" => $billing->students->name
    //     ];

    //     $customer_details = [
    //         "first_name" => $billing->students->name
    //     ];

    //     $midtrans_params = [
    //         'transaction_details' => $transaction_details,
    //         'customer_details' => $customer_details,
    //         'item_details' => $items_details,
    //     ];

    //     try {
    //         $paymentUrl = \Midtrans\Snap::createBilling(midtrans_params)->redirect_url;
    //         $billing->midtrans_url = $paymentUrl;
    //         $billing->save();

    //         return paymentUrl;
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }

    // public function midtransCallback(Request $request)
    // {
    //     $notif = new \Midtrans\Notification(); // Perbaiki dengan menggunakan namespace yang benar

    //     $transaction_status = $notif->transaction_status;
    //     $fraud = $notif->fraud_status;

    //     $billing_id = explode('-', $notif->order_id)[0];
    //     $billing = Billing::find($billing_id); // Tambahkan tanda semicolon di akhir baris ini

    //     if ($transaction_status == 'capture') {
    //         if ($fraud == 'challenge') {
    //             // TODO Set payment status in merchant's database to 'challenge'
    //             $billing->status = 'unpaid';
    //         } else if ($fraud == 'accept') {
    //             // TODO Set payment status in merchant's database to 'success'
    //             $billing->status = 'paid';
    //         }
    //     } else if ($transaction_status == 'cancel') {
    //         if ($fraud == 'challenge') {
    //             // TODO Set payment status in merchant's database to 'failure'
    //             $billing->status = 'failed';
    //         } else if ($fraud == 'accept') {
    //             // TODO Set payment status in merchant's database to 'failure'
    //             $billing->status = 'failed';
    //         }
    //     } else if ($transaction_status == 'deny') {
    //         // TODO Set payment status in merchant's database to 'failure'
    //         $billing->status = 'failed';
    //     } else if ($transaction_status == 'settlement') {
    //         // TODO set payment status in merchant's database to 'Settlement'
    //         $billing->status = 'paid';
    //     } else if ($transaction_status == 'pending') {
    //         // TODO set payment status in merchant's database to 'Pending'
    //         $billing->status = 'pending';
    //     } else if ($transaction_status == 'expire') {
    //         // TODO set payment status in merchant's database to 'expire'
    //         $billing->status = 'failed';
    //     }

    //     $billing->save();
    //     return view('billing.success'); // Tambahkan tanda semicolon di akhir baris ini
    // }

}
