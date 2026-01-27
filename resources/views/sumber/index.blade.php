@extends('menu/navbar')

@section('content')
<div class="pc-container">
  <div class="pc-content">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Sumber Surat</h4>

        <div class="d-flex justify-content-end mb-3">
          <a href="{{ route('sumber.create') }}" class="btn btn-primary">Tambah Sumber</a>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Sumber</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sumber as $index => $s)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->sumber }}</td>
                <td>
                  <span class="badge {{ $s->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                    {{ $s->status }}
                  </span>
                </td>
                <td>
                  <div class="d-flex gap-2">

                    {{-- View --}}
                    <button class="btn btn-primary btn-sm"
                      data-bs-toggle="modal"
                      data-bs-target="#modalView{{ $s->id }}">
                      View
                    </button>

                    {{-- Edit --}}
                    <a href="{{ route('sumber.edit', $s->id) }}"
                      class="btn btn-warning btn-sm">
                      Edit
                    </a>

                    {{-- Hapus --}}
                    <form method="POST" action="{{ route('sumber.destroy', $s->id) }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin hapus data ini?')">
                        Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


@foreach ($sumber as $s)
<div class="modal fade" id="modalView{{ $s->id }}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Sumber Surat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <tr>
            <th width="40%">Nama Sumber</th>
            <td>: {{ $s->sumber }}</td>
          </tr>
          <tr>
            <th>Status</th>
            <td>: {{ $s->status }}</td>
          </tr>
          <tr>
            <th>Dibuat</th>
            <td>: {{ $s->created_at }}</td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection