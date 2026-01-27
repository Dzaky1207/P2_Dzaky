@extends('menu/navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="max-w-2xl mx-auto">

            @if(isset($sumber))
            <form action="{{ route('sumber.update', $sumber->id) }}" method="POST">
                @csrf
                @method('PUT')
            @else
            <form action="{{ route('sumber.store') }}" method="POST">
                @csrf
            @endif

                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4">{{ isset($sumber) ? 'Edit Sumber Surat' : 'Tambah Sumber Surat' }}</h5>

                        <div class="mb-3">
                            <label class="form-label">Nama Sumber</label>
                            <input type="text" name="sumber" class="form-control"
                                value="{{ $sumber->sumber ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Aktif" {{ (isset($sumber) && $sumber->status == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ (isset($sumber) && $sumber->status == 'Nonaktif') ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        <a href="{{ route('sumber.index') }}" class="btn btn-secondary mt-3 ms-2">Kembali</a>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
