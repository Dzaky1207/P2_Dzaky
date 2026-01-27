<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TujuanController extends Controller
{
    public function tujuan()
    {
        $data = "Daftar Tujuan Surat";
        $tujuan = DB::table('t_tujuan')->get();

        return view('tujuan.index', ['data' => $data, 'tujuan' => $tujuan]);
    }

    public function show($id)
    {
        $cek = DB::table('t_tujuan')->where('id', $id)->first();

        if (!$cek) {
            return redirect()->route('tujuan.index')->with('error', 'Data tujuan tidak ditemukan.');
        }

        $tujuan = [
            'id' => $cek->id,
            'tujuan' => $cek->tujuan,
            'created_at' => $cek->created_at,
            'updated_at' => $cek->updated_at
        ];

        return view('formView', ['tujuan' => $tujuan]);
    }

    public function create(Request $request)
    {
        $tujuan = [
            'id' => '',
            'tujuan' => '',
            'created_at' => '',
            'updated_at' => ''
        ];
        if ($request->input('id') != '') {
            $cek = DB::table('t_tujuan')->where('id', $request->input('id'))->first();
            $tujuan = [
                'id' => $cek->id,
                'tujuan' => $cek->tujuan,
                'created_at' => $cek->created_at,
                'updated_at' => $cek->updated_at
            ];
        }
        return view('tujuan.formtujuan', ['tujuan' => $tujuan]);
    }

    public function destroy($id)
    {
        DB::table('t_tujuan')->where('id', $id)->delete();
        return redirect()->route('tujuan.index');
    }

    public function store(Request $request)
    {
        $data = [
            'tujuan' => $request->tujuan,
            'updated_at'  => now(),
        ];

        if ($request->filled('id')) {
            DB::table('t_tujuan')->where('id', $request->id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('t_tujuan')->insert($data);
        }

        return redirect()->route('tujuan.index');
    }
}