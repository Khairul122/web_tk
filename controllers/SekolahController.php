<?php
class SekolahController {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/koneksi.php';
        require_once MODEL_PATH . 'SekolahModel.php';
        global $koneksi;
        $this->model = new SekolahModel($koneksi);
    }

    public function index() {
        $data = $this->model->getAll();
        include VIEW_PATH . 'sekolah/index.php';
    }

    public function tambah() {
        include VIEW_PATH . 'sekolah/form.php';
    }

    public function simpan() {
        $data = $_POST;

        $fotoName = '';
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
            $fotoName = time() . '_' . basename($_FILES['foto']['name']);
            move_uploaded_file($_FILES['foto']['tmp_name'], UPLOAD_PATH . $fotoName);
        }
        $data['foto'] = $fotoName;

        $this->model->insert($data);
        header("Location: index.php?controller=Sekolah&action=index");
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $sekolah = $this->model->getById($id);
        include VIEW_PATH . 'sekolah/form.php';
    }

    public function update() {
        $id = $_POST['id'];
        $data = $_POST;

        $fotoName = $this->model->getById($id)['foto']; 
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
            $fotoName = time() . '_' . basename($_FILES['foto']['name']);
            move_uploaded_file($_FILES['foto']['tmp_name'], UPLOAD_PATH . $fotoName);
        }
        $data['foto'] = $fotoName;

        $this->model->update($id, $data);
        header("Location: index.php?controller=Sekolah&action=index");
    }

    public function hapus() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header("Location: index.php?controller=Sekolah&action=index");
    }
}
