<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\CashTransaction;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Str;
use Midtrans;

class RiwayatPembayaranController extends Controller
{
    public function showHistory()
    {
        // $user = auth()->user()->id;
        // dd($user->id);
        // $cash_transactions = CashTransaction::where('student_id', $user)->get();
        // return view('siswa.riwayat_pembayaran', compact('cash_transactions'));
        $user = auth()->user();

        // Mengecek apakah user yang login adalah siswa
        if ($user->hasRole('siswa')) {
            $student = Student::where('email', $user->email)->first();
            if ($student) {
                $studentId = $student->id;
                $cash_transactions = CashTransaction::where('student_id', $studentId)
                ->with('students.school_class')
                ->get();
                return view('siswa.riwayat_pembayaran', compact('cash_transactions'));
            } else {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
            }
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melihat riwayat pembayaran.');
        }
    }

    public function showTagihan()
    {
        $user = auth()->user();

        // Mengecek apakah user yang login adalah siswa
        if ($user->hasRole('siswa')) {
            $student = Student::where('email', $user->email)->first();
            if ($student) {
                $studentId = $student->id;
                $billings = Billing::where('student_id', $studentId)
                    ->with('students.school_class')
                    ->get();

                // Tambahkan status "Unpaid" pada masing-masing billing
                foreach ($billings as $billing) {
                    $billing->status = 'Unpaid';
                }

                // Mengatur Merchant Server Key Anda
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                // Set ke Lingkungan Development/Sandbox (default). Setel true untuk Lingkungan Produksi (transaksi nyata).
                \Midtrans\Config::$isProduction = false;
                // Set sanitasi aktif (default)
                \Midtrans\Config::$isSanitized = true;
                // Set transaksi 3DS untuk kartu kredit menjadi aktif
                \Midtrans\Config::$is3ds = true;

                $snapToken = [];
                $orderId = $billing->id.'-'.Str::random(20);

                foreach ($billings as $billing) {
                    $params = array(
                        'transaction_details' => array(
                            'order_id' => $orderId,
                            'gross_amount' => $billing->bill,
                        ),
                        'customer_details' => array(
                            'first_name' => $billing->students->name,
                            'last_name' => '',
                            'email' => $billing->students->email,
                            // 'phone' => '08111222333',
                        ),
                    );

                    $snapToken = \Midtrans\Snap::getSnapToken($params); //[$billing->id]
                }
                return view('siswa.tagihan', compact('snapToken', 'billings'));
            } else {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
            }
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melihat riwayat pembayaran.');
        }
    }

    public function callback(Request $request){
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'capture' or $request->transaction_status == 'settlement'){
                $billing = Billing::where('id', $request->order_id)->get();

                // Pastikan tagihan ditemukan
                if ($billing) {
                    // Ubah status hanya jika belum "Paid"
                    if ($billing->status !== 'Paid') {
                        $billing->update(['status' => 'Paid']);
                    }
                } else {
                    // Logika untuk penanganan tagihan yang tidak ditemukan
                    // Misalnya, Anda dapat menyimpan informasi ke log atau mengirim notifikasi
                    // Contoh:
                    Log::error("Tagihan dengan ID {$request->order_id} tidak ditemukan pada callback Midtrans.");
                    // Atau:
                    // Kirim notifikasi kepada admin atau pelanggan
                    // misalnya: Mail::to('admin@example.com')->send(new BillingNotFoundNotification($request->order_id));
                }
            }
        } else {
            // Logika untuk penanganan kesalahan pada tanda tangan Midtrans
            // Misalnya, Anda ingin mencatat kesalahan atau memberikan tanggapan sesuai dengan jenis kesalahan
            Log::error("Kesalahan tanda tangan pada callback Midtrans. Data: " . json_encode($request->all()));
            // Atau:
            // Kirim tanggapan HTTP sesuai dengan kesalahan
            // misalnya: return response('Kesalahan tanda tangan', 400);
        }
    }


}
