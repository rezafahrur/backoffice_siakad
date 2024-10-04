@extends('layouts.app')

@section('title', 'Edit Rencana Pembelajaran')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('pembelajaran_plans.index') }}">Rencana Pembelajaran</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Rencana Pembelajaran</h4>
            <form action="{{ route('pembelajaran_plans.update', $pembelajaranPlan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="matakuliah_id">Matakuliah</label>
                            <select name="matakuliah_id" id="matakuliah_id" class="form-control" required>
                                <option value="">Select Matakuliah</option>
                                @foreach ($matakuliah as $mk)
                                    <option value="{{ $mk->id }}"
                                        {{ $pembelajaranPlan->matakuliah_id == $mk->id ? 'selected' : '' }}>
                                        {{ $mk->nama_matakuliah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="program_studi_name">Program Studi</label>
                            <input type="text" id="program_studi_name" class="form-control"
                                value="{{ $pembelajaranPlan->programStudi->nama_program_studi }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Hidden input for program_studi_id -->
                <input type="hidden" name="program_studi_id" id="program_studi_id"
                    value="{{ $pembelajaranPlan->program_studi_id }}">

                <div class="table-responsive mb-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="col-md-2">Pertemuan</th>
                                <th>Materi (Indo)</th>
                                <th>Materi (Eng)</th>
                            </tr>
                        </thead>
                        <tbody id="details-section">
                            @foreach ($pembelajaranPlan->details as $index => $detail)
                                <tr class="detail-item">
                                    <td>
                                        <input type="number" name="details[{{ $index }}][pertemuan]"
                                            class="form-control" value="{{ $detail->pertemuan }}" required>
                                    </td>
                                    <td>
                                        <textarea name="details[{{ $index }}][materi_indo]" class="form-control">{{ $detail->materi_indo }}</textarea>
                                    </td>
                                    <td>
                                        <textarea name="details[{{ $index }}][materi_eng]" class="form-control">{{ $detail->materi_eng }}</textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <button type="button" id="add-detail" class="btn btn-sm btn-success btn-icon">
                        <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                    </button>
                </div>

                <a href="{{ route('pembelajaran_plans.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let detailIndex = {{ $pembelajaranPlan->details->count() }};

        // Event listener for dynamically adding new detail rows
        document.getElementById('add-detail').addEventListener('click', function() {
            let pertemuanValue = detailIndex + 1; // Auto-increment pertemuan
            let detailItem = `
            <tr class="detail-item">
                <td>
                    <input type="number" name="details[${detailIndex}][pertemuan]" class="form-control" value="${pertemuanValue}" required>
                </td>
                <td>
                    <textarea name="details[${detailIndex}][materi_indo]" class="form-control"></textarea>
                </td>
                <td>
                    <textarea name="details[${detailIndex}][materi_eng]" class="form-control"></textarea>
                </td>
            </tr>
            `;
            document.getElementById('details-section').insertAdjacentHTML('beforeend', detailItem);
            detailIndex++;
        });

        // Fetch Program Studi based on selected Matakuliah
        document.getElementById('matakuliah_id').addEventListener('change', function() {
            let matakuliahId = this.value;
            if (matakuliahId) {
                fetch(`/api/get-program-studi/${matakuliahId}`)
                    .then(response => response.json())
                    .then(data => {
                        let programStudiInput = document.getElementById('program_studi_name');
                        let programStudiHiddenInput = document.getElementById('program_studi_id');
                        if (data.length > 0) {
                            programStudiInput.value = data[0].nama_program_studi;
                            programStudiHiddenInput.value = data[0].id;
                        } else {
                            programStudiInput.value = '';
                            programStudiHiddenInput.value = '';
                        }
                    })
                    .catch(error => console.error('Error fetching program studi:', error));
            } else {
                document.getElementById('program_studi_name').value = '';
                document.getElementById('program_studi_id').value = '';
            }
        });
    </script>
@endpush
