<!DOCTYPE html>
<html>
<head>
    <title>Kwitansi Pembayaran</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }

        .kwitansi-container {
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 20px;
            /* box-sizing: border-box; */
        }

        .user-section, .admin-section {
            width: 90%;
            border: 1px solid #ccc;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .wide-border {
            border-width: 2px;
        }

        .terbilang {
            margin-top: 20px;
						font-style: italic;
        }
				.judul {
					text-align: center;
				}
				/* Gaya CSS untuk pembatas garis putus-putus */
				.hr-divider {
					border-top: 1px dashed #000; /* Warna dan tipe garis putus-putus yang diinginkan */
    			margin-top: 20px;
					/* width: 90%; Sesuaikan dengan jarak yang Anda inginkan antara bagian "user" dan "admin" */
				}
    </style>
		<?php
		function terbilang($angka)
		{
				$angka = abs($angka);
				$huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan"];
				$nol = "";
				$belas = "Belas";
				$puluh = "Puluh";
				$ratus = "Ratus";
				$ribu = "Ribu";
				$juta = "Juta";
				$milyar = "Milyar";
				$triliun = "Triliun";

				$hasil = "";

				if ($angka == 0) {
						$hasil = $nol;
				} elseif ($angka < 10) {
						$hasil = $huruf[$angka];
				} elseif ($angka == 10) {
						$hasil = $puluh;
				} elseif ($angka < 20) {
						$hasil = $huruf[$angka - 10] . " " . $belas;
				} elseif ($angka < 100) {
						$hasil = $huruf[floor($angka / 10)] . " " . $puluh . " " . $huruf[$angka % 10];
				} elseif ($angka < 1000) {
						$hasil = $huruf[floor($angka / 100)] . " " . $ratus . " " . terbilang($angka % 100);
				} elseif ($angka < 1000000) {
						$hasil = terbilang(floor($angka / 1000)) . " " . $ribu . " " . terbilang($angka % 1000);
				} elseif ($angka < 1000000000) {
						$hasil = terbilang(floor($angka / 1000000)) . " " . $juta . " " . terbilang($angka % 1000000);
				} elseif ($angka < 1000000000000) {
						$hasil = terbilang(floor($angka / 1000000000)) . " " . $milyar . " " . terbilang($angka % 1000000000);
				} elseif ($angka >= 1000000000000) {
						$hasil = terbilang(floor($angka / 1000000000000)) . " " . $triliun . " " . terbilang($angka % 1000000000000);
				}

				return $hasil;
		}

		// Contoh penggunaan:
		// $angka = 1234567;
		// echo "Terbilang: " . terbilang($angka);
		?>

</head>
<body>
    <div class="kwitansi-container">
        <div class="user-section">
					<h2 class="judul">KWITANSI PEMBAYARAN</h2>
					<h3 class="judul">SD IT Al Kamilah</h3>
            <table>
                <tr>
                    <th class="wide-border">Nomor Transaksi</th>
                    <td>{{ $cashTransaction->id }}</td>
                </tr>
                <tr>
                    <th class="wide-border">Telah diterima dari</th>
                    <td>
                        @if ($cashTransaction->students)
                            {{ $cashTransaction->students->name }}
                        @else
                            [Data Pelajar Tidak Tersedia]
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="wide-border">Uang Sejumlah</th>
                    <td>Rp {{ number_format($cashTransaction->amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th class="wide-border">Guna Pembayaran</th>
                    <td>
                        @php
                            $categories = $cashTransaction->category;
                            if (is_array($categories)) {
                                echo implode(', ', $categories);
                            } else {
                                echo $categories;
                            }
                        @endphp
                    </td>
                </tr>
                <tr>
                    <th class="wide-border">Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($cashTransaction->date)->format('d F Y') }}</td>
                </tr>
                <!-- Tambahkan konten lainnya sesuai dengan kebutuhan kwitansi PDF untuk user -->
            </table>
            <p class="terbilang"><strong>Terbilang:</strong> {{ terbilang($cashTransaction->amount) }} Rupiah</p>
        </div>
			</br>
				<!-- Pembatas garis putus-putus -->
				<hr class="hr-divider">
			</br>
        <div class="admin-section">
            <h2 class="judul">KWITANSI PEMBAYARAN</h2>
						<h3 class="judul">SD IT Al Kamilah</h3>
            <table>
                <tr>
                    <th class="wide-border">Nomor Transaksi</th>
                    <td>{{ $cashTransaction->id }}</td>
                </tr>
                <tr>
                    <th class="wide-border">Telah diterima dari</th>
                    <td>
                        @if ($cashTransaction->students)
                            {{ $cashTransaction->students->name }}
                        @else
                            [Data Pelajar Tidak Tersedia]
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="wide-border">Uang Sejumlah</th>
                    <td>Rp {{ number_format($cashTransaction->amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th class="wide-border">Guna Pembayaran</th>
                    <td>
                        @php
                            $categories = $cashTransaction->category;
                            if (is_array($categories)) {
                                echo implode(', ', $categories);
                            } else {
                                echo $categories;
                            }
                        @endphp
                    </td>
                </tr>
                <tr>
                    <th class="wide-border">Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($cashTransaction->date)->format('d F Y') }}</td>
                </tr>
                <!-- Tambahkan konten lainnya sesuai dengan kebutuhan kwitansi PDF untuk admin -->
            </table>
            <p class="terbilang"><strong>Terbilang:</strong> {{ terbilang($cashTransaction->amount) }} Rupiah</p>
        </div>
    </div>
</body>
</html>
