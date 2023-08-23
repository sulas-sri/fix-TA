@extends('layouts.main', ['title' => 'Tagihan', 'page_heading' => 'Data Tagihan'])

@section('content')
    <section class="row">
        {{-- Start Statistics --}}
        {{-- <div class="col-6 col-lg-6 col-md-6">
            <div class="card">
							<div class="card-body px-3 py-4-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon">
                                <i class="iconly-boldChart"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Total Bulan Ini</h6>
                            <h6 class="font-extrabold mb-0">{{ $data['totals']['thisMonth'] }}</h6>
                        </div>
            </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-6 col-md-6">
            <div class="card">
            <div class="card-body px-3 py-4-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon">
                                <i class="iconly-boldChart"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Total Tahun Ini</h6>
                            <h6 class="font-extrabold mb-0">{{ $data['totals']['thisYear'] }}</h6>
                        </div>
            </div>
                </div>
            </div>
        </div> --}}

        <div class="col-6 col-lg-6 col-md-6">
            <div class="card">
            <div class="card-body px-3 py-4-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon green">
                                <i class="iconly-boldActivity"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Sudah Membayar Minggu Ini</h6>
                            <h6 class="font-extrabold mb-0">{{ $data['studentCountWho']['paidThisWeek'] }}</h6>
                        </div>
            </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body px-3 py-4-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon red">
                                <i class="iconly-boldActivity"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Belum Membayar Minggu Ini</h6>
                            <h6 class="font-extrabold mb-0">{{ $data['studentCountWho']['notPaidThisWeek'] }}</h6>
                        </div>
        </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Belum Membayar Minggu Ini</h4>
                </div>
                @if ($data['studentCountWho']['notPaidThisWeek'] > 0)
                    <div class="px-4">
                        <button type="button" class='btn btn-block btn-xl btn-light-danger font-bold mt-3'
                            data-bs-toggle="modal" data-bs-target="#lookMoreModal">Ada
                            <b>{{ $data['studentCountWho']['notPaidThisWeek'] }}</b> orang belum membayar pada minggu ini! <i
                                class="bi bi-exclamation-triangle"></i></button>
                    </div>

                    <span class="badge w-100 rounded-pill bg-warning mb-3"></span>
                    <div class="card-content pb-4">
                        <div class="row">
                            @foreach ($data['students']['notPaidThisWeekLimit'] as $studentNotPaidThisWeek)
                                <div class="col-6 col-lg-6 col-md-6">
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="name ms-4">
                                            <h5 class="mb-1">{{ $studentNotPaidThisWeek->name }}</h5>
                                            <h6 class="text-muted mb-0">{{ $studentNotPaidThisWeek->student_identification_number }}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="px-4">
                            <button type="button" class='btn btn-block btn-xl btn-light-primary font-bold mt-3'
                                data-bs-toggle="modal" data-bs-target="#lookMoreModal">Lihat
                                Selengkapnya</button>
                        </div>
                    </div>
                @else
                    <div class="px-4">
                        <p class='btn btn-block btn-xl btn-light-success font-bold my-3'>Terima kasih! Semua sudah membayar <i
                                class="bi bi-emoji-laughing"></i></p>
                    </div>
                @endif
            </div>
        </div>
        {{-- End of Statistics --}}

        @include('utilities.alert-flash-message')
        <div class="col card px-3 py-3">
            <div class="d-flex justify-content-end pb-3">
                <div class="btn-group d-gap gap-2">
                    {{-- <a href="{{ route('billings.export') }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
                    </a> --}}
                    {{-- <a href="{{ route('billings.history') }}" class="btn btn-secondary">
                        <span class="badge">{{ $billingTrashedCount }}</span> Histori Data Tagihan
                    </a> --}}
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBillingModal">
                        <i class="bi bi-plus-circle"></i> Tambah Data
                    </button>
                    <button type="button" class="btn btn-warning" id="sendBillingsButton">
                        Kirim Semua Notifikasi
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm w-100" id="datatable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Siswa</th>
                            <th scope="col">ID Telegram</th>
                            <th scope="col">Total Tagihan</th>
                            <th scope="col">Kategori Tagihan</th>
                            <th scope="col">Jatuh Tempo</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('modal')
    @include('billings.modal.create')
    @include('billings.modal.show')
    @include('billings.modal.edit')
    @include('billings.modal.look-more')
@endpush

@push('js')
    @include('billings.script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tambahkan event listener untuk tombol "Kirim Semua Notifikasi"
            const sendBillingsButton = document.getElementById('sendBillingsButton');
            sendBillingsButton.addEventListener('click', function() {
                // Kirim permintaan AJAX untuk mengirim notifikasi
                const BASE_URL = '{{ route('billings.sendNotificationToAll') }}';
                fetch(BASE_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Tampilkan pesan berhasil atau gagal sesuai respons dari server
                        if (data.success) {
                            alert('Notifikasi berhasil dikirim ke semua data tagihan.');
                        } else {
                            alert('Terjadi kesalahan. Gagal mengirim notifikasi.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Gagal mengirim notifikasi.');
                    });
            });
        });
    </script>
@endpush
