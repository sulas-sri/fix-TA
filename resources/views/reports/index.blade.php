@extends('layouts.main', ['title' => 'Laporan', 'page_heading' => 'Data Rekapitulasi'])

@section('content')
<section>
	<div class="row">
		<div class="card px-3 py-3">
			<form action="" method="GET">
				<label for="start_date" class="pb-3 fw-bold">Filter Data dengan Rentang Tanggal :</label>
				<div class="input-group">
					<input type="date" name="start_date" class="form-control" placeholder="Pilih tanggal awal..">
					<input type="date" name="end_date" class="form-control" placeholder="Pilih tanggal akhir..">
					<button type="submit" class="btn btn-primary">Filter</button>
				</div>
			</form>
		</div>
	</div>

	@empty(!$filteredResult)
	<div class="row">
		<div class="card px-3 py-3">
			<div class="col-lg-12">
				<a href="{{ route('report.export', [$filteredResult['startDate'], $filteredResult['endDate']]) }}"
					class="btn btn-success float-end">
					<i class="bi bi-file-earmark-excel-fill"></i>
					Export Excel
				</a>
			</div>

			<div class="table-responsive mt-3">
				<table class="table table-sm text-center caption-top" id="datatable">
					<caption>Laporan data dari tanggal <span class="fw-bold">{{ $filteredResult['startDate'] }}</span> -
						<span class="fw-bold">{{ $filteredResult['endDate'] }}</span>
					</caption>
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Tanggal</th>
							<th scope="col">Keterangan</th>
							<th scope="col">Pemasukan</th>
							<th scope="col">Pengeluaran</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($filteredResult['cashTransactions'] as $cashTransaction)
						<tr>
							<th>{{ $loop->iteration }}</th>
							<td>{{ $cashTransaction->students->name }}</td>
							<td>{{ date('d-m-Y', strtotime($cashTransaction->date)) }}</td>
							<td>{{ indonesianCurrency($cashTransaction->amount) }}</td>
							<td>{{ $cashTransaction->users->name }}</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4" align="right"><b>Total</b></td>
							<td>{{ indonesianCurrency($filteredResult['sumOfAmount']) }}</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	@endempty
</section>
@endsection

@push('js')
@include('reports.script')
@endpush
