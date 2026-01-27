@extends('menu.navbar')

@section('content')

<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">Tabel Surat Masuk</h4>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Kode Surat</th>
                                <th>Perihal</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Sifat</th>
                                <th>Dari</th>
                                <th>Kepada</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($surat as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                {{-- FOTO --}}
                                <td>
                                    @if($item->photo)
                                    <img src="{{ asset('storage/' . $item->photo) }}"
                                        style="width:60px;height:60px;object-fit:cover;border-radius:4px;">
                                    @else
                                    <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>

                                <td>{{ $item->kode_surat }}</td>
                                <td>{{ $item->perihal }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->jenis_pesan ?? '-' }}</td>
                                <td>{{ ucfirst($item->jenis_sifat) ?? '-' }}</td>
                                <td>{{ $item->dari }}</td>
                                <td>{{ $item->kepada }}</td>

                                {{-- Lampiran --}}
                                <td>
                                    @if($item->lampiran)
                                    @foreach(json_decode($item->lampiran) as $lamp)
                                    <a href="{{ asset('storage/'.$lamp) }}" target="_blank">Lampiran</a><br>
                                    @endforeach
                                    @else
                                    -
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="{{ route('surat.editMasuk', $item->id) }}" class="btn btn-outline-warning btn-sm">Edit</a>

                                        <form action="{{ route('surat.destroyMasuk', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </div>

                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">
                                    Belum ada data surat masuk
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

@endsection