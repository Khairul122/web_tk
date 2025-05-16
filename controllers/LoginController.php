<?php
class LoginController
{
    public function login()
    {
        include VIEW_PATH . 'login.php';
    }

    public function prosesLogin()
    {
        require_once BASE_PATH . '/koneksi.php';
        require_once MODEL_PATH . 'LoginModel.php';

        global $koneksi;

        $model = new LoginModel($koneksi);

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $model->getUserByUsername($username);

        if ($user && $user['password'] === $password) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['alamat'] = $user['alamat'];
            $_SESSION['no_telp'] = $user['no_telp'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                echo "<script>alert('Login berhasil! Selamat datang, " . $user['nama_lengkap'] . "'); window.location.href='index.php?controller=HomeAdmin&action=homeAdmin';</script>";
            } elseif ($user['role'] === 'orangtua') {
                echo "<script>alert('Login berhasil! Selamat datang, " . $user['nama_lengkap'] . "'); window.location.href='index.php?controller=HomeOrangTua&action=homeOrangTua';</script>";
            } else {
                echo "<script>alert('Role tidak dikenali!'); window.location.href='index.php?controller=Login&action=login';</script>";
            }
        } else {
            echo "<script>alert('Username atau password salah!'); window.location.href='index.php?controller=Login&action=login';</script>";
        }
    }


    public function logout()
    {
        session_destroy();
        header("Location: index.php?controller=Login&action=login");
    }
}
