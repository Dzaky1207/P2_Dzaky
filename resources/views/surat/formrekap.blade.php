@extends('menu.navbar')

@section('content')

<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">

                <h4 class="mb-4">Rekap Surat Masuk & Keluar</h4>

                {{-- FILTER --}}
                <form method="GET" action="{{ route('surat.rekap') }}" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option>
                            @php
                            $bulanList = [
                            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                            7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
                            ];
                            @endphp
                            @foreach($bulanList as $num => $nama)
                            <option value="{{ $num }}" {{ request('bulan')==$num?'selected':'' }}>
                                {{ $nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-control">
                            <option value="">-- Pilih Tahun --</option>
                            @for($t = date('Y'); $t >= 2020; $t--)
                            <option value="{{ $t }}" {{ request('tahun')==$t?'selected':'' }}>
                                {{ $t }}
                            </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Jenis Surat</label>
                        <select name="jenis" class="form-control">
                            <option value="">-- Pilih Jenis Surat --</option>
                            <option value="Masuk" {{ request('jenis')=='Masuk'?'selected':'' }}>Surat Masuk</option>
                            <option value="Keluar" {{ request('jenis')=='Keluar'?'selected':'' }}>Surat Keluar</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>

                {{-- TABEL --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>Kode Surat</th>
                                <th>Perihal</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Sifat</th>
                                <th>Dari</th>
                                <th>Kepada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekap as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge {{ $item->jenis=='Masuk'?'bg-success':'bg-primary' }}">
                                        {{ $item->jenis }}
                                    </span>
                                </td>
                                <td>{{ $item->kode_surat }}</td>
                                <td>{{ $item->perihal }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->jenis_pesan ?? '-' }}</td>
                                <td>{{ $item->jenis_sifat ?? '-' }}</td>
                                <td>{{ $item->dari }}</td>
                                <td>{{ $item->kepada }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    Silakan pilih jenis surat terlebih dahulu
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