@extends('menu/navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="mb-0">User Profile</h5>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0)">User</a></li>
                            <li class="breadcrumb-item" aria-current="page">User Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-lg-4">
                <div class="card user-card user-card-1">
                    <div class="card-body pb-0">
                        <div class="d-flex user-about-block align-items-center mt-0 mb-3">
                            <div class="flex-shrink-0">
                                <div class="position-relative d-inline-block">
                                    <img class="img-radius img-fluid wid-80" src="{{ Auth::user()->avatar }}" alt="User image" />
                                    <div class="certificated-badge">
                                        <i class="ti ti-rosette-discount-check-filled text-primary bg-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ Auth::user()->name ?? '' }}</h6>
                                <p class="mb-0 text-muted">{{ Auth::user()->role ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="ph ph-envelope-simple m-r-10"></i>Email</span>
                            <a href="/cdn-cgi/l/email-protection#ceaaaba3a18ebdafa3bea2ab" class="float-end text-body"><span class="__cf_email__" data-cfemail="e286878f8da291838f928e87cc818d8f">{{ Auth::user()->email ?? '' }}</span></a>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="ph ph-phone-call m-r-10"></i>Phone</span>
                            <a href="#" class="float-end text-body">{{ Auth::user()->phone ?? '' }}</a>
                        </li>
                    </ul>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col">
                                <h6 class="mb-1">37</h6>
                                <p class="mb-0">Mails</p>
                            </div>
                            <div class="col border-start">
                                <h6 class="mb-1">2749</h6>
                                <p class="mb-0">Followers</p>
                            </div>
                            <div class="col border-start">
                                <h6 class="mb-1">678</h6>
                                <p class="mb-0">Following</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="tab-content" id="user-set-tabContent">
                    <div class="tab-pane fade show active" id="user-set-profile" role="tabpanel" aria-labelledby="user-set-profile-tab">
                        <div class="card-body">

                            <h5 class="mb-4">Edit Profile</h5>
                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif

                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')


                                {{-- FOTO --}}
                                <div class="mb-3 text-center">
                                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('default.png') }}"
                                        class="rounded-circle mb-2"
                                        width="120" height="120" style="object-fit:cover">
                                    <input type="file" name="avatar" class="form-control mt-2">
                                </div>

                                {{-- NAMA --}}
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $user->name) }}">
                                </div>

                                {{-- EMAIL --}}
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email) }}">
                                </div>

                                {{-- PASSWORD --}}
                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" name="password" class="form-control">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                </div>

                                {{-- KONFIRMASI --}}
                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>

                                <div class="text-end">
                                    <button class="btn btn-primary">Simpan Perubahan</button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
@endsection