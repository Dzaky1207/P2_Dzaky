@extends('menu.navbar')

@section('content')
@php
$isEdit = $isEdit ?? false;
$jenisSurat = old('jenis_surat', $surat->jenis_surat ?? '');
$formAction = '';

if($isEdit){
$formAction = $jenisSurat == 1
? route('surat.updateMasuk', $surat->id)
: route('surat.updateKeluar', $surat->id);
} else {
$formAction = route('surat.store'); // SATU STORE
}

@endphp

<form method="POST" action="{{ $formAction }}" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif


    <div class="pc-container">
        <div class="pc-content">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">{{ $isEdit ? 'Edit Surat' : 'Form Surat' }}</h5>

                    <div class="row">
                        <div class="col-md-9">
                            {{-- Departemen --}}
                            <div class="mb-3">
                                <label class="form-label">Departemen</label>
                                <input type="text" class="form-control"
                                    value="{{ auth()->user()->name ?? '' }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Surat</label>
                                <select name="jenis_surat" id="jenis_surat" class="form-control" required>
                                    <option value="">-- Pilih Jenis Surat --</option>
                                    <option value="1" {{ $jenisSurat == 1 ? 'selected' : '' }}>Surat Masuk</option>
                                    <option value="0" {{ $jenisSurat == 0 ? 'selected' : '' }}>Surat Keluar</option>
                                </select>
                            </div>

                            {{-- Nomor Surat --}}
                            <div class="mb-3">
                                <label class="form-label">Nomor Surat</label>
                                <input type="text" name="kode_surat" id="nomor_surat"
                                    class="form-control"
                                    value="{{ old('kode_surat', $surat->kode_surat ?? '') }}"
                                    placeholder="Otomatis untuk surat keluar"
                                    {{ $isEdit ? 'readonly' : '' }}>
                            </div>

                            {{-- Perihal --}}
                            <div class="mb-3">
                                <label class="form-label">Perihal</label>
                                <input type="text" name="perihal" class="form-control"
                                    value="{{ old('perihal', $surat->perihal ?? '') }}">
                            </div>

                            {{-- Tanggal --}}
                            <div class="mb-3">
                                <label class="form-label">Tanggal Surat</label>
                                <input type="date" name="tanggal" class="form-control"
                                    value="{{ old('tanggal', $surat->tanggal ?? '') }}">
                            </div>

                            {{-- Kategori --}}
                            <div class="mb-3">
                                <label class="form-label">Kategori Surat</label>
                                <select name="jenis_pesan" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategori as $item)
                                    <option value="{{ $item->jenis_pesan }}"
                                        {{ old('jenis_pesan', $surat->jenis_pesan ?? '') == $item->jenis_pesan ? 'selected' : '' }}>
                                        {{ $item->jenis_pesan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Sifat --}}
                            <div class="mb-3">
                                <label class="form-label">Sifat Surat</label>
                                <select name="jenis_sifat" class="form-control" required>
                                    <option value="">-- Pilih Sifat --</option>
                                    @foreach ($sifat as $item)
                                    <option value="{{ $item->jenis_sifat }}"
                                        {{ old('jenis_sifat', $surat->jenis_sifat ?? '') == $item->jenis_sifat ? 'selected' : '' }}>
                                        {{ $item->jenis_sifat }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Uraian --}}
                            <div class="mb-3">
                                <label class="form-label">Uraian Singkat</label>
                                <textarea name="uraian" class="form-control" rows="3">{{ old('uraian', $surat->uraian ?? '') }}</textarea>
                            </div>

                            {{-- Keterangan --}}
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $surat->keterangan ?? '') }}</textarea>
                            </div>

                            {{-- Lampiran --}}
                            <div class="mb-3">
                                <label class="form-label">Lampiran</label>
                                <input type="file" name="lampiran[]" class="form-control" multiple>
                            </div>

                            {{-- Dari & Kepada bisa tetap sama --}}
                            {{-- ================= DARI ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Dari</label>
                                <div class="card">
                                    <div class="card-body p-2">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#dari-kelompok" type="button">Kelompok</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dari-staff" type="button">Staff</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dari-sendiri" type="button">Sendiri</button>
                                            </li>
                                        </ul>

                                        <div class="tab-content mt-3">
                                            <div class="tab-pane fade show active" id="dari-kelompok">
                                                <select name="dari_kelompok" class="form-control">
                                                    <option value="">-- Pilih Kelompok --</option>
                                                    @foreach ($kelompok as $item)
                                                    <option value="{{ $item->jenis_kelompok }}"
                                                        {{ old('dari_kelompok', $surat->dari ?? '') == $item->jenis_kelompok ? 'selected' : '' }}>
                                                        {{ $item->jenis_kelompok }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="tab-pane fade" id="dari-staff">
                                                <select name="dari_staff" class="form-control">
                                                    <option value="">-- Pilih Staff --</option>
                                                    @foreach ($staff as $item)
                                                    <option value="{{ $item->name }}"
                                                        {{ old('dari_staff', $surat->dari ?? '') == $item->name ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="tab-pane fade" id="dari-sendiri">
                                                <input type="text" class="form-control" value="{{ auth()->user()->name ?? '' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ================= KEPADA ================= --}}
                            <div class="mb-3">
                                <label class="form-label">Kepada</label>
                                <div class="card">
                                    <div class="card-body p-2">
                                        <ul class="nav nav-tabs" id="kepada-tabs">
                                            <li class="nav-item">
                                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#kepada-kelompok" type="button">Kelompok</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#kepada-staff" type="button">Perorangan</button>
                                            </li>
                                            <li class="nav-item" id="tab-tembusan-nav">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#kepada-tembusan" type="button">Tembusan</button>
                                            </li>
                                        </ul>

                                        <div class="tab-content mt-3">
                                            <div class="tab-pane fade show active" id="kepada-kelompok">
                                                <select name="kepada_kelompok" class="form-control">
                                                    <option value="">-- Pilih Kelompok --</option>
                                                    @foreach ($kelompok as $item)
                                                    <option value="{{ $item->jenis_kelompok }}"
                                                        {{ old('kepada_kelompok', $surat->kepada ?? '') == $item->jenis_kelompok ? 'selected' : '' }}>
                                                        {{ $item->jenis_kelompok }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="tab-pane fade" id="kepada-staff">
                                                <select name="kepada_staff" class="form-control">
                                                    <option value="">-- Pilih Staff --</option>
                                                    @foreach ($staff as $item)
                                                    <option value="{{ $item->name }}"
                                                        {{ old('kepada_staff', $surat->kepada ?? '') == $item->name ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="tab-pane fade" id="kepada-tembusan">
                                                <select name="kepada_tembusan" class="form-control">
                                                    <option value="">-- Pilih Tembusan --</option>
                                                    @foreach ($tembusan as $item)
                                                    <option value="{{ $item->name_tembusan }}">
                                                        {{ $item->name_tembusan }} - {{ $item->nip }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h6 class="mb-3 text-center">Foto</h6>
                                    <div class="border rounded d-flex align-items-center justify-content-center mb-3"
                                        style="height:300px;background:#f8f9fa;" id="photo-preview">
                                        <span class="text-muted text-center">Preview Foto Berkas</span>
                                    </div>
                                    <input type="file" name="photo" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
                    <a href="#" class="btn btn-secondary mt-4 ms-2">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisSurat = document.getElementById('jenis_surat');
        const nomorSurat = document.getElementById('nomor_surat');

        function generateKodeSurat() {
            const huruf = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const angka = '0123456789';
            let kodeHuruf = '',
                kodeAngka = '';
            for (let i = 0; i < 2; i++) kodeHuruf += huruf.charAt(Math.floor(Math.random() * huruf.length));
            for (let i = 0; i < 4; i++) kodeAngka += angka.charAt(Math.floor(Math.random() * angka.length));
            return kodeHuruf + kodeAngka;
        }

        function handleJenisSurat() {
            if (jenisSurat.value === '0') { // Surat Keluar
                nomorSurat.readOnly = true; // readonly
                if (!nomorSurat.value) {
                    nomorSurat.value = generateKodeSurat(); // generate otomatis
                }
            } else { // Surat Masuk
                nomorSurat.readOnly = false; // boleh diketik manual
            }
        }

        jenisSurat.addEventListener('change', handleJenisSurat);

        // Jalankan saat load
        handleJenisSurat();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisSurat = document.getElementById('jenis_surat');
        const tabTembusanNav = document.getElementById('tab-tembusan-nav');
        const tabTembusanContent = document.getElementById('kepada-tembusan');

        function handleJenisSurat() {
            if (jenisSurat.value === '0') { // Surat Keluar
                if (tabTembusanNav) tabTembusanNav.style.display = 'none';
                if (tabTembusanContent) tabTembusanContent.classList.remove('show', 'active');
            } else { // Surat Masuk
                if (tabTembusanNav) tabTembusanNav.style.display = 'block';
            }
        }

        jenisSurat.addEventListener('change', handleJenisSurat);
        handleJenisSurat();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisSurat = document.getElementById('jenis_surat');
        const nomorSurat = document.getElementById('nomor_surat');

        function generateKodeSurat() {
            const huruf = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const angka = '0123456789';
            let kode = '';
            for (let i = 0; i < 2; i++) kode += huruf[Math.floor(Math.random() * 26)];
            for (let i = 0; i < 4; i++) kode += angka[Math.floor(Math.random() * 10)];
            return kode;
        }

        function handleJenisSurat() {
            if (jenisSurat.value === '0') { // Surat Keluar
                nomorSurat.readOnly = true;
                if (!nomorSurat.value) {
                    nomorSurat.value = generateKodeSurat();
                }
            } else { // Surat Masuk
                nomorSurat.readOnly = false;
                nomorSurat.value = '';
            }
        }

        jenisSurat.addEventListener('change', handleJenisSurat);
        handleJenisSurat();
    });
</script>



@endsection