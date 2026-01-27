@extends('menu/navbar')

@section('content')
<div class="pc-container">
  <div class="pc-content">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Data Staff</h4>

        <div class="d-flex justify-content-end mb-3">
          <a href="{{ route('staff.create') }}" class="btn btn-primary">
            Tambah Staff
          </a>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="order-listing" class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Photo</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>

                  @forelse ($staff as $s)
                  <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                      @if($s->avatar)
                      <img src="{{ asset('storage/'.$s->avatar) }}"
                        style="width:60px;height:60px;object-fit:cover;border-radius:4px;">
                      @else
                      <span class="text-muted">Tidak ada foto</span>
                      @endif
                    </td>



                    <td>{{ $s->name }}</td>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->nama_jabatan }}</td>

                    <td>
                      <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm"
                          data-bs-toggle="modal"
                          data-bs-target="#modalStaff{{ $s->id }}">
                          View
                        </button>

                        <a href="{{ route('staff.edit', $s->id) }}"
                          class="btn btn-warning btn-sm">
                          Edit
                        </a>

                        <form method="POST" action="{{ route('staff.destroy', $s->id) }}">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus staff ini?')">
                            Hapus
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>

                  <!-- MODAL DETAIL STAFF -->
                  <div class="modal fade" id="modalStaff{{ $s->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">

                        <div class="modal-header">
                          <h5 class="modal-title">Detail Staff</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body text-center">

                          {{-- FOTO --}}
                          @if($s->avatar)
                          <img src="{{ asset('storage/'.$s->avatar) }}"
                            class="rounded mb-3"
                            style="width:120px;height:120px;object-fit:cover;">
                          @else
                          <img src="{{ asset('assets/images/no-image.png') }}"
                            class="rounded mb-3"
                            style="width:120px;height:120px;object-fit:cover;">
                          @endif

                          <p><strong>Nama:</strong> {{ $s->name }}</p>
                          <p><strong>Email:</strong> {{ $s->email }}</p>

                          {{-- JABATAN --}}
                          <p><strong>Jabatan:</strong> {{ $s->nama_jabatan }}</p>

                          <p><strong>Dibuat:</strong> {{ $s->created_at }}</p>
                        </div>

                        <div class="modal-footer">
                          <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>

                      </div>
                    </div>
                  </div>

                  @empty
                  <tr>
                    <td colspan="7" class="text-center text-muted">
                      Belum ada data staff
                    </td>
                  </tr>
                  @endforelse

                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection