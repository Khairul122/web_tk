<?php
class BobotKriteriaController {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/koneksi.php';
        require_once MODEL_PATH . 'BobotKriteriaModel.php';
        global $koneksi;
        $this->model = new BobotKriteriaModel($koneksi);
    }

    public function index() {
        $data = $this->model->getAll();
        include VIEW_PATH . 'bobot_kriteria/index.php';
    }

    public function tambah() {
        $kriteria = $this->model->getKriteriaOptions();
        include VIEW_PATH . 'bobot_kriteria/form.php';
    }

    public function simpan() {
        $data = [
            'kriteria_id' => $_POST['kriteria_id'],
            'bobot' => (float) $_POST['bobot'],
            'jenis' => $_POST['jenis']
        ];
        $this->model->insert($data);
        header("Location: index.php?controller=BobotKriteria&action=index");
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $bobot = $this->model->getById($id);
        $kriteria = $this->model->getKriteriaOptions();
        include VIEW_PATH . 'bobot_kriteria/form.php';
    }

    public function update() {
        $id = $_POST['id'];
        $data = [
            'kriteria_id' => $_POST['kriteria_id'],
            'bobot' => (float) $_POST['bobot'],
            'jenis' => $_POST['jenis']
        ];
        $this->model->update($id, $data);
        header("Location: index.php?controller=BobotKriteria&action=index");
    }

    public function hapus() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header("Location: index.php?controller=BobotKriteria&action=index");
    }
}
