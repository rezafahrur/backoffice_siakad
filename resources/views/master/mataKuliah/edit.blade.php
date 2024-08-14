@extends('layouts.custom')

 @section('title', 'Edit Mata Kuliah')

 @section('content')
     {{-- start logo and back --}}
     <nav class="navbar navbar-light">
         <div class="container d-block">
             <a href="{{ route('mataKuliah.index') }}"><i class="bi bi-chevron-left"></i></a>
             <a class="navbar-brand ms-4" href="{{ route('mataKuliah.index') }}">
                 <img src="{{ asset('assets/img/logo-kos.svg') }}" alt="Logo">
             </a>
         </div>
     </nav>
     {{-- end logo and back --}}

     <div class="card-header">
         <h4 class="card-title">Form Edit Mata Kuliah</h4>
     </div>
     <div class="card-body">
         <form action="{{ route('mataKuliah.update', $matkul->id) }}" method="POST" enctype="multipart/form-data">
             @csrf
             @method('PUT')

             <div class="mb-3">
                 <label for="program_studi_id" class="form-label">Program Studi</label>
                 <select class="form-select @error('program_studi_id') is-invalid @enderror" name="program_studi_id" id="program_studi_id">
                     <option value="" disabled>Pilih Program Studi</option>
                     @foreach ($programStudis as $programStudi)
                         <option value="{{ $programStudi->id }}" {{ old('program_studi_id', $matkul->program_studi_id) == $programStudi->id ? 'selected' : '' }}>
                             {{ $programStudi->nama_program_studi }}
                         </option>
                     @endforeach
                 </select>
                 @error('program_studi_id')
                     <div class="invalid-feedback">
                         {{ $message }}
                     </div>
                 @enderror
             </div>

             <div class="mb-3">
                 <label for="kode_matakuliah" class="form-label">Kode Mata Kuliah</label>
                 <input type="text" name="kode_matakuliah" class="form-control @error('kode_matakuliah') is-invalid @enderror"
                     id="kode_matakuliah" value="{{ old('kode_matakuliah', $matkul->kode_matakuliah) }}">
                 @error('kode_matakuliah')
                     <div class="invalid-feedback">
                         {{ $message }}
                     </div>
                 @enderror
             </div>

             <div class="mb-3">
                 <label for="nama_matakuliah" class="form-label">Nama Mata Kuliah</label>
                 <input type="text" name="nama_matakuliah" class="form-control @error('nama_matakuliah') is-invalid @enderror"
                     id="nama_matakuliah" value="{{ old('nama_matakuliah', $matkul->nama_matakuliah) }}">
                 @error('nama_matakuliah')
                     <div class="invalid-feedback">
                         {{ $message }}
                     </div>
                 @enderror
             </div>

             <div class="mb-3">
                 <label for="sks" class="form-label">SKS</label>
                 <input type="number" name="sks" class="form-control @error('sks') is-invalid @enderror"
                     id="sks" value="{{ old('sks', $matkul->sks) }}">
                 @error('sks')
                     <div class="invalid-feedback">
                         {{ $message }}
                     </div>
                 @enderror
             </div>

             <button type="submit" class="btn btn-primary">Submit</button>
         </form>
     </div>
 @endsection