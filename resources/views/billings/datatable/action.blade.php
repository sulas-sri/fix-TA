<div class=" btn-group" role="group">
	<div class="mx-1">
		<form action="{{ route('billings.sendNotification', $model->id) }}" method="POST">
				@csrf
				<button type="submit" class="btn btn-info btn-sm send-notification">
						<i class="bi bi-telegram"></i> Kirim Notifikasi
				</button>
		</form>
	</div>

	{{-- <div class="mx-1">
			<button type="button" data-id="{{ $model->id }}" class="btn btn-primary btn-sm billing-detail"
					data-bs-toggle="modal" data-bs-target="#showBillingModal">
					<i class="bi bi-search"></i>
			</button>
	</div>

	<div class="mx-1">
			<button type="button" data-id="{{ $model->id }}" class="btn btn-success btn-sm billing-edit"
					data-bs-toggle="modal" data-bs-target="#editBillingModal">
					<i class="bi bi-pencil-square"></i>
			</button>
	</div> --}}

	<div class="mx-1">
			<form action="{{ route('billings.destroy', $model->id) }}" method="POST">
					@csrf @method('DELETE')
					<button type="submit" class="btn btn-danger btn-sm delete-notification">
							<i class="bi bi-trash-fill"></i>
					</button>
			</form>
	</div>
</div>
