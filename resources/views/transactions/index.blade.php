@extends('layouts.main', ['title' => 'Pengeluaran', 'page_heading' => 'Data Pengeluaran'])

@section('content')
<section class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-4">
                        <div class="stats-icon">
                            <i class="iconly-boldChart"></i>
                        </div>
                    </div>
                    <div class="col-8">
                        <h6 class="text-muted font-semibold">Total Pengeluaran Bulan Ini</h6>
                        <h6 class="font-extrabold mb-0">
                            {{ $data['totals']['thisMonth'] }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-4">
                        <div class="stats-icon">
                            <i class="iconly-boldChart"></i>
                        </div>
                    </div>
                    <div class="col-8">
                        <h6 class="text-muted font-semibold">Total Pengeluaran Tahun Ini</h6>
                        <h6 class="font-extrabold mb-0">
                            {{ $data['totals']['thisYear'] }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('utilities.alert-flash-message')

@if (auth()->check() && !auth()->user()->hasRole('headmaster'))
<section class="row">
    <div class="col card px-3 py-3">
        {{-- <div class="d-flex justify-content-between align-items-center pb-3"> --}}
            {{-- <label for="start_date" class="fw-bold pb-1">Filter Data :</label> --}}
            {{-- <div class="input-group w-50">
                <input type="date" name="start_date" class="form-control" id="start_date" placeholder="Pilih tanggal awal..">
                <input type="date" name="end_date" class="form-control" id="end_date" placeholder="Pilih tanggal akhir..">
                <button type="button" class="btn btn-primary" id="filter">Filter</button>
            </div> --}}
        {{-- </div> --}}

        <div class="d-flex pb-3 d-gap gap-2">
					<div>
						<div class="input-group w-75 justify-content-start">
							<input type="date" name="start_date" class="form-control" id="start_date" placeholder="Tanggal awal..">
							<input type="date" name="end_date" class="form-control" id="end_date" placeholder="Tanggal akhir..">
							<button type="button" class="btn btn-primary" id="filter">Filter</button>
						</div>
					</div>
					<div class="w-10">

					</div>
					<div class="d-flex justify-content-end d-gap gap-2 col-6 col-lg-6 col-md-6">
						<div>
							<a href="{{ route('transactions.export') }}" class="btn btn-success">
								<i class="bi bi-file-earmark-excel-fill"></i>
								Cetak Data
							</a>
						</div>
            <div class="btn-group d-gap gap-2 ml-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                    <i class="bi bi-plus-circle"></i> Tambah Data
                </button>
            </div>
					</div>
					{{-- <form method="POST" action="{{route ('transactions.filter')}}">
						@csrf --}}
						{{-- <label for="start_date">Start Date:</label>
						<input type="date" id="start_date" name="start_date">

						<label for="end_date">End Date:</label>
						<input type="date" id="end_date" name="end_date">

						<button type="submit" id="filter">Filter</button> --}}
					{{-- </form> --}}
						{{-- <div class="input-group w-50">
							<input type="date" name="start_date" class="form-control" id="start_date" placeholder="Pilih tanggal awal..">
							<input type="date" name="end_date" class="form-control" id="end_date" placeholder="Pilih tanggal akhir..">
							<button type="button" class="btn btn-primary" id="filter">Filter</button>
						</div> --}}
        </div>

        <div class="table-responsive" id="datatable-wrap">
            <table class="table table-sm w-100" id="datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
									{{-- @foreach($transactions as $transaction)
									<tr>
											<th>{{ $loop->iteration }}</th>
											<td>{{ $transaction->amount }}</td>
											<td>{{ $transaction->description }}</td>
											<td>{{ $transaction->date }}</td>
									</tr>
									@endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</section>
@endif
@endsection

@push('modal')
@include('transactions.modal.create')
@include('transactions.modal.show')
@include('transactions.modal.edit')
@endpush

@push('js')
@include('transactions.script')
@endpush

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
