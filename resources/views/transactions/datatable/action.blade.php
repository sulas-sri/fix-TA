<div class="btn-group" role="group">
	<div class="mx-1">
		<a href="/detail-pengeluaran/{{ $model->id }}" class="btn btn-primary btn-sm">
			<i class="bi bi-search"></i>
		</a>
	</div>

	<div class="mx-1">
		<a href="/edit-pengeluaran/{{ $model->id }}" class="btn btn-success btn-sm">
			<i class="bi bi-pencil-square"></i>
		</a>
	</div>

	<div class="mx-1">
			<form action="{{ route('transactions.destroy', $model->id) }}" method="POST" class="d-inline-block">
					@csrf
					@method('DELETE')
					<button type="submit" class="btn btn-danger btn-sm delete-notification" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi keuangan ini?')">
							<i class="bi bi-trash-fill"></i>
					</button>
			</form>
	</div>
</div>
