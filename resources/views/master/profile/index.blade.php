@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Account Profile</h3>
                    <p class="text-subtitle text-muted">
                        A page where users can change profile information
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Profile
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="avatar avatar-2xl">
                                    <img src="{{ $user->photo_profile && Storage::exists('public/' . $user->photo_profile)
                                        ? asset('storage/' . $user->photo_profile)
                                        : asset('assets/images/faces/2.jpg') }}"
                                        alt="Avatar" id="profileAvatar" style="cursor: pointer;" />
                                </div>


                                <h3 class="mt-3">{{ $user->nama }}</h3>
                                <p class="text-small">{{ $user->position->posisi }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <input type="file" name="photo_profile" id="photoInput" style="display: none;"
                                    onchange="this.form.submit()">

                                <!-- Other form fields -->
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Your Name" value="{{ $user->nama }}" />
                                </div>
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        placeholder="Your Email" value="{{ $user->email }}" />
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        placeholder="Your Phone" value="{{ $user->hrDetail->hp }}" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif


        document.getElementById('profileAvatar').addEventListener('click', function() {
            document.getElementById('photoInput').click();
        });
    </script>
@endsection
