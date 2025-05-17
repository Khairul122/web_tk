<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Registrasi Orang Tua</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Registrasi Orang Tua</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?controller=Registrasi&action=simpan">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No. Telepon</label>
                                <input type="text" name="no_telp" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Daftar</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>Sudah punya akun? <a href="index.php">Login di sini</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
