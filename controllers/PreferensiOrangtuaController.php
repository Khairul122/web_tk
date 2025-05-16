<?php
class PreferensiOrangtuaController
{
    private $model;
    private $kriteriaModel;

    public function __construct()
    {
        require_once BASE_PATH . '/koneksi.php';
        require_once MODEL_PATH . 'PreferensiOrangtuaModel.php';
        require_once MODEL_PATH . 'KriteriaModel.php';
        global $koneksi;
        $this->model = new PreferensiOrangtuaModel($koneksi);
        $this->kriteriaModel = new KriteriaModel($koneksi);
    }

    public function index()
    {
        $user_id = $_SESSION['user_id'] ?? 0;
        $sudah_isi = $this->model->userHasFilled($user_id);
        $kriteria = $this->kriteriaModel->getAll();
        include VIEW_PATH . 'preferensi/index.php';
    }

    public function simpanKuisioner()
    {
        if (empty($_SESSION['id'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit;
        }

        $user_id = $_SESSION['id'];
        $preferensi = $_POST['preferensi'];
        $this->model->insertMultiple($user_id, $preferensi);
        header("Location: index.php?controller=PreferensiOrangtua&action=index");
    }
}
