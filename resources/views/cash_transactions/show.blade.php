@extends('layouts.main', ['title' => 'Pembayaran', 'page_heading' => 'Detail Data Pembayaran'])

@section('content')
<section class="row">

	@include('utilities.alert-flash-message')
	<div class="col card px-3 py-3">
		<div class="container">
			<table class="table table-bordered">
				<tr>
						<th>Nama Siswa</th>
						<td>{{ $cashTransaction->students->name }}</td>
				</tr>
				<tr>
						<th>Jumlah Bayar</th>
						<td>Rp {{ number_format($cashTransaction->amount, 0, ',', '.') }}</td>
				</tr>
				<tr>
					<th>Kategori Bayar</th>
							<td>
									@php
											$categories = $cashTransaction->category;
											if (is_array($categories)) {
													echo implode(', ', $categories);
											} else {
													echo $categories;
											}
									@endphp
							</td>
				</tr>
				<tr>
					<th>Catatan</th>
					<td>{{ $cashTransaction->note }}</td>
				</tr>
				<tr>
					<th>Tanggal Bayar</th>
					<td>{{ \Carbon\Carbon::parse($cashTransaction->date)->format('d F Y') }}</td>
				</tr>
				<!-- Tambahkan informasi lainnya sesuai kebutuhan -->
		</table>

		<a href="{{ route('cash-transactions.index') }}" class="btn btn-primary">Kembali ke Data Pembayaran</a>
		</div>
</div>

</section>
@endsection

{{-- @push('modal')
@include('students.modal.create')
@include('students.modal.show')
@include('students.modal.edit')
@endpush --}}

{{-- @push('js')
@include('students.script')
@endpush --}}
