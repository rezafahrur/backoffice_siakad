@extends('layouts.app')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('pembelajaran_plans.index') }}">Rencana Pembelajaran</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Create
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Create Pembelajaran Plan</h4>
            <form action="{{ route('pembelajaran_plans.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="matakuliah_id">Matakuliah</label>
                            <select name="matakuliah_id" id="matakuliah_id" class="form-control" required>
                                <option value="">Select Matakuliah</option>
                                @foreach ($matakuliah as $mk)
                                    <option value="{{ $mk->id }}">{{ $mk->nama_matakuliah }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="program_studi_name">Program Studi</label>
                            <input type="text" id="program_studi_name" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <!-- Hidden input for program_studi_id -->
                <input type="hidden" name="program_studi_id" id="program_studi_id">

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
                            <tr class="detail-item">
                                <td>
                                    <input type="number" name="details[0][pertemuan]" id="pertemuan_0" class="form-control"
                                        value="1" required>
                                </td>
                                <td>
                                    <textarea type="text" name="details[0][materi_indo]" class="form-control" required> </textarea>
                                </td>
                                <td>
                                    <textarea type="text" name="details[0][materi_eng]" class="form-control" required> </textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <button type="button" id="add-detail" class="btn btn-sm btn-success btn-icon">
                        <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                    </button>
                </div>

                <a href="{{ route('pembelajaran_plans.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let detailIndex = 1;

        // Event listener for dynamically adding new detail rows
        document.getElementById('add-detail').addEventListener('click', function() {
            let pertemuanValue = detailIndex + 1; // Auto-increment pertemuan
            let detailItem = `
            <tr class="detail-item">
                <td>
                    <input type="number" name="details[${detailIndex}][pertemuan]" class="form-control" value="${pertemuanValue}" required>
                </td>
                <td>
                    <textarea type="text" name="details[${detailIndex}][materi_indo]" class="form-control" required> </textarea>
                </td>
                <td>
                    <textarea type="text" name="details[${detailIndex}][materi_eng]" class="form-control" required> </textarea>
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
                            programStudiHiddenInput.value = data[0]
                                .id; // Set hidden input value to program_studi_id
                        } else {
                            programStudiInput.value = '';
                            programStudiHiddenInput.value = ''; // Reset hidden input if no data
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
