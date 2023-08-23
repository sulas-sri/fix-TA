@extends('layouts.main', ['title' => 'Pembayaran', 'page_heading' => 'Data Pembayaran'])

@section('content')
<section class="row">
	{{-- Start Statistics --}}
	<div class="col-6 col-lg-6 col-md-6">
		<div class="card">
			<div class="px-3 card-body py-4-4">
				<div class="row">
					<div class="col-md-4">
						<div class="stats-icon">
							<i class="iconly-boldChart"></i>
						</div>
					</div>
					<div class="col-md-8">
						<h6 class="font-semibold text-muted">Total Pemasukan Bulan Ini</h6>
						<h6 class="mb-0 font-extrabold">
							{{ $data['totals']['thisMonth'] }}</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-6 col-lg-6 col-md-6">
		<div class="card">
			<div class="px-3 card-body py-4-4">
				<div class="row">
					<div class="col-md-4">
						<div class="stats-icon">
							<i class="iconly-boldChart"></i>
						</div>
					</div>
					<div class="col-md-8">
						<h6 class="font-semibold text-muted">Total Pemasukan Tahun Ini</h6>
						<h6 class="mb-0 font-extrabold">
							{{ $data['totals']['thisYear'] }}</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- End of Statistics --}}

	@include('utilities.alert-flash-message')
	<div class="px-3 py-3 col card">
		<div class="pb-3 d-flex justify-content-start">
			<div>
				<div class="input-group w-75 justify-content-start">
					<input type="date" name="start_date" class="form-control" id="start_date" placeholder="Tanggal awal..">
					<input type="date" name="end_date" class="form-control" id="end_date" placeholder="Tanggal akhir..">
					<button type="button" class="btn btn-primary" id="filter">Filter</button>
				</div>
			</div>
			<div class="d-flex justify-content-end d-gap gap-2 col-6 col-lg-6 col-md-6">
				<div>
					<a href="{{ route('cash-transactions.export') }}" class="btn btn-success">
						<i class="bi bi-file-earmark-excel-fill"></i>
						Cetak Data
					</a>
				</div>
				{{-- <div>
					<a href="{{ route('cash-transactions.index.history') }}" class="btn btn-secondary">
						<span class="badge">{{ $cashTransactionTrashedCount }}</span> Histori
					</a>
				</div> --}}
				<div class="btn-group d-gap gap-2 ml-auto">
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCashTransactionModal">
						<i class="bi bi-plus-circle"></i> Tambah Data
				</button>
				</div>
			</div>
		</div>

		<div class="table-responsive">
			<table class="table table-sm w-100" id="datatable">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Nama Pelajar</th>
						<th scope="col">Jumlah Dibayar</th>
						<th scope="col">Kategori Bayar</th>
						<th scope="col">Tanggal</th>
						<th scope="col">Aksi</th>
					</tr>
				</thead>
				<tbody>
					{{-- @foreach ($filteredResult['cashTransactions'] as $cashTransaction)
						<tr>
							<th>{{ $loop->iteration }}</th>
							<td>{{ $cashTransaction->students->name }}</td>
							<td>{{ date('d-m-Y', strtotime($cashTransaction->date)) }}</td>
							<td>{{ indonesianCurrency($cashTransaction->amount) }}</td>
							<td>{{ $cashTransaction->users->name }}</td>
						</tr>
						@endforeach --}}
				</tbody>
			</table>
		</div>
	</div>
</section>
@endsection

@push('modal')
@include('cash_transactions.modal.create')
@include('cash_transactions.modal.show')
@include('cash_transactions.modal.edit')

@include('cash_transactions.modal.look-more' )
@endpush

@push('js')
@include('cash_transactions.script')
@endpush
