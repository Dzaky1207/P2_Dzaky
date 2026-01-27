@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">
                <h4>Tambah tujuan Pesan</h4>

                <form action="{{ route('tujuan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $tujuan['id'] ?? '' }}">

                    <div class="mb-3">
                        <label for="tujuan">Kategori Pesan</label>
                        <input type="text" name="tujuan" class="form-control"
                            value="{{ $tujuan['tujuan'] ?? '' }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ $tujuan['id'] ? 'Update' : 'Simpan' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection