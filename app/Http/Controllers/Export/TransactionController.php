<?php

namespace App\Http\Controllers\Export;

use App\Contracts\ExcelExportInterface;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Repositories\ExportRepository;
use Illuminate\Database\Eloquent\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionController extends Controller implements ExcelExportInterface
{
    const FILE_NAME = 'laporan-pengeluaran';

    public function __invoke()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $this->setExcelHeader($spreadsheet);

        $transactions = Transaction::select('id', 'amount', 'description', 'date')
            // ->whereBetween('date', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')])
            ->latest()
            ->get();

        $this->setExcelContent($transactions, $sheet);

        ExportRepository::outputTheExcel($spreadsheet, self::FILE_NAME);
    }

    /**
     * Menyiapkan isi header untuk excelnya.
     *
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
     * @return \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
     */
    public function setExcelHeader(Spreadsheet $spreadsheet): Worksheet
    {
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal Pengeluaran');
        $sheet->setCellValue('C1', 'Deskripsi');
        $sheet->setCellValue('D1', 'Total Pengeluaran');

        foreach (range('A', 'D') as $paragraph) {
            $sheet->getColumnDimension($paragraph)->setAutoSize(true);
        }

        return $sheet;
    }

    /**
     * Mengisi konten untuk excel.
     *
     * @param \Illuminate\Database\Eloquent\Collection adalah data yang didapat dari eloquent/query builder.
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet adalah instansiasi dari class Spreadsheet phpoffice.
     * @return \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
     */
    public function setExcelContent(Collection $transactions, Worksheet $sheet): Worksheet
    {
        $cell = 2;
        foreach ($transactions as $key => $row) {
            $sheet->setCellValue('A' . $cell, $key + 1);
            $sheet->setCellValue('B' . $cell, date('d-m-Y', strtotime($row->date)));
            $sheet->setCellValue('C' . $cell, $row->description);
            $sheet->getStyle('A1:C' . $cell)->applyFromArray(ExportRepository::setStyle());
            $cell++;
        }

        $sheet->setCellValue('B' . $cell, 'Total Pengeluaran');
        $sheet->setCellValue('C' . $cell, $transactions->sum('amount'));
        $sheet->getStyle('B' . $cell)->applyFromArray(ExportRepository::setStyle());
        $sheet->getStyle('C' . $cell)->applyFromArray(ExportRepository::setStyle());
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        return $sheet;
    }
}
