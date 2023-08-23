<div class="modal fade" id="editTransactionModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
					<div class="modal-header">
							<h5 class="modal-title">Edit Pengeluaran</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
							<form action="#" method="POST" id="edit-transaction-form">
									@csrf
									@method('PUT')

									<div class="form-group">
											<label for="date">Tanggal</label>
											<input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" required>
											@error('date')
													<span class="invalid-feedback">{{ $message }}</span>
											@enderror
									</div>

									<div class="form-group">
											<label for="description">Deskripsi</label>
											<input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" required>
											@error('description')
													<span class="invalid-feedback">{{ $message }}</span>
											@enderror
									</div>

									<div class="form-group">
											<label for="amount">Jumlah</label>
											<input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" required>
											@error('amount')
													<span class="invalid-feedback">{{ $message }}</span>
											@enderror
									</div>

									<button type="submit" class="btn btn-primary">Simpan</button>
							</form>
					</div>
			</div>
	</div>
</div>
