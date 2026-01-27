<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    // ======================
    // INDEX
    // ======================
    public function index()
    {
        $staff = DB::table('users')
            ->join('t_jabatan', 'users.id_jabatan', '=', 't_jabatan.id')
            ->where('users.role', 'staff')
            ->select('users.*', 't_jabatan.nama_jabatan')
            ->get();

        return view('staff.index', compact('staff'));
    }

    // ======================
    // CREATE FORM
    // ======================
    public function create()
    {
        $jabatans = DB::table('t_jabatan')->get();
        return view('staff.create', compact('jabatans'));
    }

    // ======================
    // EDIT FORM
    // ======================
    public function edit($id)
    {
        $staff = DB::table('users')->where('id', $id)->first();
        $jabatans = DB::table('t_jabatan')->get();

        return view('staff.create', compact('staff', 'jabatans'));
    }

    // ======================
    // STORE
    // ======================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'id_jabatan' => 'required',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $avatarPath = null;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('staff', 'public');
        }

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
            'id_jabatan' => $request->id_jabatan,
            'avatar' => $avatarPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('staff.index');
    }

    // ======================
    // UPDATE
    // ======================
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,$id",
            'id_jabatan' => 'required',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'id_jabatan' => $request->id_jabatan,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('staff', 'public');
        }

        DB::table('users')->where('id', $id)->update($data);

        return redirect()->route('staff.index');
    }

    // ======================
    // DELETE
    // ======================
    public function destroy($id)
    {
        $staff = DB::table('users')->where('id', $id)->first();

        if ($staff->avatar) {
            $avatarPath = json_decode($staff->avatar, true);
            foreach ($avatarPath as $path) {
                if (file_exists(public_path('storage/' . $path))) {
                    unlink(public_path('storage/' . $path));
                }
            }
        }

        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('staff.index');
    }
}
