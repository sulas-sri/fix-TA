@extends('siswa.layout.main', ['title' => 'Riwayat Pembayaran', 'page_heading' => 'Riwayat Pembayaran'])

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
						<th scope="col">Kategori Pembayaran</th>
						<th scope="col">Total Bayar</th>
						<th scope="col">Tanggal</th>
					</tr>
				</thead>
				<tbody>
					@php
					$num = 1;
					@endphp
					@if (!empty($cash_transactions) && count($cash_transactions) > 0)
					@foreach ($cash_transactions as $transaction)
					<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $transaction->students->name }}</td>
							<td>{{ $transaction->students->school_class->name }}</td>
							<td>{{ $transaction->category[0] }}</td>
							<td>{{ $transaction->amount }}</td>
							<td>{{ $transaction->date }}</td>
					</tr>
					@endforeach
					@else
						<tr>
							<td colspan="6" class="text-center text-secondary">Belum ada data pembayaran yang ditambahkan!</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</section>
@endsection

{{-- @push('modal')
@include('cash_transactions.modal.create')
@include('cash_transactions.modal.show')
@include('cash_transactions.modal.edit')

@include('cash_transactions.modal.look-more' )
@endpush

@push('js')
@include('cash_transactions.script')
@endpush --}}
