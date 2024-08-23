@extends('layouts.app')

@section('title', 'Program Studi')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Berita</h3>
                    <p class="text-subtitle text-muted">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, accusamus.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Table</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Table head options start -->
        <section class="section">
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Table Data Berita
                            </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <p>
                                    "Welcome to our web page showcasing the user data of our boarding house, where comfort
                                    and convenience come together in one place."
                                </p>
                                <a href="{{ route('berita.create') }}" class="btn icon icon-left btn-primary"><i
                                        data-feather="user-plus"></i>
                                    Add Data Berita</a>
                            </div>

                            <!-- table head dark -->
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>Judul Berita</th>
                                            <th>Kategori</th>
                                            <th>Photo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($berita as $index => $paketmatkul)
                                        <tr>
                                            <td class="text-bold-500">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="text-bold-500">
                                                {{ $paketmatkul->judul_berita }}
                                            </td>
                                            <td class="text-bold-500">
                                                {{ $paketmatkul->kategoriBerita->kategori_berita }}
                                            </td>
                                            {{-- semester --}}
                                            <td class="text-bold-500">
                                                <img src="{{ asset('storage/'.$paketmatkul->path_photo) }}" alt="photo" style="width: 100px">
                                            </td>
                                            
                                            <td>
                                                <a href="{{ url('/berita/show/'.$paketmatkul->id) }}" class="btn icon btn-primary" title="Detail"><i
                                                        class="bi bi-eye"></i></a>
                                                <a href="{{ url('/berita/edit/'.$paketmatkul->id) }}" class="btn icon btn-warning" title="Edit"><i
                                                        class="bi bi-pencil-square"></i></a>
                                                        <form action="{{ url('/berita/delete/'.$paketmatkul->id) }}" method="post" class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button onclick="return confirm('Konfirmasi hapus data ?')"
                                                                class="btn icon btn-danger" title="Delete"><i
                                                                    class="bi bi-trash"></i></button>
                                                        </form>

                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No Data Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="m-3 pagination pagination-primary">
                                {{-- {{ $users->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Table head options end -->
    </div>
    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection



