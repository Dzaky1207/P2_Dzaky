@extends('menu.navbar')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Tambah tembusan</h4>

        <form action="{{ route('tembusan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $tembusan['id'] ?? '' }}">

            <div class="mb-3">
                <label for="tembusan">nip</label>
                <input type="text" name="nip" class="form-control"
                    value="{{ $tembusan['nip'] ?? '' }}" required>

            <div class="mb-3">
                <label for="tembusan">nama tembusan</label>
                <input type="text" name="name_tembusan" class="form-control"
                    value="{{ $tembusan['name_tembusan'] ?? '' }}" required>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ $tembusan['id'] ? 'Update' : 'Simpan' }}
            </button>
        </form>

    </div>
</div>
@endsection