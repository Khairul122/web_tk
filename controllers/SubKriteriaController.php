<?php
class SubkriteriaController {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/koneksi.php';
        require_once MODEL_PATH . 'SubkriteriaModel.php';
        global $koneksi;
        $this->model = new SubkriteriaModel($koneksi);
    }

    public function index() {
        $data = $this->model->getAll();
        include VIEW_PATH . 'subkriteria/index.php';
    }

    public function tambah() {
        $kriteria = $this->model->getKriteriaOptions();
        include VIEW_PATH . 'subkriteria/form.php';
    }

    public function simpan() {
        $data = [
            'kriteria_id' => $_POST['kriteria_id'],
            'nama' => $_POST['nama'],
            'nilai' => (int)$_POST['nilai'],
            'keterangan' => $_POST['keterangan']
        ];
        $this->model->insert($data);
        header("Location: index.php?controller=Subkriteria&action=index");
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $subkriteria = $this->model->getById($id);
        $kriteria = $this->model->getKriteriaOptions();
        include VIEW_PATH . 'subkriteria/form.php';
    }

    public function update() {
        $id = $_POST['id'];
        $data = [
            'kriteria_id' => $_POST['kriteria_id'],
            'nama' => $_POST['nama'],
            'nilai' => (int)$_POST['nilai'],
            'keterangan' => $_POST['keterangan']
        ];
        $this->model->update($id, $data);
        header("Location: index.php?controller=Subkriteria&action=index");
    }

    public function hapus() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header("Location: index.php?controller=Subkriteria&action=index");
    }
}
