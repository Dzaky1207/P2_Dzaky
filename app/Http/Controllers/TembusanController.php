<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TembusanController extends Controller
{
    public function tembusan()
    {
        $data = "Adi";
        $tembusan = DB::table('t_tembusan')->get();

        return view('tembusan.tembusan', ['data' => $data, 'tembusan' => $tembusan]);
    }

    public function show($id)
    {
        $cek = DB::table('t_tembusan')->where('id', $id)->first();

        if (!$cek) {
            return redirect()->route('tembusan.tembusan')->with('error', 'Data tembusan tidak ditemukan.');
        }

        $tembusan = [
            'id' => $cek->id,
            'nip' => $cek->nip,
            'name_tembusan' => $cek->name_tembusan,
            'created_at' => $cek->created_at,
            'updated_at' => $cek->updated_at
        ];

        return view('formView', ['tembusan' => $tembusan]);
    }

    public function create(Request $request)
    {
        $tembusan = [
            'id' => '',
            'nip' => '',
            'name_tembusan' => '',
            'created_at' => '',
            'updated_at' => ''
        ];
        if ($request->input('id') != '') {
            $cek = DB::table('t_tembusan')->where('id', $request->input('id'))->first();
            $tembusan = [
                'id' => $cek->id,
                'nip' => $cek->nip,
                'name_tembusan' => $cek->name_tembusan,
                'created_at' => $cek->created_at,
                'updated_at' => $cek->updated_at
            ];
        }
        return view('tembusan.formtembusan', ['tembusan' => $tembusan]);
    }

    public function destroy($id)
    {
        DB::table('t_tembusan')->where('id', $id)->delete();
        return redirect()->route('tembusan.tembusan');
    }

    public function store(Request $request)
    {
        $data = [
            'nip' => $request->nip,
            'name_tembusan' => $request->name_tembusan,
            'updated_at'  => now(),
        ];

        if ($request->filled('id')) {
            DB::table('t_tembusan')->where('id', $request->id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('t_tembusan')->insert($data);
        }

        return redirect()->route('tembusan.tembusan');
    }
}
