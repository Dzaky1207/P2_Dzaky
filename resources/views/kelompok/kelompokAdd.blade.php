@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">
                <h4>Tambah Jenis Pesan</h4>

                <form action="{{ route('kelompok.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $kelompok['id'] ?? '' }}">

                    <div class="mb-3">
                        <label for="jenis_kelompok">Kategori Pesan</label>
                        <input type="text" name="jenis_kelompok" class="form-control"
                            value="{{ $kelompok['jenis_kelompok'] ?? '' }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ $kelompok['id'] ? 'Update' : 'Simpan' }}
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection