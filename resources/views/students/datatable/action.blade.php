<div class="btn-group" role="group">
		<div class="mx-1">
			<a href="/detail-siswa/{{ $model->id }}" class="btn btn-primary btn-sm">
				<i class="bi bi-search"></i>
			</a>
		</div>

    <div class="mx-1">
			<a href="/edit-siswa/{{ $model->id }}" class="btn btn-success btn-sm">
				<i class="bi bi-pencil-square"></i>
			</a>
    </div>

    <div class="mx-1">
        <form action="{{ route('students.destroy', $model->id) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm delete-notification">
                <i class="bi bi-trash-fill"></i>
            </button>
        </form>
    </div>
</div>
