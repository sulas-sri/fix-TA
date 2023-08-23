@extends('layouts.main', ['title' => 'Edit Siswa', 'page_heading' => 'Edit Data Siswa'])

@section('content')
<div class="col card px-3 py-3">
	<div class="container">
    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf
				@method('PATCH')
        <div class="form-group">
            <label for="student_identification_number">Nomor Induk Siswa</label>
            <input type="text" class="form-control" id="student_identification_number" name="student_identification_number" value="{{ $student->student_identification_number }}" disabled>
        </div>
				<div class="form-group">
					<label for="name">Nama Siswa</label>
					<input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}" required>
				</div>
				<div class="form-group">
					<label for="class">Kelas</label>
					<select class="form-control" id="class" name="school_class_id" required>
							<option value="{{ $student->school_class->id }}">{{ $student->school_class->name }}</option>
							@foreach ($class as $i)
							<option value="{{ $i->id }}">{{ $i->name }}</option>
							@endforeach
					</select>
				</div>			
				<div class="form-group">
					<label for="email">Email</label>
					<input type="text" class="form-control" id="email" name="email" value="{{ $student->email }}" required>
				</div>
				<div class="form-group">
					<label for="phone_number">Nomor Telepon</label>
					<input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $student->phone_number }}" required>
				</div>
				<div class="form-group">
					<label for="gender">Jenis Kelamin</label>
					<input type="text" class="form-control" id="gender" name="gender" value="{{ $student->gender == 1 ? 'Laki - laki' : 'Perempuan' }}" disabled>
				</div>
				<div class="form-group">
					<label for="school_year_start">Tahun Mulai Sekolah</label>
					<input type="text" class="form-control" id="school_year_start" name="school_year_start" value="{{ $student->school_year_start }}" required>
				</div>
				<div class="form-group">
					<label for="school_year_end">Tahun Selesai Sekolah</label>
					<input type="text" class="form-control" id="school_year_end" name="school_year_end" value="{{ $student->school_year_end }}" required>
				</div>

        <!-- Tambahkan isian lainnya sesuai kebutuhan -->

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
</div>
@endsection
