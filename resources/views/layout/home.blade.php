@extends('menu/navbar')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="pc-container">
        <div class="pc-content">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="row justify-content-center g-4">

                        <!-- ================= FORM ================= -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Data Surat Lamaran</h5>
                                </div>
                                <div class="card-body">

                                    <div class="mb-2">
                                        <input type="text" class="form-control" id="kota" placeholder="Kota & Tanggal">
                                    </div>
                                    <div class="mb-2">
                                        <textarea class="form-control" id="subjek" rows="3"
                                            placeholder="Subjek Surat"></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <textarea class="form-control" id="paragraf_1" rows="3"
                                            placeholder="Paragraf 1"></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <textarea class="form-control" id="paragraf_2" rows="3"
                                            placeholder="Paragraf 2"></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <textarea class="form-control" id="paragraf_3" rows="3"
                                            placeholder="Paragraf 3"></textarea>
                                    </div>

                                    <div class="d-flex gap-2 mt-4">
                                        <button type="button" class="btn btn-primary w-100" id="btnSave">
                                            Tambahkan ke Database
                                        </button>

                                        <button type="button" class="btn btn-success w-100" id="btnPrint">
                                            Cetak ke PDF
                                        </button>

                                        <button type="button" class="btn btn-warning w-100" id="btnClear">
                                            Clear Semua
                                        </button>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <!-- ================= PREVIEW ================= -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-5">Riview Data Lamaran</h5>

                                    <p id="p_kota" class="text-end">[Kota & Tanggal]</p><br>
                                    <p id="p_subjek">[Subjek Surat]</p><br>
                                    <p id="p_p1">[Paragraf 1]</p><br>
                                    <p id="p_p2">[Paragraf 2]</p><br>
                                    <p id="p_p3">[Paragraf 2]</p><br>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- end page title -->


                </div>
                <!-- container-fluid -->
            </div>
        </div>
    </div>
    <!-- End Page-content -->
</div>

<script>
    function live(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        input.addEventListener('input', () => {
            preview.innerText = input.value || preview.dataset.default;
        });
    }

    // set default text
    document.querySelectorAll('[id^="p_"]').forEach(el => {
        el.dataset.default = el.innerText;
    });

    live('kota', 'p_kota');
    live('subjek', 'p_subjek');
    live('paragraf_1', 'p_p1');
    live('paragraf_2', 'p_p2');
    live('paragraf_3', 'p_p3');
</script>

<script>
    document.getElementById('btnSave').addEventListener('click', () => {
        alert('Data berhasil ditambahkan ke Database (simulasi)');
    });

    //document.getElementById('btnPrint').addEventListener('click', () => {
    // window.print();
    //});

    document.getElementById('btnClear').addEventListener('click', () => {

        document.querySelectorAll('input, textarea').forEach(el => {
            el.value = '';
        });

        document.querySelectorAll('[id^="p_"]').forEach(el => {
            el.innerText = el.dataset.default;
        });
    });
</script>

@endsection