<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    // ======================
    // TAMPILAN LIST ANTRIAN
    // ======================
    public function index()
    {
        $Antrian = DB::table('t_antrian')
            ->orderBy('waktu_masuk', 'asc')
            ->get();

        return view('Antrian.antrian', compact('Antrian'));
    }

    // ======================
    // HALAMAN PEMERIKSAAN
    // ======================
    public function periksa($id)
    {
        $antrian = DB::table('t_antrian')
            ->where('id', $id)
            ->first();

        if (!$antrian) {
            return redirect()->back()
                ->with('error', 'Data antrian tidak ditemukan');
        }

        // Ambil riwayat pemeriksaan pasien
        $riwayat = DB::table('t_pemeriksaan')
            ->where('kode_pasien', $antrian->kode_pasien)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Antrian.pemeriksaan', compact('antrian', 'riwayat'));
    }

    public function store(Request $request)
    {
        $aksi = $request->aksi; // 'simpan' atau 'akhiri'

        if ($aksi === 'simpan') {
            // Validasi untuk simpan pemeriksaan
            $request->validate([
                'kode_pasien'   => 'required|exists:t_pasien,kode_pasien',
                'tinggi_badan'  => 'required|numeric',
                'berat_badan'   => 'required|numeric',
                'suhu_badan'    => 'required|numeric',
                'tensi'         => 'required|string',
                'keluhan'       => 'nullable|string',
                'catatan_obat'  => 'nullable|string',
            ]);

            // Insert ke t_pemeriksaan
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

            // Update status pasien di t_pasien
            DB::table('t_pasien')
                ->where('kode_pasien', $request->kode_pasien)
                ->update([
                    'status_kunjungan' => 'pemeriksaan',
                    'updated_at' => now()
                ]);

            // Update status pasien di t_antrian
            DB::table('t_antrian')
                ->where('kode_pasien', $request->kode_pasien)
                ->update([
                    'status_kunjungan' => 'pemeriksaan',
                    'updated_at' => now()
                ]);

            return redirect()->back()->with('success', 'Data pemeriksaan disimpan dan status antrian diperbarui');
        } elseif ($aksi === 'akhiri') {
            // Validasi untuk akhiri sesi farmasi
            $request->validate([
                'kode_pasien'   => 'required|exists:t_pasien,kode_pasien',
                'catatan_obat'  => 'nullable|string',
            ]);

            // Ambil data pemeriksaan terakhir
            $pemeriksaan = DB::table('t_pemeriksaan')
                ->where('kode_pasien', $request->kode_pasien)
                ->latest()
                ->first();

            // Insert ke t_farmasi + status ambil obat (cek duplikasi)
            $existing = DB::table('t_farmasi')
                ->where('kode_pasien', $request->kode_pasien)
                ->first();
            
            if (!$existing) {
                DB::table('t_farmasi')->insert([
                    'kode_pasien'        => $request->kode_pasien,
                    'catatan_obat'       => $request->catatan_obat ?? $pemeriksaan->catatan_obat ?? '',
                    'status_kunjungan'   => 'ambil obat',
                    'created_at'         => now(),
                ]);
            }

            // Update status pasien di t_pasien menjadi 'ambil obat'
            DB::table('t_pasien')
                ->where('kode_pasien', $request->kode_pasien)
                ->update([
                    'status_kunjungan' => 'ambil obat',
                    'updated_at' => now()
                ]);

            // Hapus pasien dari antrian
            DB::table('t_antrian')
                ->where('kode_pasien', $request->kode_pasien)
                ->delete();

            return redirect()->route('Antrian.antrian')
                ->with('success', 'Sesi diakhiri, pasien siap ambil obat');
        } else {
            return redirect()->back()->with('error', 'Aksi tidak valid');
        }
    }
}
