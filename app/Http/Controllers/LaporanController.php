<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\Barangmasuk;
use App\Models\Barangkeluar;
use App\Models\Peminjam;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function barangmasuk()
    {
        return view('admin.laporan.form');
    }

    public function reportBarangMasuk(Request $request)
    {
        $start = $request->tanggalAwal;
        $end = $request->tanggalAkhir;
        if ($start > $end) {
            Alert::error('Oops', 'Maaf tanggal yang anda masukan tidak sesuai')->autoclose(2000);
            return back();

        } else {
            $bmasuk = Barangmasuk::whereBetween('created_at', [$start, $end])->get();
            $bkeluar = Barangkeluar::whereBetween('created_at', [$start, $end])->get();
            $peminjam = Peminjam::whereBetween('created_at', [$start, $end])->get();
            $pengembalian = Pengembalian::whereBetween('created_at', [$start, $end])->get();

            foreach ($bmasuk as $value) {
                $jumlah += $value->jumlah;
            }
            
         
            return view('admin.laporan.cetak_laporan', ['bmasuk' => $bmasuk, 'bkeluar' => $bkeluar,'peminjam' => $peminjam,
            'pengembalian' => $pengembalian]);
        }

    }
}