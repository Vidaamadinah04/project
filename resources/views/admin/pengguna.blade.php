@extends('layout.main')

@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="pagetitle col-lg-12">
    <h4>Kelola Akun Pengguna</h4>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="actions mb-2">
                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#tambahPenggunaModal">Tambah Pengguna</button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button type="button" onclick="showEditModal({{ $user->id }})" class="btn btn-warning btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">
                                    <i class="fas fa-trash"></i> Hapus
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

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="tambahPenggunaModal" tabindex="-1" role="dialog" aria-labelledby="tambahPenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPenggunaModalLabel">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambah pengguna -->
                <form id="tambahForm" action="{{ route('pengguna.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="submitTambahForm()">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pengguna -->
<div class="modal fade" id="editPenggunaModal" tabindex="-1" role="dialog" aria-labelledby="editPenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPenggunaModalLabel">Edit Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk mengedit pengguna -->
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editUserId" name="userId">
                    <div class="form-group">
                        <label for="editUsername">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="username" placeholder="Masukkan Username">
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" placeholder="Masukkan Email">
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="submitEditForm()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
<script>
   function submitTambahForm() {
    var formData = $('#tambahForm').serialize();
    $.ajax({
        url: '{{ route('pengguna.store') }}',
        type: 'POST',
        data: formData,
        success: function(response) {
            $('#tambahPenggunaModal').modal('hide');
            Swal.fire('Sukses', 'Pengguna berhasil ditambahkan!', 'success').then(() => {
                location.reload();
            });
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            Swal.fire('Error', 'Gagal menambahkan pengguna.', 'error');
        }
    });
}

function showEditModal(userId) {
    var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

    $.ajax({
        url: '/akun/' + userId + '/edit',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        success: function(response) {
            $('#editUserId').val(response.data.id);
            $('#editUsername').val(response.data.username);
            $('#editEmail').val(response.data.email);
            $('#editForm').attr('action', '/akun/' + response.data.id); // Update action form
            $('#editPenggunaModal').modal('show');
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            Swal.fire('Error', 'Gagal memuat data pengguna.', 'error');
        }
    });
}

function submitEditForm() {
    var userId = $('#editUserId').val();
    var formData = $('#editForm').serialize();
    $.ajax({
        url: '/akun/' + userId,
        type: 'PUT',
        data: formData,
        success: function(response) {
            $('#editPenggunaModal').modal('hide');
            Swal.fire('Sukses', 'Data pengguna berhasil diperbarui!', 'success').then(() => {
                location.reload();
            });
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            Swal.fire('Error', 'Gagal menyimpan perubahan pengguna.', 'error');
        }
    });
}
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: '{{ session('success') }}',
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session('error') }}',
    });
</script>
@endif
@endsection
