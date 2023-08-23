@extends('layouts.main', ['title' => 'Pengeluaran', 'page_heading' => 'Detail Data Pengeluaran'])

@section('content')
<section class="row">

	@include('utilities.alert-flash-message')
	<div class="col card px-3 py-3">
		<div class="container">
			<table class="table table-bordered">
				<tr>
						<th>Total Pengeluaran</th>
						<td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
				</tr>
				<tr>
						<th>Deskripsi</th>
						<td>{{ $transaction->description }}</td>
				</tr>
				<tr>
					<th>Tanggal Pengeluaran</th>
					<td>{{ \Carbon\Carbon::parse($transaction->date)->format('d F Y') }}</td>
				</tr>
				<!-- Tambahkan informasi lainnya sesuai kebutuhan -->
		</table>

		<a href="{{ route('transactions.index') }}" class="btn btn-primary">Kembali ke Data Pengeluaran</a>
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
