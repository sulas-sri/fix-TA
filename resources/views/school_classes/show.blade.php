@extends('layouts.main', ['title' => 'Kelas', 'page_heading' => 'Detail Kelas'])

@section('content')
<section class="row">

	@include('utilities.alert-flash-message')
	<div class="col card px-3 py-3">
		<div class="container">
			<table class="table table-bordered">
				<tr>
						<th>Nama Kelas</th>
						<td>{{ $schoolClass->name }}</td>
				</tr>
				<!-- Tambahkan informasi lainnya sesuai kebutuhan -->
		</table>

		<a href="{{ route('school-classes.index') }}" class="btn btn-primary">Kembali ke Data Kelas</a>
		</div>
</div>

</section>
@endsection

{{-- @push('modal')
@include('students.modal.create')
@include('students.modal.show')
@include('students.modal.edit')
@endpush --}}

{{-- @push('js')
@include('students.script')
@endpush --}}
