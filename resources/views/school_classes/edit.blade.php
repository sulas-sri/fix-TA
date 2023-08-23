@extends('layouts.main', ['title' => 'Kelas', 'page_heading' => 'Edit Kelas'])

@section('content')
<div class="col card px-3 py-3">
	<div class="container">
    <form method="POST" action="{{ route('school-classes.update', $schoolClass) }}">
        @csrf
				@method('PATCH')
        <div class="form-group">
            <label for="name">Nama Kelas</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $schoolClass->name }}" required>
        </div>

        <!-- Tambahkan isian lainnya sesuai kebutuhan -->

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
</div>
@endsection
