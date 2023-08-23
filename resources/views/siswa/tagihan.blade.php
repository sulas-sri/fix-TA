@extends('siswa.layout.main', ['title' => 'Tagihan', 'page_heading' => 'Riwayat Tagihan'])

@section('content')
<section class="row">
    @include('utilities.alert-flash-message')
    <div class="col card px-3 py-3">
        <div class="d-flex justify-content-end pb-3">
            <div class="btn-group d-gap gap-2">
                {{-- <a href="{{ route('cash-transactions.export') }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel-fill"></i>
                    Export Excel
                </a> --}}
                {{-- <a href="{{ route('cash-transactions.index.history') }}" class="btn btn-secondary">
                    <span class="badge">{{ $cashTransactionTrashedCount }}</span> Histori Data Kas
                </a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#addCashTransactionModal">
                    <i class="bi bi-plus-circle"></i> Tambah Data
                </button> --}}
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm w-100" id="datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Pelajar</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">ID Telegram</th>
                        <th scope="col">Jumlah Tagihan</th>
                        <th scope="col">Kategori Tagihan</th>
                        <th scope="col">Jatuh Tempo</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $num = 1;
                    @endphp
                    @foreach ($billings as $billing)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $billing->students->name }}</td>
                        <td>{{ $billing->students->school_class->name }}</td>
                        <td>{{ $billing->id_telegram }}</td>
                        <td>{{ $billing->bill }}</td>
                        <td>{{ $billing->kategori_tagihan}}</td>
                        <td>{{ $billing->date }}</td>
                        <td>
                            @if (!$billing->is_paid)
                            <button type="button" class="btn btn-success" id="pay-button">Bayar</button>
                            @else
                                Sudah Dibayar
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @if (count($billings) === 0)
                        <tr>
                            <td colspan="7" class="text-center text-secondary">Belum ada tagihan yang ditambahkan!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript">
	// For example trigger on button clicked, or any time you need
	var payButton = document.getElementById('pay-button');
	payButton.addEventListener('click', function () {
		// Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
		window.snap.pay({!! json_encode($snapToken) !!}, {
			onSuccess: function(result){
				// window.location.href = '/midtrans-callback';
				/* You may add your own implementation here */
				alert("payment success!"); console.log(result);
			},
			onPending: function(result){
				/* You may add your own implementation here */
				alert("wating your payment!"); console.log(result);
			},
			onError: function(result){
				/* You may add your own implementation here */
				alert("payment failed!"); console.log(result);
			},
			onClose: function(){
				/* You may add your own implementation here */
				alert('you closed the popup without finishing the payment');
			}
		})
	});
</script>
@endsection

<!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


{{-- @section('scripts') --}}

{{-- <script type="text/javascript" src="{{config('midtrans.snap_url')}}"
data-client-key="{{config('midtrans.client_key')}}">
    var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
          // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
          window.snap.pay('{{$snapToken}}', {
                onSuccess: function(result){
                    /* You may add your own implementation here */
                    window.location.href = '/invoice/' + billingId; // Menggunakan billingId
                    alert("payment success!"); console.log(result);
                },
                onPending: function(result){
                    /* You may add your own implementation here */
                    alert("waiting for your payment!"); console.log(result);
                },
                onError: function(result){
                    /* You may add your own implementation here */
                    alert("payment failed!"); console.log(result);
                },
                onClose: function(){
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });
    });
</script> --}}
{{-- @endsection --}}
