@extends('layouts.auth')

@section('title', 'Login')

@push('styles')
<style>
html, body, .container{
  height: 100%;
}

.login-form {
  width: 350px;
  padding: 2rem 1rem 1rem;
}

form {
  padding: 1rem;
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="wrapper d-flex align-items-center justify-content-center h-100">
        <div class="card login-form">
            <div class="card-body">
                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo Politeknik Batu" class="img-fluid">
                <h5 class="card-title text-center">Back Office</h5>
                <a href="https://wa.me/6281333662726?text=Masuk" target="_blank" class="btn btn-primary w-100 mt-5">
                    <i class="bi bi-arrow-return-right"></i> &nbsp;
                    MASUK
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        @if (session('error'))
        Swal.fire({
            title: 'Hmmmm',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
@endif
    </script>
@endpush
