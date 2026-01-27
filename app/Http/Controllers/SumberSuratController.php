<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SumberSuratController extends Controller
{
    public function index()
    {
        $sumber = DB::table('t_sumber')->get();

        return view('sumber.index', compact('sumber'));
    }

    public function create()
    {
        return view('sumber.create'); // tidak perlu kirim data
    }

    public function store(Request $request)
    {
        $request->validate([
            'sumber' => 'required',
            'status' => 'required',
        ]);

        DB::table('t_sumber')->insert([
            'sumber'     => $request->sumber,
            'status'     => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('sumber.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $sumber = DB::table('t_sumber')->where('id', $id)->first();
        return view('sumber.create', compact('sumber'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'sumber' => 'required',
            'status' => 'required',
        ]);

        DB::table('t_sumber')->where('id', $id)->update([
            'sumber'     => $request->sumber,
            'status'     => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->route('sumber.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        DB::table('t_sumber')->where('id', $id)->delete();

        return redirect()->route('sumber.index')->with('success', 'Data berhasil dihapus');
    }
}
