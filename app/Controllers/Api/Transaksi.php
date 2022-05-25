<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class transaksi extends ResourceController
{
    protected $format = 'json';
    protected $modelName = 'App\Models\TransaksiModel';

    function __construct()
    {
        helper('myhelper');
    }

    public function checkout()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong'
                ]
            ],
            'nama_pelanggan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak boleh kosong'
                ]
            ],
            'no_meja' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Tidak boleh kosong',
                    'numeric' => '{field} Harus Berupa Angka'
                ]
            ]
        ])) {
            $response = [
                'error' => true,
                'message' => $this->validator->getErrors()
            ];

            return $this->respond($response);
        }

        $username = $this->request->getVar('username');
        $namaPelanggan = $this->request->getVar('nama_pelanggan');
        $noMeja = $this->request->getVar('no_meja');
        $catatan = $this->request->getVar('catatan');

        $dataTransaksi = [
            'no_transaksi' => $this->model->noTransaksi(date('Y-m-d')),
            'username' => $username,
            'no_meja' => $noMeja,
            'nama_pelanggan' => $namaPelanggan,
            'catatan' => $catatan
        ];

        $this->model->insert($dataTransaksi);

        $idTransaksi = $this->model->getMaxIdTransaksiUsers($username);

        $keranjang = new \App\Models\KeranjangModel();
        $transaksiDetail = new \App\Models\TransaksiDetailModel();

        $dataKeranjangUsername = $keranjang->where('username', $username)->findAll();
        foreach ($dataKeranjangUsername as $row) {
            $transaksiDetail->insert([
                'id_transaksi' => $idTransaksi,
                'id_produk' => $row->id_produk,
                'jumlah' => $row->jumlah,
                'harga' => $row->harga,
                'total' => $row->total
            ]);
        }

        $keranjang->where(['username' => $username])->delete();
        $response = [
            'error' => false,
            'message' => 'Proses Checkout Berhasil',
        ];
        return $this->respond($response);
    }


    function getKasir()
    {
        $users = new \App\Models\UsersModel();
        $dataUser = $users->select('users.*')->whereIn('username', function ($users) {
            return $users->select('username')->from('transaksi');
        })->findAll();
        $response = [
            'error' => false,
            'data' => $dataUser
        ];
        return $this->respond($response);
    }

    function getDataByDate()
    {
        $tglAwal = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');
        $noTransaksi = $this->request->getVar('no_transaksi');
        $whereTglTransaksi = [
            'CAST(transaksi.created_at AS DATE) >=' => $tglAwal,
            'CAST(transaksi.created_at as DATE) <=' => $tglAkhir
        ];

        $likeNoTransaksi = [];
        if ($noTransaksi != "") {
            $likeNoTransaksi = ['no_transaksi' => $noTransaksi];
        }

        $report = $this->model->select('transaksi.*,sum(transaksi_detail.total) as total')
            ->join('transaksi_detail', 'transaksi.id_transaksi=transaksi_detail.id_transaksi')
            ->where($whereTglTransaksi)
            ->like($likeNoTransaksi)
            ->groupBy('transaksi_detail.id_transaksi')
            ->orderBy('created_at', 'desc')
            ->findAll();

        $response = [
            'error' => false,
            'data' => $report
        ];

        return $this->respond($response);
    }

    function getDataByKasir()
    {
        $username = $this->request->getVar('username');
        $noTransaksi = $this->request->getVar('no_transaksi');

        $whereKasir = ['username' => $username];
        $likeNoTransaksi = [];
        if ($noTransaksi != "") {
            $likeNoTransaksi = ['no_transaksi' => $noTransaksi];
        }


        $report = $this->model->select('transaksi.*,sum(transaksi_detail.total) as total')
            ->join('transaksi_detail', 'transaksi.id_transaksi=transaksi_detail.id_transaksi')
            ->where($whereKasir)
            ->like($likeNoTransaksi)
            ->groupBy('transaksi_detail.id_transaksi')
            ->orderBy('created_at', 'desc')
            ->findAll();

        $response = [
            'error' => false,
            'data' => $report
        ];

        return $this->respond($response);
    }

    function getDetailData()
    {
        $id = $this->request->getVar('id_transaksi');
        $transaksiDetail = new \App\Models\TransaksiDetailModel();
        $path = base_url() . "/uploads/produk/";
        $dataTransaksiDetail = $transaksiDetail->select("transaksi_detail.*,CONCAT('$path',produk.gambar_produk) as gambar_produk,produk.nama_produk")
            ->join('produk', 'transaksi_detail.id_produk=produk.id_produk')
            ->where('id_transaksi', $id)
            ->orderBy('created_at', 'desc')
            ->findAll();

        $response = [
            'error' => false,
            'data' => $dataTransaksiDetail
        ];
        return $this->respond($response);
    }

    function getChart()
    {
        $tahun = $this->request->getVar('tahun');
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $report = $this->model->select("count('id_transaksi') as jumlah")
                ->where([
                    'MONTH(created_at)' => $i,
                    'YEAR(created_at)' => $tahun
                ])->get();

            if ($i < 10) {
                $x = "0" . $i;
            } else {
                $x = $i;
            }

            $data = [
                'nama_bulan' => namaBulan($x),
                'data' => $report->getRow()->jumlah
            ];

            $result[] = $data;
        }

        $response = [
            'error' => false,
            'data' => $result
        ];

        return $this->respond($response);
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

        $tglAwal = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

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

        $report = $this->model->select('transaksi.*,users.nama,sum(transaksi_detail.total) as total,cast(transaksi.created_at as date) as tanggal_transaksi')
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

        $namaFile = time();
        $posisiFile = "report-excel/" . $namaFile . ".xlsx";
        $writer = new Xlsx($spreadsheet);
        $writer->save($posisiFile);

        $response = [
            'error' => false,
            'data' => base_url() . "/" . $posisiFile,
        ];

        return $this->respond($response);
    }

    function exportPdf()
    {
        $tglAwal = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

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

        $data['report'] = $this->model->select('transaksi.*,users.nama,sum(transaksi_detail.total) as total,cast(transaksi.created_at as date) as tanggal_transaksi')
            ->join('users', 'transaksi.username=users.username')
            ->join('transaksi_detail', 'transaksi.id_transaksi=transaksi_detail.id_transaksi')
            ->where($whereTgl)
            ->groupBy('transaksi_detail.id_transaksi')
            ->orderBy('transaksi.created_at', 'desc')
            ->findAll();

        $dompdf = new \Dompdf\Dompdf();
        $data['title'] = $title;
        $namaFile = time();
        $posisiFile = "report-pdf/" . $namaFile . ".pdf";
        $dompdf->loadHtml(view('report/pdf', $data));
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents($posisiFile, $output);

        $response = [
            'error' => false,
            'data' => base_url() . "/" . $posisiFile,
        ];

        return $this->respond($response);
    }
}
