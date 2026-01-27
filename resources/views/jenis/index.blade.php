@extends('menu/navbar')

@section('content')

<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Tabel Kategori Pesan</h4>

                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('jenis.create') }}" class="btn btn-primary">
                        Tambah Pesan
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kategori Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($jenis as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->jenis_pesan }}</td>
                                <td>
                                     <div class="d-flex gap-2 flex-wrap">
                                <!-- Edit -->
                                <a href="{{ url('jenis/create?id=' . $item->id) }}"
                                    class="btn btn-warning btn-sm text-white">Edit</a>

                                <!-- Delete -->
                                <form action="{{ route('jenis.delete', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus jenis ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Data kosong</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection