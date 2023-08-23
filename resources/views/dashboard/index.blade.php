@extends('layouts.main', ['title' => 'Dashboard', 'page_heading' => 'Dashboard'])

@section('content')
<section class="row">
	<div class="col-12 col-lg-12">
		<div class="row">
			<div class="col-6 col-lg-6 col-md-6">
				<a href="{{ route('students.index') }}">
					<div class="card card-stat">
						<div class="card-body px-3 py-4-4">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon purple">
										<i class="iconly-boldProfile"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="font-semibold text-muted">Jumlah Pelajar</h6>
									<h6 class="font-extrabold {{ $studentCount <= 0 ? 'text-danger' : '' }} mb-0">
										{{ $studentCount }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-6 col-lg-6 col-md-6">
				<a href="{{ route('school-classes.index') }}">
					<div class="card card-stat">
						<div class="card-body px-3 py-4-4">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon blue">
										<i class="iconly-boldBookmark"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="font-semibold text-muted">Kelas</h6>
									<h6 class="font-extrabold {{ $schoolClassCount <= 0 ? 'text-danger' : '' }} mb-0">
										{{ $schoolClassCount }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>

			<h5>Pemasukan</h5>
			<div class="row">
				<div class="col-6 col-lg-6 col-md-6">
					<div class="card">
						<div class="card-body px-3 py-4-4">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon">
										<i class="iconly-boldChart"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="text-muted font-semibold">Total Pemasukan Hari Ini</h6>
									<h6 class="font-extrabold mb-0">
										{{ $sumIncome['thisDay'] }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-6 col-lg-6 col-md-6">
					<div class="card">
						<div class="card-body px-3 py-4-4">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon">
										<i class="iconly-boldChart"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="text-muted font-semibold">Total Pemasukan Minggu Ini</h6>
									<h6 class="font-extrabold mb-0">
										{{ $sumIncome['thisWeek'] }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-6 col-lg-6 col-md-6">
					<div class="card">
						<div class="card-body px-3 py-4-4">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon">
										<i class="iconly-boldChart"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="text-muted font-semibold">Total Pemasukan Bulan Ini</h6>
									<h6 class="font-extrabold mb-0">
										{{ $sumIncome['thisMonth'] }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-6 col-lg-6 col-md-6">
					<div class="card">
						<div class="card-body px-3 py-4-4">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon">
										<i class="iconly-boldChart"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="text-muted font-semibold">Total Pemasukan Tahun Ini</h6>
									<h6 class="font-extrabold mb-0">
										{{ $sumIncome['thisYear'] }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<h5>Pengeluaran</h5>
			<div class="row">
				<div class="col-6 col-lg-6 col-md-6">
					<div class="card">
						<div class="card-body px-3 py-4-4">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon">
										<i class="iconly-boldChart"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="text-muted font-semibold">Total Pengeluaran Hari Ini</h6>
									<h6 class="font-extrabold mb-0">
										{{ $sumExpense['thisDay'] }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-6 col-lg-6 col-md-6">
					<div class="card">
						<div class="card-body px-3 py-4-4">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon">
										<i class="iconly-boldChart"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="text-muted font-semibold">Total Pengeluaran Minggu Ini</h6>
									<h6 class="font-extrabold mb-0">
										{{ $sumExpense['thisWeek'] }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-6 col-lg-6 col-md-6">
					<div class="card">
						<div class="card-body px-3 py-4-4">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon">
										<i class="iconly-boldChart"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="text-muted font-semibold">Total Pengeluaran Bulan Ini</h6>
									<h6 class="font-extrabold mb-0">
										{{ $sumExpense['thisMonth'] }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-6 col-lg-6 col-md-6">
					<div class="card">
						<div class="card-body px-3 py-4-4">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon">
										<i class="iconly-boldChart"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="text-muted font-semibold">Total Pengeluaran Tahun Ini</h6>
									<h6 class="font-extrabold mb-0">
										{{ $sumExpense['thisYear'] }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			{{-- <div class="col-6 col-lg-3 col-md-6">
				<a href="{{ route('transactions.index') }}">
					<div class="card card-stat">
						<div class="px-3 card-body py-4-5">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon green">
										<i class="iconly-boldWork"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="font-semibold text-muted">Pemasukan</h6>
									<h6 class="font-extrabold mb-0">
										{{ $incomeAmount }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div> --}}
			{{-- <div class="col-6 col-lg-3 col-md-6">
				<a href="{{ route('transactions.index') }}">
					<div class="card card-stat">
						<div class="px-3 card-body py-4-5">
							<div class="row">
								<div class="col-md-4">
									<div class="stats-icon red">
										<i class="iconly-boldTicket"></i>
									</div>
								</div>
								<div class="col-md-8">
									<h6 class="font-semibold text-muted">Pengeluaran</h6>
									<h6 class="mb-0 font-extrabold">{{ $expenseAmount }}</h6>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div> --}}

		{{-- @include('dashboard.charts.chart') --}}
		{{-- <div class="row">
			<div class="col-12 col-xl-12">
				<div class="card">
					<div class="card-header">
						<h4>5 Transaksi Terakhir</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-striped table-lg">
								<thead>
									<tr>
										<th>Nama Pelajar</th>
										<th>Total Bayar</th>
										<th>Tanggal</th>
										<th>Pencatat</th>
										<th>Detail</th>
									</tr>
								</thead> --}}
								<tbody>
									{{-- @forelse($latestCashTransactions as $latestCashTransaction)
									<tr>
										<td class="col-5">
											<div class="d-flex align-items-center">
												@if ($latestCashTransaction && $latestCashTransaction->students)
												{{ $latestCashTransaction->students->name }}
												@else
												Nama Tidak Tersedia
												@endif
												{{-- <p class="mb-0 font-bold ms-3">
													{{ $latestCashTransaction->students->name }}
												</p> --}}
											{{-- </div>
										</td>
										<td class="col-auto">
											<p class="mb-0 ">
												{{ indonesianCurrency($latestCashTransaction->amount) }}
											</p>
										</td>
										<td class="col-auto">
											<p class="mb-0 ">
												{{ date('d-m-Y', strtotime($latestCashTransaction->date)) }}
											</p>
										</td> --}}
										{{-- <td class="col-auto">
											<p class="mb-0 ">
												{{ $latestCashTransaction->users->name }}
											</p>
										</td> --}}
										{{-- <td class="col-auto">
											<p class="mb-0">
												<button type="button" data-id="{{ $latestCashTransaction->id }}"
													class="btn btn-primary btn-sm cash-transaction-detail" data-bs-toggle="modal"
													data-bs-target="#showCashTransactionModal">
													<i class="bi bi-search"></i>
												</button>
											</p>
										</td>
									</tr>
									@empty --}}
									{{-- <tr>
										<td colspan="5">
											<p class="text-center fw-bold text-danger text-uppercase">Data kosong!</p>
										</td>
									</tr>
									@endforelse --}}
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@push('modal')
@include('dashboard.modal.show')
@endpush

@push('js')
@include('dashboard.script')
@endpush
