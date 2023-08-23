<div class="modal fade" id="addBillingModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
					<div class="modal-header">
							<h5 class="modal-title">Tambah Data Tagihan</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
							<form action="{{ route('billings.store') }}" method="POST" id="addBillingForm">
									@csrf
									<div class="row">
											<div class="col-md-12">
													<div class="mb-3">
															<label for="name" class="form-label">Nama Pelajar</label>
															<select class="form-select select2 @error('student_id') is-invalid @enderror" name="student_id[]" multiple>
																	@foreach ($students as $student)
																	<option value="{{ $student->id }}" {{ collect(old('student_id'))->contains($student->id) ? 'selected' : '' }}>
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

									<div class="col-md-6">
										<div class="mb-3">
												<label for="id_telegram" class="form-label">ID Telegram</label>
												<input type="text" class="form-control @error('id_telegram') is-invalid @enderror" name="id_telegram" value="{{ old('id_telegram') }}" id="id_telegram" placeholder="Masukkan ID Telegram...">
												@error('id_telegram')
														<div class="d-block invalid-feedback">
																{{ $message }}
														</div>
												@enderror
										</div>
								  </div>

									<div class="row">
											<div class="col-md-6">
													<div class="mb-3">
															<label for="bill" class="form-label">Total Tagihan</label>
															<input type="number" class="form-control @error('bill') is-invalid @enderror" name="bill" value="{{ old('bill') }}" id="bill" placeholder="Masukkan tagihan..">

															@error('bill')
															<div class="d-block invalid-feedback">
																	{{ $message }}
															</div>
															@enderror
													</div>
											</div>

											{{-- <div class="col-md-6">
												<div class="mb-3">
														<label for="kategori_tagihan" class="form-label">Kategori Tagihan</label>
														<select class="form-select @error('kategori_tagihan') is-invalid @enderror" name="kategori_tagihan">
																<option value="" selected disabled>Pilih Kategori Tagihan</option>
																<option value="SPP" {{ old('kategori_tagihan') == 'SPP' ? 'selected' : '' }}>SPP</option>
																<option value="Tabungan" {{ old('kategori_tagihan') == 'Tabungan' ? 'selected' : '' }}>Tabungan</option>
																<option value="Catering" {{ old('kategori_tagihan') == 'Catering' ? 'selected' : '' }}>Catering</option>
																<option value="Antar Jemput" {{ old('kategori_tagihan') == 'Antar Jemput' ? 'selected' : '' }}>Antar Jemput</option>
																<option value="Angsuran TA" {{ old('kategori_tagihan') == 'Angsuran TA' ? 'selected' : '' }}>Angsuran TA</option>
																<option value="Komite" {{ old('kategori_tagihan') == 'Komite' ? 'selected' : '' }}>Komite</option>
																<option value="Buku Mapel" {{ old('kategori_tagihan') == 'Buku Mapel' ? 'selected' : '' }}>Buku Mapel</option>
																<option value="Ekstrakurikuler" {{ old('kategori_tagihan') == 'Ekstrakurikuler' ? 'selected' : '' }}>Ekstrakurikuler</option>
																<option value="Lain lain" {{ old('kategori_tagihan') == 'Lain lain' ? 'selected' : '' }}>Lain lain</option>
														</select>
														@error('kategori_tagihan')
																<div class="d-block invalid-feedback">
																		{{ $message }}
																</div>
														@enderror
												</div>
										</div> --}}
										<div class="row">
											<div class="col-md-6">
												<div class="mb-3">
														<label for="kategory_tagihan" class="form-label">Kategori Tagihan</label>
														<div>
															<input type="checkbox" name="kategory_tagihan[]" value="SPP" id="kategory_tagihan_spp"
																	{{ in_array('SPP', old('kategory_tagihan', [])) ? 'checked' : '' }}>
															<label for="kategory_tagihan_spp">SPP</label>
														</div>
														<div>
															<input type="checkbox" name="kategory_tagihan[]" value="Tabungan" id="kategory_tagihan_tabungan"
																	{{ in_array('Tabungan', old('kategory_tagihan', [])) ? 'checked' : '' }}>
															<label for="kategory_tagihan_tabungan">Tabungan</label>
														</div>
														<div>
															<input type="checkbox" name="kategory_tagihan[]" value="Catering" id="kategory_tagihan_catering"
																	{{ in_array('Catering', old('kategory_tagihan', [])) ? 'checked' : '' }}>
															<label for="kategory_tagihan_catering">Catering</label>
														</div>
														<div>
															<input type="checkbox" name="kategory_tagihan[]" value="Antar Jemput" id="kategory_tagihan_antarJemput"
																	{{ in_array('Antar Jemput', old('kategory_tagihan', [])) ? 'checked' : '' }}>
															<label for="kategory_tagihan_antarJemput">Antar Jemput</label>
														</div>
														<div>
															<input type="checkbox" name="kategory_tagihan[]" value="Angsuran" id="kategory_tagihan_angsuran"
																	{{ in_array('Angsuran', old('kategory_tagihan', [])) ? 'checked' : '' }}>
															<label for="kategory_tagihan_angsuran">Angsuran TA</label>
														</div>
														<div>
															<input type="checkbox" name="kategory_tagihan[]" value="Komite" id="kategory_tagihan_komite"
																	{{ in_array('Komite', old('kategory_tagihan', [])) ? 'checked' : '' }}>
															<label for="kategory_tagihan_komite">Komite</label>
														</div>
														<div>
															<input type="checkbox" name="kategory_tagihan[]" value="Buku Mapel" id="kategory_tagihan_bukuMapel"
																	{{ in_array('Buku Mapel', old('kategory_tagihan', [])) ? 'checked' : '' }}>
															<label for="kategory_tagihan_bukuMapel">Buku Mapel</label>
														</div>
														<div>
															<input type="checkbox" name="kategory_tagihan[]" value="Ekstrakurikuler" id="kategory_tagihan_ekstrakurikuler"
																	{{ in_array('Ekstrakurikuler', old('kategory_tagihan', [])) ? 'checked' : '' }}>
															<label for="kategory_tagihan_ekstrakurikuler">Ekstrakurikuler</label>
														</div>
														<div>
															<input type="checkbox" name="lain_lain_checkbox" id="lain_lain_checkbox">
															<label for="lain_lain_checkbox">Lain Lain</label>
															<input type="text" name="lain_lain_value" id="lain_lain_value" value="{{ old('lain_lain_value') }}" placeholder="Input Lain Lain" disabled>
															<input type="hidden" name="lain_lain_hidden" id="lain_lain_hidden" value="{{ old('lain_lain_hidden') }}">
														</div>

														@if (old('lain_lain_hidden'))
														<p>Data Lain-Lain: {{ old('lain_lain_hidden') }}</p>
														@endif
														@error('kategory_tagihan')
																<div class="d-block invalid-feedback">
																		{{ $message }}
																</div>
														@enderror
												</div>
										</div>
										</div>

											{{-- <div class="col-md-6">
													<div class="mb-3">
															<label for="amount" class="form-label">Jumlah Pembayaran</label>
															<input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" value="{{ old('amount') }}" placeholder="Masukkan jumlah pembayaran..">

															@error('amount')
															<div class="d-block invalid-feedback">
																	{{ $message }}
															</div>
															@enderror
													</div>
											</div> --}}
									</div>

									<div class="row">
											<div class="col-md-12">
													<div class="mb-3">
															<label for="date" class="form-label">Jatuh Tempo</label>
															<input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" placeholder="Pilih tanggal..">

															@error('date')
															<div class="d-block invalid-feedback">
																	{{ $message }}
															</div>
															@enderror
													</div>
											</div>
									</div>

									{{-- <div class="row">
											<div class="mb-3">
													<label for="note" class="form-label">Catatan</label>
													<textarea class="form-control @error('note') is-invalid @enderror" name="note" id="note" rows="3" placeholder="Masukkan catatan (opsional)..">{{ old('note') }}</textarea>

													@error('note')
													<div class="d-block invalid-feedback">
															{{ $message }}
													</div>
													@enderror
											</div>
									</div> --}}
									<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
											<button type="submit" class="btn btn-primary">Simpan</button>
									</div>
							</form>
					</div>
			</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
