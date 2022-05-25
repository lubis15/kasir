<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class Report extends BaseController
{
    protected $transaksi;
    protected $transaksiDetail;

    function __construct()
    {
        $this->transaksi = new TransaksiModel();
        $this->transaksiDetail = new TransaksiDetailModel();
    }

    public function index()
    {
        $data['tglAwal'] = $this->request->getVar('tglawal');
        $data['tglAkhir'] = $this->request->getVar('tglakhir');
        $whereTgl = [];

        if (($data['tglAwal'] != "") and ($data['tglAkhir'] != "")) {
            $whereTgl = [
                'CAST(transaksi.created_at as DATE) >=' => $this->request->getVar('tglawal'),
                'CAST(transaksi.created_at as DATE) <=' => $this->request->getVar('tglakhir')
            ];
        }


        $data['title'] = "Report Transaksi";
        $data['report'] = $this->transaksi->select('transaksi.*, users.nama,sum(transaksi_detail.total) as total,cast(transaksi.created_at as date) as tanggal_transaksi')
            ->join('users', 'transaksi.username=users.username')
            ->join('transaksi_detail', 'transaksi.id_transaksi=transaksi_detail.id_transaksi')
            ->where($whereTgl)
            ->groupBy('transaksi_detail.id_transaksi')
            ->orderBy('transaksi.created_at')
            ->paginate($this->perPage, 'transaksi');
        $data['pager'] = $this->transaksi->pager;
        $data['nomor'] = nomor($this->request->getVar('page_transaksi'), $this->perPage);
        return view('report/index', $data);
    }

    function detail($id)
    {
        $dataTransaksi = $this->transaksi->find($id);
        if (empty($dataTransaksi)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Transaksi Tidak Ada');
        }

        $data['title'] = "Detail Transaksi";
        $data['transaksi'] = $this->transaksi->select('transaksi.*,users.nama')
            ->join('users', 'transaksi.username=users.username')
            ->where('id_transaksi', $id)
            ->first();

        $data['detail'] = $this->transaksiDetail->select('transaksi_detail.*,produk.nama_produk')
            ->join('produk', 'transaksi_detail.id_produk=produk.id_produk')
            ->where('id_transaksi', $id)->findAll();

        return view('report/detail', $data);
    }

    function exportPdf()
    {
        $tglAwal = $this->request->getVar('tglawal');
        $tglAkhir = $this->request->getVar('tglakhir');

        $whereTgl = [];

        $title = "";

        if (($tglAwal != "") and ($tglAkhir != "")) {
            $whereTgl = [
                'CAST(transaksi.created_at AS DATE) >=' => $tglAwal,
                'CAST(transaksi.created_at AS DATE) <=' => $tglAkhir
            ];

            $title = "Report Transaksi (" . tanggal($tglAwal) . " - " . tanggal($tglAkhir) . ")";
        } else {
            $title = "Report Seluruh Transaksi";
        }

        $data['report'] = $this->transaksi->select('transaksi.*,users.nama,sum(transaksi_detail.total) as total,cast(transaksi.created_at as date) as tanggal_transaksi')
            ->join('users', 'transaksi.username=users.username')
            ->join('transaksi_detail', 'transaksi.id_transaksi=transaksi_detail.id_transaksi')
            ->where($whereTgl)
            ->groupBy('transaksi_detail.id_transaksi')
            ->orderBy('transaksi.created_at', 'desc')
            ->findAll();

        $dompdf = new \Dompdf\Dompdf();
        $data['title'] = $title;
        $dompdf->loadHtml(view('report/pdf', $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream($title . '.pdf');
    }

    function exportExcel()
    {
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', 'No')
            ->setCellValue('B2', 'No Transaksi')
            ->setCellValue('C2', 'Tanggal Transaksi')
            ->setCellValue('D2', 'Kasir')
            ->setCellValue('E2', 'Nama Pelanggan')
            ->setCellValue('F2', 'No Meja')
            ->setCellValue('G2', 'Catatan')
            ->setCellValue('H2', 'Total');

        $tglAwal = $this->request->getVar('tglawal');
        $tglAkhir = $this->request->getVar('tglakhir');

        $whereTgl = [];

        $judul = "";

        if (($tglAwal != "") and ($tglAkhir != "")) {
            $whereTgl = [
                'CAST(transaksi.created_at AS DATE) >=' => $tglAwal,
                'CAST(transaksi.created_at AS DATE) <=' => $tglAkhir
            ];

            $judul = "Report Transaksi (" . tanggal($tglAwal) . " - " . tanggal($tglAkhir) . ")";
        } else {
            $judul = "Report Seluruh Transaksi";
        }

        $report = $this->transaksi->select('transaksi.*,users.nama,sum(transaksi_detail.total) as total,cast(transaksi.created_at as date) as tanggal_transaksi')
            ->join('users', 'transaksi.username=users.username')
            ->join('transaksi_detail', 'transaksi.id_transaksi=transaksi_detail.id_transaksi')
            ->where($whereTgl)
            ->groupBy('transaksi_detail.id_transaksi')
            ->orderBy('transaksi.created_at', 'desc')
            ->findAll();

        $spreadsheet->getActiveSheet()->mergeCells("A1:H1");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $judul);

        $baris = 3;
        $no = 1;
        foreach ($report as $row) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $baris, $no++)
                ->setCellValue('B' . $baris, $row->no_transaksi, DataType::TYPE_STRING)
                ->setCellValue('C' . $baris, tanggal($row->tanggal_transaksi))
                ->setCellValue('D' . $baris, $row->nama)
                ->setCellValue('E' . $baris, $row->nama_pelanggan)
                ->setCellValue('F' . $baris, $row->no_meja)
                ->setCellValue('G' . $baris, $row->catatan)
                ->setCellValue('H' . $baris, rupiah($row->total));
            $baris++;
        }

        foreach (range('A', 'H') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A2:H' . ($baris - 1))->applyFromArray($styleArray);

        $spreadsheet->getActiveSheet()->getStyle('A1:H' . ($baris - 1))->getAlignment()->setHorizontal('center');

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judul . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    //--------------------------------------------------------------------

}
