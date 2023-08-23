@extends('layouts.main', ['title' => 'Pengeluaran', 'page_heading' => 'Edit Data Pengeluaran'])

@section('content')
<div class="col card px-3 py-3">
	<div class="container">
    <form method="POST" action="{{ route('transactions.update', $transaction) }}">
        @csrf
				@method('PATCH')
        <div class="form-group">
					<label for="amount">Total Pengeluaran</label>
					<input type="number" class="form-control" id="amount" name="amount" value="{{ $transaction->amount }}" required>
				</div>
				<div class="form-group">
					<label for="description">Deskripsi</label>
					<input type="text" class="form-control" id="description" name="description" value="{{ $transaction->description }}" required>
				</div>
				<div class="form-group">
					<label for="date">Tanggal Pengeluaran</label>
					<input type="text" class="form-control" id="date" name="date" value="{{ $transaction->date }}">
				</div>
        <!-- Tambahkan isian lainnya sesuai kebutuhan -->

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
</div>
@endsection
