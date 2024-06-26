<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE edge">
    <meta name="description" content="Sash – Bootstrap 5  Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- FAVICON -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
   
    <!-- SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.2.7/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.2.7/dist/sweetalert2.min.css">
</head>

<body>
    <section class="vh-100" style="background-color: #1b1647;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-flex align-items-center justify-content-center">
                                <!-- Tambahkan logo di bawah ini -->
                                <img src="{{ asset('admin/assets/img/sufi.jpeg') }}" alt="Login Image" width="200" height="200">
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form action="{{ route('login-proses') }}" method="POST">
                                        @csrf

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login Menggunakan Akun Anda</h5>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example17">Username*</label>
                                            <input type="email" name="email" class="form-control form-control-lg input @error('username') is-invalid @enderror" name="username" id="form2Example17">
                                            @error('email')
                                            <small>{{$message}}</small>
                                            @enderror
                                        </div>

                                        <div class="form-outline mb-4">                                           
                                            <label class="form-label" for="form2Example27">Password*</label>
                                            <input type="password" name="password" id="form2Example27" class="form-control form-control-lg" name="password" />
                                            
                                            
                                            @error('password')
                                            <small>{{$message}}</small>
                                            @enderror
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button type="submit" class="btn btn-dark btn-lg btn-warning">Login</button>
                                        </div>

                                        <div class="form-text mt-3">Belum mempunyai akun? 
                                            <a href="{{ route('register') }}">Buat Akun</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Periksa parameter dalam URL yang menunjukkan login berhasil.
        // Anda dapat menyesuaikan logika ini berdasarkan cara kerja sistem login Anda.
        const urlParams = new URLSearchParams(window.location.search);
        const loginSuccess = urlParams.get('loginSuccess');
    
        if (loginSuccess === 'true') {
            // Tampilkan pesan berhasil menggunakan SweetAlert.
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil',
                text: 'Anda telah berhasil login!',
            });
        }
    </script>
    <script>
        document.getElementById('togglePassword').addEventListener('change', function() {
            var passwordInput = document.getElementById('password');
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
    
</body>

</html>
