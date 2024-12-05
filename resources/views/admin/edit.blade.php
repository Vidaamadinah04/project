@extends('layout.main')

@section('css')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<style>
    .modal-content {
        background-color: white;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h1>Kategori</h1>

    <!-- Modal -->
    <div class="modal fade show" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-modal="true" role="dialog" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="kodeKategori" class="form-label">Kode Kategori</label>
                            <input type="text" class="form-control" id="kodeKategori" name="kode_kategori" value="{{ $kategori->kode_kategori }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="namaKategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="namaKategori" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var editModal = new bootstrap.Modal(document.getElementById('editModal'), {});
        editModal.show();
    });
</script>
@endsection
