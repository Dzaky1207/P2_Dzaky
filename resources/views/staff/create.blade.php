@extends('menu/navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="max-w-2xl mx-auto">

            @if(isset($staff))
            <form action="{{ route('staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                    @csrf


                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">{{ isset($staff) ? 'Edit Staff' : 'Tambah Staff' }}</h5>

                            <div class="mb-3">
                                <label class="form-label">Nama Staff</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $staff->name ?? '' }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ $staff->email ?? '' }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <select name="id_jabatan" class="form-control" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach($jabatans as $j)
                                    <option value="{{ $j->id }}"
                                        {{ (isset($staff) && $staff->id_jabatan == $j->id) ? 'selected' : '' }}>
                                        {{ $j->nama_jabatan }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="aktif" {{ ($staff->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ ($staff->status ?? '') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto</label>
                                <input type="file" name="avatar" class="form-control">

                                @if(isset($staff) && $staff->avatar)
                                <img src="{{ asset('storage/'.$staff->avatar) }}"
                                    class="mt-2 rounded"
                                    style="width:80px;height:80px;object-fit:cover">
                                @endif
                            </div>

                            @if(!isset($staff))
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            @endif

                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                            <a href="{{ route('staff.index') }}" class="btn btn-secondary mt-3 ms-2">Kembali</a>

                        </div>
                    </div>
                </form>

        </div>
    </div>
</div>
@endsection