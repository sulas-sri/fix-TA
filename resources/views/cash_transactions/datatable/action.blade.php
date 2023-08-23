<div class=" btn-group" role="group">
  <div class="mx-1">
		<a href="{{ route('cetak-kwitansi', $model->id) }}" class="btn btn-info btn-sm">
				<i class="bi bi-printer"></i>
				Kwitansi
		</a>
	</div>

	<div class="mx-1">
		<a href="/detail-pembayaran/{{ $model->id }}" class="btn btn-primary btn-sm">
			<i class="bi bi-search"></i>
		</a>
	</div>

	<div class="mx-1">
		<a href="/edit-pembayaran/{{ $model->id }}" class="btn btn-success btn-sm">
			<i class="bi bi-pencil-square"></i>
		</a>
	</div>

	{{-- <div class="mx-1">
        <button type="button" data-id="{{ $model->id }}" class="btn btn-primary btn-sm cash-transaction-detail"
            data-bs-toggle="modal" data-bs-target="#showCashTransactionModal">
            <i class="bi bi-search"></i>
        </button>
    </div>

    <div class="mx-1">
        <button type="button" data-id="{{ $model->id }}" class="btn btn-success btn-sm cash-transaction-edit"
            data-bs-toggle="modal" data-bs-target="#editCashTransactionModal">
            <i class="bi bi-pencil-square"></i>
        </button>
    </div> --}}

    <div class="mx-1">
        <form action="{{ route('cash-transactions.destroy', $model->id) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm delete-notification">
                <i class="bi bi-trash-fill"></i>
            </button>
        </form>
    </div>
</div>
