@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">
                <h4>Tambah Jenis Pesan</h4>

                <form action="{{ route('jenis.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $jenis['id'] ?? '' }}">

                    <div class="mb-3">
                        <label for="jenis_pesan">Kategori Pesan</label>
                        <input type="text" name="jenis_pesan" class="form-control"
                            value="{{ $jenis['jenis_pesan'] ?? '' }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ $jenis['id'] ? 'Update' : 'Simpan' }}
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection