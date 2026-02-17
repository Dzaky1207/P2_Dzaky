<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PemeriksaanController extends Controller
{
    public function storePemeriksaan(Request $request)
    {
        $request->validate([
            'kode_pasien'   => 'required|exists:t_pasien,kode_pasien',
            'tinggi_badan'  => 'required|numeric',
            'berat_badan'   => 'required|numeric',
            'suhu_badan'    => 'required|numeric',
            'tensi'         => 'required|string',
            'keluhan'       => 'nullable|string',
            'catatan_obat'  => 'nullable|string',
        ]);

        $aksi = $request->aksi;

        // Insert ke tabel t_pemeriksaan
        DB::table('t_pemeriksaan')->insert([
            'kode_pasien'   => $request->kode_pasien,
            'tinggi_badan'  => $request->tinggi_badan,
            'berat_badan'   => $request->berat_badan,
            'suhu_badan'    => $request->suhu_badan,
            'tensi'         => $request->tensi,
            'keluhan'       => $request->keluhan,
            'catatan_obat'  => $request->catatan_obat,
            'created_at'    => now(),
        ]);

        // Update status pasien sesuai tombol
        if ($aksi === 'rujukan') {
            DB::table('t_pasien')
                ->where('kode_pasien', $request->kode_pasien)
                ->update(['status_kunjungan' => 'rujukan', 'updated_at' => now()]);
            $msg = 'Data pemeriksaan disimpan & pasien dirujuk';
        } elseif ($aksi === 'selesai') {
            DB::table('t_pasien')
                ->where('kode_pasien', $request->kode_pasien)
                ->update(['status_kunjungan' => 'ambil obat', 'updated_at' => now()]);

            // Insert ke farmasi jika belum ada (untuk ambil obat)
            $existing = DB::table('t_farmasi')
                ->where('kode_pasien', $request->kode_pasien)
                ->first();
            
            if (!$existing) {
                DB::table('t_farmasi')->insert([
                    'kode_pasien'      => $request->kode_pasien,
                    'status_kunjungan' => 'ambil obat',
                    'catatan_obat'     => $request->catatan_obat ?? '',
                    'created_at'       => now(),
                ]);
            }

            $msg = 'Data pemeriksaan disimpan & pasien siap ambil obat';
        } else {
            $msg = 'Data pemeriksaan disimpan';
        }

        return redirect()->back()->with('success', $msg);
    }
}
