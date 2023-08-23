<div class="modal fade" id="addCashTransactionModal" data-bs-backdrop="static" data-bs-keyboard="false"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Data Pembayaran</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="{{ route('cash-transactions.store') }}" method="POST" id="addCashTransactionForm">
					@csrf
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label for="name" class="form-label">Nama Pelajar</label>
								<select class="form-select select2 @error('student_id') is-invalid @enderror" name="student_id[]"
									multiple>
									@foreach ($students as $student)
									<option value="{{ $student->id }}" {{ collect(old('student_id'))->
										contains($student->id) ? 'selected' : '' }}>
										{{ $student->student_identification_number }} - {{ $student->name }}
									</option>
									@endforeach
								</select>

								@error('student_id')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					{{-- <div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="bill" class="form-label">Tagihan</label>
								<input type="number" class="form-control @error('bill') is-invalid @enderror" name="bill"
									value="{{ old('bill') }}" id="bill" placeholder="Masukkan tagihan..">

								@error('bill')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div> --}}


					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="amount" class="form-label">Total Bayar</label>
								<input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount"
									id="amount" value="{{ old('amount') }}" placeholder="Masukkan total bayar..">

								@error('amount')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
								<label for="category" class="form-label">Kategori Tagihan</label>
								<div>
									<input type="checkbox" name="category[]" value="SPP" id="category_spp"
											{{ in_array('SPP', old('category', [])) ? 'checked' : '' }}>
									<label for="category_spp">SPP</label>
								</div>
								<div>
									<input type="checkbox" name="category[]" value="Tabungan" id="category_tabungan"
											{{ in_array('Tabungan', old('category', [])) ? 'checked' : '' }}>
									<label for="category_tabungan">Tabungan</label>
								</div>
								<div>
									<input type="checkbox" name="category[]" value="Catering" id="category_catering"
											{{ in_array('Catering', old('category', [])) ? 'checked' : '' }}>
									<label for="category_catering">Catering</label>
								</div>
								<div>
									<input type="checkbox" name="category[]" value="Antar Jemput" id="category_antarJemput"
											{{ in_array('Antar Jemput', old('category', [])) ? 'checked' : '' }}>
									<label for="category_antarJemput">Antar Jemput</label>
								</div>
								<div>
									<input type="checkbox" name="category[]" value="Angsuran" id="category_angsuran"
											{{ in_array('Angsuran', old('category', [])) ? 'checked' : '' }}>
									<label for="category_angsuran">Angsuran TA</label>
								</div>
								<div>
									<input type="checkbox" name="category[]" value="Komite" id="category_komite"
											{{ in_array('Komite', old('category', [])) ? 'checked' : '' }}>
									<label for="category_komite">Komite</label>
								</div>
								<div>
									<input type="checkbox" name="category[]" value="Buku Mapel" id="category_bukuMapel"
											{{ in_array('Buku Mapel', old('category', [])) ? 'checked' : '' }}>
									<label for="category_bukuMapel">Buku Mapel</label>
								</div>
								<div>
									<input type="checkbox" name="category[]" value="Ekstrakurikuler" id="category_ekstrakurikuler"
											{{ in_array('Ekstrakurikuler', old('category', [])) ? 'checked' : '' }}>
									<label for="category_ekstrakurikuler">Ekstrakurikuler</label>
								</div>
								<div>
									<input type="checkbox" name="lain_lain_checkbox" id="lain_lain_checkbox">
									<label for="lain_lain_checkbox">Lain Lain</label>
									<input type="text" name="lain_lain_value" id="lain_lain_value" value="{{ old('lain_lain_value') }}"
											placeholder="Input Lain Lain" disabled>
									<input type="hidden" name="lain_lain_hidden" id="lain_lain_hidden" value="{{ old('lain_lain_hidden') }}">
								</div>

								@if (old('lain_lain_hidden'))
								<p>Data Lain-Lain: {{ old('lain_lain_hidden') }}</p>
								@endif
								@error('category')
										<div class="d-block invalid-feedback">
												{{ $message }}
										</div>
								@enderror
						</div>
				</div>

					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label for="date" class="form-label">Tanggal Bayar</label>
								<input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date"
									placeholder="Pilih tanggal..">

								@error('date')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					<div class="row">
						<div class="mb-3">
							<label for="note" class="form-label">Catatan</label>
							<textarea class="form-control @error('note') is-invalid @enderror" name="note" id="note" rows="3"
								placeholder="Masukkan catatan (opsional)..">{{ old('note') }}</textarea>

							@error('note')
							<div class="d-block invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
