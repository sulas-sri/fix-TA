@extends('layouts.main', ['title' => 'Pembayaran', 'page_heading' => 'Edit Data Pembayaran'])

@section('content')
<div class="col card px-3 py-3">
	<div class="container">
    <form method="POST" action="{{ route('cash-transactions.update', $cashTransaction) }}">
        @csrf
				@method('PATCH')
        <div class="form-group">
					<label for="name">Nama Siswa</label>
					<input type="text" class="form-control" id="name" name="name" value="{{ $cashTransaction->students->name }}" disabled>
				</div>
				<div class="form-group">
					<label for="amount">Jumlah Bayar</label>
					<input type="number" class="form-control" id="amount" name="amount" value="{{ $cashTransaction->amount }}" required>
				</div>
				<div class="form-group">
					<label for="category" class="form-label">Kategori Bayar</label>
					<div>
						<input type="checkbox" name="category[]" value="SPP" id="category_spp" {{ in_array('SPP', is_array($cashTransaction->category) ? $cashTransaction->category : []) ? 'checked' : '' }}>
						<label for="category_spp">SPP</label>
					</div>
					<div>
							<input type="checkbox" name="category[]" value="Tabungan" id="category_tabungan" {{ in_array('Tabungan', is_array($cashTransaction->category) ? $cashTransaction->category : []) ? 'checked' : '' }}>
							<label for="category_tabungan">Tabungan</label>
					</div>
					<div>
						<input type="checkbox" name="category[]" value="Catering" id="category_catering" {{ in_array('Catering', is_array($cashTransaction->category) ? $cashTransaction->category : []) ? 'checked' : '' }}>
						<label for="category_catering">Catering</label>
					</div>
					<div>
						<input type="checkbox" name="category[]" value="Antar Jemput" id="category_antarJemput" {{ in_array('Antar Jemput', is_array($cashTransaction->category) ? $cashTransaction->category : []) ? 'checked' : '' }}>
						<label for="category_antarJemput">Antar Jemput</label>
					</div>
					<div>
						<input type="checkbox" name="category[]" value="Angsuran" id="category_angsuran" {{ in_array('Angsuran', is_array($cashTransaction->category) ? $cashTransaction->category : []) ? 'checked' : '' }}>
						<label for="category_angsuran">Angsuran TA</label>
					</div>
					<div>
						<input type="checkbox" name="category[]" value="Komite" id="category_komite" {{ in_array('Komite', is_array($cashTransaction->category) ? $cashTransaction->category : []) ? 'checked' : '' }}>
						<label for="category_komite">Komite</label>
					</div>
					<div>
						<input type="checkbox" name="category[]" value="Buku Mapel" id="category_bukuMapel" {{ in_array('Buku Mapel', is_array($cashTransaction->category) ? $cashTransaction->category : []) ? 'checked' : '' }}>
						<label for="category_bukuMapel">Buku Mapel</label>
					</div>
					<div>
						<input type="checkbox" name="category[]" value="Ekstrakurikuler" id="category_ekstrakurikuler" {{ in_array('Ekstrakurikuler', is_array($cashTransaction->category) ? $cashTransaction->category : []) ? 'checked' : '' }}>
						<label for="category_ekstrakurikuler">Ekstrakurikuler</label>
					</div>
					<div>
						<input type="checkbox" name="lain_lain_checkbox" id="lain_lain_checkbox"
								{{ in_array('Lain Lain', $cashTransaction->category) ? 'checked' : '' }}>
						<label for="lain_lain_checkbox">Lain Lain</label>
						<input type="text" name="lain_lain_value" id="lain_lain_value"
								value="{{ old('lain_lain_value', $cashTransaction->lain_lain_value) }}"
								{{ in_array('Lain Lain', $cashTransaction->category) ? '' : 'disabled' }}>
						<input type="hidden" name="lain_lain_hidden" id="lain_lain_hidden"
								value="{{ old('lain_lain_hidden', $cashTransaction->lain_lain_hidden) }}">
					</div>




				</div>
				<div class="form-group">
					<label for="note">Catatan</label>
					<input type="text" class="form-control" id="note" name="note" value="{{ $cashTransaction->note }}">
				</div>
				<div class="form-group">
					<label for="date">Tanggal Bayar</label>
					<input type="text" class="form-control" id="date" name="date" value="{{ $cashTransaction->date }}" required>
				</div>

        <!-- Tambahkan isian lainnya sesuai kebutuhan -->

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
</div>
@endsection
