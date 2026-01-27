@extends('menu.navbar')

@section('content')

<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">

                <h4 class="mb-4">Cari Surat</h4>

                {{-- FILTER --}}
                <form method="GET" action="{{ route('surat.cari') }}">
                    <div class="row mb-3">

                        <div class="col-md-3">
                            <label class="form-label">Jenis Surat</label>
                            <select name="jenis" class="form-control" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Masuk" {{ request('jenis')=='Masuk'?'selected':'' }}>Surat Masuk</option>
                                <option value="Keluar" {{ request('jenis')=='Keluar'?'selected':'' }}>Surat Keluar</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-control">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $k)
                                <option value="{{ $k->jenis_pesan }}"
                                    {{ request('kategori') == $k->jenis_pesan ? 'selected' : '' }}>
                                    {{ $k->jenis_pesan }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Bulan</label>
                            <select name="bulan" class="form-control">
                                <option value="">-- Pilih --</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                    @endfor
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Tahun</label>
                            <select name="tahun" class="form-control">
                                <option value="">-- Pilih --</option>
                                @for($y = date('Y'); $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <button type="submit" name="cari" value="1" class="btn btn-primary">
                        🔍 Cari
                    </button>
                </form>

                {{-- TABEL --}}
                @if(!is_null($data))

                @if(count($data) > 0)
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Perihal</th>
                            <th>Kode</th>
                            <th>Dari</th>
                            <th>Kepada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i => $d)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $d->tanggal }}</td>
                            <td>{{ $d->perihal }}</td>
                            <td>{{ $d->kode_surat }}</td>
                            <td>{{ $d->dari }}</td>
                            <td>{{ $d->kepada }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="mt-3 text-muted">Data tidak ditemukan.</p>
                @endif

                @endif


            </div>
        </div>
    </div>
</div>

@endsection