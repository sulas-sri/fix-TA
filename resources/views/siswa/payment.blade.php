{{-- @extends('siswa.layout.main', ['title' => 'Sistem Informasi Keuangan'])

@section('content')
<section class="row">
    @include('utilities.alert-flash-message')
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> --}}
                <div class="modal-body">
                    @include('utilities.loading-alert')
										<table>
											<tr>
													<td>Nama Pelajar</td>
													<td> : {{$billing->student->name}}</td>
											</tr>
											<tr>
													<td>Kelas</td>
													<td> : {{$billing->student->school_class->name}}</td>
											</tr>
											<tr>
													<td>Jumlah Tagihan</td>
													<td> : {{$$billing->bill}}</td>
											</tr>
											<tr>
													<td>Kategori Tagihan</td>
													<td> : {{$billing->category}}</td>
											</tr>
										</table>
                    {{-- <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Pelajar</label>
                                <input type="text" class="form-control" id="name" value="{{ $billing->student->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas" value="{{ $billing->student->school_class->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <div class="mb-3">
                                <label for="bill" class="form-label">Jumlah Tagihan</label>
                                <input type="text" class="form-control" id="bill" value="{{ $billing->bill }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori Tagihan</label>
                                <input type="text" class="form-control" id="category" value="{{ $billing->category }}" disabled>
                            </div>
                        </div> --}}
                        <button class="btn btn-primary mt-3" id="pay-button">Bayar Sekarang</button>
                    </div>
                </div>
            {{-- </div>
        </div>
    </div> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    {{-- <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
          // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
          window.snap.pay('{{$snapToken}}', {
            onSuccess: function(result){
              /* You may add your own implementation here */
              window.location.href = '/invoice/{{$billing->id}}'
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
    </script> --}}
</section>
@endsection
