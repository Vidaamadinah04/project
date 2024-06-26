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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Kategori</h4>
                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#ModalTambah">
                    Tambah Kategori
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-dark">
                            <tr>
                                <th>NO</th>
                                <th>Kode Kategori</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategori as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->kode_kategori }}</td>
                                    <td>{{ $item->nama_kategori }}</td>
                                    <td>
                                        {{-- <button onclick="showCategory({{ $item->id }})" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Show
                                        </button> --}}
                                        <button onclick="editCategory({{ $item->id }})" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="ModalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Form Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode_kategori" class="form-label">Kode Kategori</label>
                        <input type="text" class="form-control" placeholder="Masukan Kode Kategori" id="kode_kategori" name="kode_kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" placeholder="Masukan Nama Kategori" id="nama_kategori" name="nama_kategori" required>
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
<!-- Akhir Modal Tambah -->

<!-- Modal Edit -->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditLabel">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalEditContent">
                <!-- Konten akan dimuat dari AJAX -->
            </div>
        </div>
    </div>
</div>


<!-- Modal Detail Kategori -->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalContent">Konten modal akan dimuat di sini.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Detail Kategori -->
@endsection

@section('js')
<script>
  // Fungsi untuk menampilkan detail kategori dalam modal
  function showCategory(id) {
    $.ajax({
        url: '/kategori/' + id,
        type: 'GET',
        dataType: 'html',
        success: function(response) {
            $('#modalContent').html(response); // Memuat konten modal dari respons AJAX
            $('#ModalDetail').modal('show'); // Menampilkan modal detail
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

  // Fungsi untuk menampilkan form edit kategori
  function editCategory(id) {
    $.ajax({
        url: '/kategori/' + id + '/edit',
        type: 'GET',
        dataType: 'html',
        success: function(response) {
            $('#modalEditContent').html(response); 
            $('#ModalEdit').modal('show'); 
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

  // Fungsi untuk menghapus kategori
  function deleteCategory(id) {
    if (confirm('Are you sure?')) {
        $.ajax({
            url: '/kategori/' + id,
            type: 'DELETE',
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                alert('Kategori berhasil dihapus');
                location.reload();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
}
</script>
@endsection
