<?php
if (!function_exists('nomor')) {
    function nomor($currentPage, $perPage)
    {
        if (is_null($currentPage)) {
            $nomor = 1;
        } else {
            $nomor = 1 + ($perPage * ($currentPage - 1));
        }
        return $nomor;
    }
}

if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        if ($angka == null) {
            return "0";
        } else {
            $jumlah_desimal = "0";
            $pemisah_desimal = ",";
            $pemisah_ribuan = ".";
            return  $rupiah = "Rp. " . number_format($angka, $jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) . ",-";
        }
    }
}


if (!function_exists('tanggal')) {
    function tanggal($tanggal)
    {
        $data = explode('-', $tanggal);
        return $data['2'] . " " . namaBulan($data['1']) . " " . $data['0'];
    }
}


if (!function_exists('namaBulan')) {
    function namaBulan($bulan)
    {
        switch ($bulan) {
            case "01":
                return "Januari";
                break;
            case "02":
                return "Februari";
                break;
            case "03":
                return "Maret";
                break;
            case "04":
                return "April";
                break;
            case "05":
                return "Mei";
                break;
            case "06":
                return "Juni";
                break;
            case "07":
                return "Juli";
                break;
            case "08":
                return "Agustus";
                break;
            case "09":
                return "September";
                break;
            case "10":
                return "Oktober";
                break;
            case "11":
                return "November";
                break;
            case "12":
                return "Desember";
                break;
        }
    }
}
