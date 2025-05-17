<?php
class RegistrasiController
{
    private $model;

    public function __construct()
    {
        require_once BASE_PATH . '/koneksi.php';
        require_once MODEL_PATH . 'UserModel.php';
        global $koneksi;
        $this->model = new UserModel($koneksi);
    }

    public function form()
    {
        include VIEW_PATH . 'registrasi/index.php';
    }

    public function simpan()
    {
        $data = [
            'username' => $_POST['username'],
            'password' => $_POST['password'], 
            'nama_lengkap' => $_POST['nama_lengkap'],
            'email' => $_POST['email'],
            'no_telp' => $_POST['no_telp'],
            'alamat' => $_POST['alamat']
        ];

        if ($this->model->isUsernameTaken($data['username'])) {
            echo "<script>alert('Username sudah digunakan');window.location='index.php?controller=Register&action=form';</script>";
            return;
        }

        if ($this->model->isEmailTaken($data['email'])) {
            echo "<script>alert('Email sudah digunakan');window.location='index.php?controller=Register&action=form';</script>";
            return;
        }

        if ($this->model->insert($data)) {
            echo "<script>alert('Registrasi berhasil. Silakan login.');window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data.');window.location='index.php?controller=Register&action=form';</script>";
        }
    }
}
