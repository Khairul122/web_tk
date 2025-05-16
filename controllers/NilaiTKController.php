<?php
class NilaiTkController
{
    private $model;

    public function __construct()
    {
        require_once BASE_PATH . '/koneksi.php';
        require_once MODEL_PATH . 'NilaiTkModel.php';
        global $koneksi;
        $this->model = new NilaiTkModel($koneksi);
    }

    public function index()
    {
        $data = $this->model->getAll();
        include VIEW_PATH . 'nilai_tk/index.php';
    }

    public function tambah()
    {
        $sekolah = $this->model->getSekolahOptions();
        $kriteria = $this->model->getKriteriaOptions();
        $subkriteria = $this->model->getSubkriteriaOptions();
        include VIEW_PATH . 'nilai_tk/form.php';
    }

    public function simpan()
    {
        $sekolah_id = $_POST['sekolah_id'];
        $kriteria_ids = $_POST['kriteria_id'];
        $nilai_list = $_POST['nilai'];
        $subkriteria_ids = $_POST['subkriteria_id'];

        foreach ($kriteria_ids as $index => $kriteria_id) {
            $this->model->insert([
                'sekolah_id' => $sekolah_id,
                'kriteria_id' => $kriteria_id,
                'nilai' => (float)$nilai_list[$index],
                'subkriteria_id' => !empty($subkriteria_ids[$index]) ? $subkriteria_ids[$index] : null
            ]);
        }

        header("Location: index.php?controller=NilaiTk&action=index");
    }


    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $nilai = $this->model->getById($id);
        $sekolah = $this->model->getSekolahOptions();
        $kriteria = $this->model->getKriteriaOptions();
        $subkriteria = $this->model->getSubkriteriaOptions();
        include VIEW_PATH . 'nilai_tk/form.php';
    }

    public function update()
    {
        $id = $_POST['id'];
        $data = [
            'sekolah_id' => $_POST['sekolah_id'],
            'kriteria_id' => $_POST['kriteria_id'],
            'nilai' => (float) $_POST['nilai'],
            'subkriteria_id' => $_POST['subkriteria_id'] ?? null
        ];
        $this->model->update($id, $data);
        header("Location: index.php?controller=NilaiTk&action=index");
    }

    public function hapus()
    {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header("Location: index.php?controller=NilaiTk&action=index");
    }
}
