<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelompokController extends Controller
{
    /**
     * TAMPIL DATA (LIST)
     */
    public function index()
    {
        $kelompok = DB::table('t_kelompok')->get();

        return view('kelompok.kelompok', [
            'kelompok' => $kelompok
        ]);
    }

    public function create(Request $request)
    {
        $kelompok = [
            'id' => '',
            'jenis_kelompok' => '',
            'created_at' => '',
            'updated_at' => ''
        ];
        if ($request->input('id') != '') {
            $cek = DB::table('t_kelompok')->where('id', $request->input('id'))->first();
            $kelompok = [
                'id' => $cek->id,
                'jenis_kelompok' => $cek->jenis_kelompok,
                'created_at' => $cek->created_at,
                'updated_at' => $cek->updated_at
            ];
        }
        return view('kelompok.kelompokAdd', ['kelompok' => $kelompok]);
    }
    /**
     * FORM EDIT DATA
     */
    public function edit($id)
    {
        $kelompok = DB::table('t_kelompok')
            ->where('id', $id)
            ->first();

        if (!$kelompok) {
            return redirect()->route('kelompok.index')
                ->with('error', 'Data kelompok tidak ditemukan');
        }

        return view('kelompok.kelompokAdd', [
            'kelompok' => $kelompok
        ]);
    }

    /**
     * SIMPAN DATA (INSERT / UPDATE)
     */
    public function store(Request $request)
    {
        $data = [
            'jenis_kelompok' => $request->jenis_kelompok,
            'updated_at'  => now(),
        ];

        if ($request->filled('id')) {
            DB::table('t_kelompok')->where('id', $request->id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('t_kelompok')->insert($data);
        }

        return redirect()->route('kelompok.index');
    }

    /**
     * HAPUS DATA
     */
    public function destroy($id)
    {
        DB::table('t_kelompok')
            ->where('id', $id)
            ->delete();

        return redirect()->route('kelompok.index')
            ->with('success', 'Data berhasil dihapus');
    }
}