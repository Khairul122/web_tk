<?php
class KriteriaController {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/koneksi.php';
        require_once MODEL_PATH . 'KriteriaModel.php';
        global $koneksi;
        $this->model = new KriteriaModel($koneksi);
    }

    public function index() {
        $data = $this->model->getAll();
        include VIEW_PATH . 'kriteria/index.php';
    }

    public function tambah() {
        include VIEW_PATH . 'kriteria/form.php';
    }

    public function simpan() {
        $data = $_POST;
        $this->model->insert($data);
        header("Location: index.php?controller=Kriteria&action=index");
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $kriteria = $this->model->getById($id);
        include VIEW_PATH . 'kriteria/form.php';
    }

    public function update() {
        $id = $_POST['id'];
        $data = $_POST;
        $this->model->update($id, $data);
        header("Location: index.php?controller=Kriteria&action=index");
    }

    public function hapus() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header("Location: index.php?controller=Kriteria&action=index");
    }
    
}
