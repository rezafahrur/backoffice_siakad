@extends('layouts.app')

@section('title', 'LMS')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">LMS</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Learning Management System (LMS)</h5>

            {{-- button connect to lms poltekbatu --}}
            <div class="mb-3">
                <a href="https://lms.poltekbatu.ac.id/login/interpreterAuthenticatorDARe5.php?u={{ session('lms_credentials.username') }}&p={{ session('lms_credentials.password') }}"
                    target="_blank">
                    <button class="btn btn-primary btn-sm">Connect to LMS Poltekbatu</button>
                </a>
            </div>
        </div>
    </div>
@endsection
