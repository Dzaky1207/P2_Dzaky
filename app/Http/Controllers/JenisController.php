<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisController extends Controller
{
    public function index()
    {
        $data = "Adi";
        $jenis = DB::table('t_pesan')->get();

        return view('jenis.index', ['data' => $data, 'jenis' => $jenis]);
    }

    public function show($id)
    {
        $cek = DB::table('t_pesan')->where('id', $id)->first();

        if (!$cek) {
            return redirect()->route('jenis.index')->with('error', 'Data jenis tidak ditemukan.');
        }

        $jenis = [
            'id' => $cek->id,
            'jenis_pesan' => $cek->jenis_pesan,
            'created_at' => $cek->created_at,
            'updated_at' => $cek->updated_at
        ];

        return view('formView', ['jenis.index' => $jenis]);
    }

    public function create(Request $request)
    {
        $jenis = [
            'id' => '',
            'jenis_pesan' => '',
            'created_at' => '',
            'updated_at' => ''
        ];
        if ($request->input('id') != '') {
            $cek = DB::table('t_pesan')->where('id', $request->input('id'))->first();
            $jenis = [
                'id' => $cek->id,
                'jenis_pesan' => $cek->jenis_pesan,
                'created_at' => $cek->created_at,
                'updated_at' => $cek->updated_at
            ];
        }
        return view('jenis.formAdd', ['jenis' => $jenis]);
    }

    public function destroy($id)
    {
        DB::table('t_pesan')->where('id', $id)->delete();
        return redirect()->route('jenis.index');
    }



    public function store(Request $request)
    {
        $data = [
            'jenis_pesan' => $request->jenis_pesan,
            'updated_at'  => now(),
        ];

        if ($request->filled('id')) {
            DB::table('t_pesan')->where('id', $request->id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('t_pesan')->insert($data);
        }

        return redirect()->route('jenis.index');
    }
}