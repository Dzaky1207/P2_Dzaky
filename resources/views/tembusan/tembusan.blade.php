@extends('menu/navbar')

@section('content')

<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Tabel tembusan</h4>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('tembusan.create') }}" class="btn btn-primary">
                        Create
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>nip</th>
                                <th>Nama Tembusan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tembusan as $index => $item)
                            <tr>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->name_tembusan }}</td>

                                <td>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <!-- Edit -->
                                        <a href="{{ url('tembusan/create?id=' . $item->id) }}"
                                            class="btn btn-warning btn-sm text-white">Edit</a>

                                        <!-- Delete -->
                                        <form action="{{ route('tembusan.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus tembusan ini?')">
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