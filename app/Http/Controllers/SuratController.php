<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{

    public function index()
    {
        $kategori = DB::table('t_pesan')->select('jenis_pesan')->get();
        $sifat    = DB::table('t_sifat')->select('jenis_sifat')->get();
        $kelompok = DB::table('t_kelompok')->select('jenis_kelompok')->get();
        $staff    = DB::table('users')->select('name')->where('role', 'staff')->get();
        $tembusan = DB::table('t_tembusan')
            ->select('name_tembusan', 'nip')
            ->get();

        return view('surat.formsurat', compact(
            'kategori',
            'sifat',
            'kelompok',
            'staff',
            'tembusan'
        ));
    }

    public function listMasuk()
    {
        // Ambil semua surat masuk, pastikan kolom 'photo' disertakan
        $surat = DB::table('t_masuk')
            ->select('id', 'kode_surat', 'perihal', 'tanggal', 'dari', 'kepada', 'lampiran', 'photo', 'jenis_pesan', 'jenis_sifat')
            ->get();

        return view('surat.masuk', compact('surat'));
    }


    // Daftar Surat Keluar
    public function listKeluar()
    {
        $suratKeluar = DB::table('t_keluar')->get();
        return view('surat.keluar', compact('suratKeluar'));
    }

    public function create()
    {
        $kategori = DB::table('t_pesan')->select('jenis_pesan')->get();
        $sifat    = DB::table('t_sifat')->select('jenis_sifat')->get();
        $kelompok = DB::table('t_kelompok')->select('jenis_kelompok')->get();
        $staff    = DB::table('users')->select('name')->where('role', 'staff')->get();
        $tembusan = DB::table('t_tembusan')->select('name_tembusan', 'nip')->get();

        $isEdit = false;

        return view('surat.formsurat', compact(
            'isEdit',
            'kategori',
            'sifat',
            'kelompok',
            'staff',
            'tembusan'
        ));
    }

    public function store(Request $request)
    {
        // hanya surat masuk
        if ($request->jenis_surat != 1) {
            return back();
        }

        // ================= LAMPIRAN =================
        $lampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $lampiranPaths[] = $file->store('lampiran_surat', 'public');
            }
        }

        // ================= PHOTO =================
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // cek tipe file
            if ($file->isValid()) {
                $photoPath = $file->store('photo_surat', 'public');
            } else {
                return back()->with('error', 'File photo tidak valid');
            }
        }



        // ================= INSERT =================
        $insertId = DB::table('t_masuk')->insertGetId([
            'jenis_surat' => 1,
            'kode_surat'  => $request->kode_surat,
            'perihal'     => $request->perihal,
            'tanggal'     => $request->tanggal,
            'jenis_pesan' => $request->jenis_pesan,
            'jenis_sifat' => $request->jenis_sifat,
            'uraian'      => $request->uraian,
            'keterangan'  => $request->keterangan,
            'dari'        => $request->dari_kelompok ?? $request->dari_staff ?? auth()->user()->name,
            'kepada'      => $request->kepada_kelompok ?? $request->kepada_staff ?? $request->kepada_tembusan ?? null,
            'lampiran'    => json_encode($lampiranPaths),
            'photo'       => $photoPath,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        if (!$insertId) {
            return back()->with('error', 'Gagal menyimpan surat masuk');
        }

        return back()->with('success', 'Surat masuk berhasil disimpan');
    }


    public function storeKeluar(Request $request)
    {
        // hanya surat keluar
        if ($request->jenis_surat != 0) {
            return back()->with('error', 'Jenis surat tidak valid.');
        }

        // ================= LAMPIRAN =================
        $lampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $lampiranPaths[] = $file->store('lampiran_surat', 'public');
            }
        }

        // ================= PHOTO =================
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photo_surat', 'public');
        }

        // ================= KODE SURAT OTOMATIS =================
        $kodeSurat = $request->kode_surat;
        if (!$kodeSurat) {
            $kodeSurat = $this->generateKodeSurat();
        }

        DB::table('t_keluar')->insert([
            'jenis_surat' => 0,
            'kode_surat'  => $kodeSurat,
            'perihal'     => $request->perihal,
            'tanggal'     => $request->tanggal,
            'jenis_pesan' => $request->jenis_pesan,
            'jenis_sifat' => $request->jenis_sifat,
            'uraian'      => $request->uraian,
            'keterangan'  => $request->keterangan,

            'dari' => $request->dari_kelompok
                ?? $request->dari_staff
                ?? auth()->user()->name,

            'kepada' => $request->kepada_kelompok
                ?? $request->kepada_staff
                ?? null,

            'lampiran' => json_encode($lampiranPaths),
            'photo'    => $photoPath,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Surat keluar berhasil disimpan');
    }

    /**
     * Helper untuk generate kode surat otomatis
     */
    private function generateKodeSurat()
    {
        $huruf = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $angka = '0123456789';
        $kodeHuruf = '';
        $kodeAngka = '';

        for ($i = 0; $i < 2; $i++) {
            $kodeHuruf .= $huruf[rand(0, 25)];
        }
        for ($i = 0; $i < 4; $i++) {
            $kodeAngka .= $angka[rand(0, 9)];
        }

        return $kodeHuruf . $kodeAngka;
    }

    // ====================== SURAT MASUK ======================

    // Tampilkan form edit surat masuk
    public function editMasuk($id)
    {
        $surat = DB::table('t_masuk')->where('id', $id)->first();
        if (!$surat) abort(404);

        $kategori = DB::table('t_pesan')->select('jenis_pesan')->get();
        $sifat    = DB::table('t_sifat')->select('jenis_sifat')->get();
        $kelompok = DB::table('t_kelompok')->select('jenis_kelompok')->get();
        $staff    = DB::table('users')->select('name')->where('role', 'staff')->get();
        $tembusan = DB::table('t_tembusan')->select('name_tembusan', 'nip')->get();

        $isEdit = true;

        return view('surat.formsurat', compact('surat', 'kategori', 'sifat', 'kelompok', 'staff', 'tembusan', 'isEdit'));
    }

    // Update surat masuk
    public function updateMasuk(Request $request, $id)
    {
        // Ambil data surat, pastikan semua kolom yang dibutuhkan di-select
        $surat = DB::table('t_masuk')
            ->select(
                'id',
                'kode_surat',
                'perihal',
                'tanggal',
                'jenis_pesan',
                'jenis_sifat',
                'uraian',
                'keterangan',
                'dari',
                'kepada',
                'lampiran',
                'photo'
            )
            ->where('id', $id)
            ->first();

        if (!$surat) {
            return back()->with('error', 'Data surat tidak ditemukan');
        }

        // ================= LAMPIRAN =================

        // default: pakai lampiran lama
        $lampiranPaths = $surat->lampiran ? json_decode($surat->lampiran) : [];

        // kalau upload lampiran baru → hapus lama & ganti
        if ($request->hasFile('lampiran')) {

            // hapus file lama
            foreach ($lampiranPaths as $file) {
                if (Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }

            // reset array
            $lampiranPaths = [];

            // simpan lampiran baru
            foreach ($request->file('lampiran') as $file) {
                $lampiranPaths[] = $file->store('lampiran_surat', 'public');
            }
        }


        // Photo lama (jika ada)
        $photoPath = $surat->photo ?? null;

        // Update photo jika ada file baru
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photo_surat', 'public');
        }

        // Update database
        DB::table('t_masuk')->where('id', $id)->update([
            'kode_surat'  => $request->kode_surat,
            'perihal'     => $request->perihal,
            'tanggal'     => $request->tanggal,
            'jenis_pesan' => $request->jenis_pesan,
            'jenis_sifat' => $request->jenis_sifat,
            'uraian'      => $request->uraian,
            'keterangan'  => $request->keterangan,
            'dari'        => $request->dari_kelompok ?? $request->dari_staff ?? auth()->user()->name,
            'kepada'      => $request->kepada_kelompok ?? $request->kepada_staff ?? $request->kepada_tembusan ?? null,
            'lampiran'    => json_encode($lampiranPaths),
            'photo'       => $photoPath,
            'updated_at'  => now(),
        ]);

        return redirect()->route('surat.masuk')->with('success', 'Surat masuk berhasil diperbarui');
    }


    // Hapus surat masuk
    public function destroyMasuk($id)
    {
        $surat = DB::table('t_masuk')->where('id', $id)->first();

        if (!$surat) {
            return back()->with('error', 'Data surat tidak ditemukan');
        }

        // Hapus file photo jika ada
        if (isset($surat->photo) && $surat->photo) {
            Storage::disk('public')->delete($surat->photo);
        }

        // Hapus lampiran jika ada
        if (isset($surat->lampiran) && $surat->lampiran) {
            $lampirans = json_decode($surat->lampiran) ?? [];
            foreach ($lampirans as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        // Hapus record dari DB
        DB::table('t_masuk')->where('id', $id)->delete();

        return back()->with('success', 'Surat berhasil dihapus');
    }

    // ====================== SURAT KELUAR ======================

    // Tampilkan form edit surat keluar
    public function editKeluar($id)
    {
        $surat = DB::table('t_keluar')->where('id', $id)->first();
        if (!$surat) abort(404);

        $kategori = DB::table('t_pesan')->select('jenis_pesan')->get();
        $sifat    = DB::table('t_sifat')->select('jenis_sifat')->get();
        $kelompok = DB::table('t_kelompok')->select('jenis_kelompok')->get();
        $staff    = DB::table('users')->select('name')->where('role', 'staff')->get();
        $tembusan = DB::table('t_tembusan')->select('name_tembusan', 'nip')->get();

        $isEdit = true;

        return view('surat.formsurat', compact('surat', 'kategori', 'sifat', 'kelompok', 'staff', 'tembusan', 'isEdit'));
    }

    // Update surat keluar
    public function updateKeluar(Request $request, $id)
    {
        $surat = DB::table('t_keluar')->where('id', $id)->first();
        if (!$surat) {
            return back()->with('error', 'Data surat tidak ditemukan');
        }

        // Update lampiran
        $lampiranPaths = json_decode($surat->lampiran) ?? [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $lampiranPaths[] = $file->store('lampiran_surat', 'public');
            }
        }

        // Update photo
        $photoPath = $surat->photo;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photo_surat', 'public');
        }

        DB::table('t_keluar')->where('id', $id)->update([
            'kode_surat'  => $request->kode_surat,
            'perihal'     => $request->perihal,
            'tanggal'     => $request->tanggal,
            'jenis_pesan' => $request->jenis_pesan,
            'jenis_sifat' => $request->jenis_sifat,
            'uraian'      => $request->uraian,
            'keterangan'  => $request->keterangan,
            'dari'        => $request->dari_kelompok ?? $request->dari_staff ?? auth()->user()->name,
            'kepada'      => $request->kepada_kelompok ?? $request->kepada_staff ?? null,
            'lampiran'    => json_encode($lampiranPaths),
            'photo'       => $photoPath,
            'updated_at'  => now(),
        ]);

        return redirect()->route('surat.keluar')->with('success', 'Surat keluar berhasil diperbarui');
    }

    // Hapus surat keluar
    public function destroyKeluar($id)
    {
        $surat = DB::table('t_keluar')->where('id', $id)->first();
        if (!$surat) {
            return back()->with('error', 'Data surat tidak ditemukan');
        }

        // Hapus file photo jika ada
        if ($surat->photo && Storage::disk('public')->exists($surat->photo)) {
            Storage::disk('public')->delete($surat->photo);
        }

        // Hapus lampiran jika ada
        if ($surat->lampiran) {
            foreach (json_decode($surat->lampiran) as $lamp) {
                if (Storage::disk('public')->exists($lamp)) {
                    Storage::disk('public')->delete($lamp);
                }
            }
        }

        DB::table('t_keluar')->where('id', $id)->delete();
        return back()->with('success', 'Surat keluar berhasil dihapus');
    }

    public function rekap(Request $request)
    {
        // default: data kosong
        $rekap = collect();

        // kalau belum pilih jenis → langsung kirim view kosong
        if (!$request->filled('jenis')) {
            return view('surat.formrekap', compact('rekap'));
        }

        $queryMasuk = DB::table('t_masuk')
            ->select(
                'id',
                DB::raw("'Masuk' as jenis"),
                'kode_surat',
                'perihal',
                'tanggal',
                'jenis_pesan',
                'jenis_sifat',
                'dari',
                'kepada'
            );

        $queryKeluar = DB::table('t_keluar')
            ->select(
                'id',
                DB::raw("'Keluar' as jenis"),
                'kode_surat',
                'perihal',
                'tanggal',
                'jenis_pesan',
                'jenis_sifat',
                'dari',
                'kepada'
            );

        // FILTER BULAN & TAHUN
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $queryMasuk->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun);

            $queryKeluar->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun);
        }

        // FILTER JENIS
        if ($request->jenis == 'Masuk') {
            $rekap = $queryMasuk->orderBy('tanggal', 'desc')->get();
        } elseif ($request->jenis == 'Keluar') {
            $rekap = $queryKeluar->orderBy('tanggal', 'desc')->get();
        }

        return view('surat.formrekap', compact('rekap'));
    }

    public function cari(Request $request)
    {
        $kategori = DB::table('t_pesan')->get();

        $data = null;

        if ($request->has('cari')) {

            if ($request->jenis == 'Masuk') {
                $query = DB::table('t_masuk');
            } elseif ($request->jenis == 'Keluar') {
                $query = DB::table('t_keluar');
            } else {
                $query = null;
            }

            if ($query) {

                if ($request->kategori) {
                    $query->where('jenis_pesan', $request->kategori);
                }

                // kalau pakai DATE input → ambil bulan & tahun
                if ($request->filled('bulan') && $request->filled('tahun')) {
                    $query->whereMonth('tanggal', $request->bulan)
                        ->whereYear('tanggal', $request->tahun);

                    $query->whereMonth('tanggal', $request->bulan)
                        ->whereYear('tanggal', $request->tahun);
                }

                if ($request->keyword) {
                    $query->where(function ($q) use ($request) {
                        $q->where('perihal', 'like', '%' . $request->keyword . '%')
                            ->orWhere('kode_surat', 'like', '%' . $request->keyword . '%');
                    });
                }

                $data = $query->get(); // SIMPAN KE $data
            }
        }

        return view('surat.cari', compact('kategori', 'data'));
    }
}
