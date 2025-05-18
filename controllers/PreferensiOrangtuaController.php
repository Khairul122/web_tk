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
        $user_id = $_SESSION['id'] ?? 0;
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
        
        $result = $this->model->insertMultiple($user_id, $preferensi);
        
        if ($result) {
            $_SESSION['success'] = "Preferensi berhasil disimpan. Anda dapat mengisi kembali kuesioner ini jika diperlukan.";
        } else {
            $_SESSION['error'] = "Terjadi kesalahan saat menyimpan preferensi.";
        }
        
        header("Location: index.php?controller=PreferensiOrangtua&action=index");
    }
    
    public function riwayatKuisioner()
    {
        if (empty($_SESSION['id'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit;
        }
        
        $user_id = $_SESSION['id'];
        $riwayat_preferensi = $this->model->getPreferensiByUserId($user_id);
        
        include VIEW_PATH . 'preferensi/riwayat.php';
    }
    
    public function hapusKuisioner()
    {
        if (empty($_SESSION['id'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit;
        }
        
        $user_id = $_SESSION['id'];
        $created_at = $_GET['created_at'] ?? '';
        
        if (empty($created_at)) {
            $_SESSION['error'] = "Parameter tanggal tidak valid.";
            header("Location: index.php?controller=PreferensiOrangtua&action=riwayatKuisioner");
            exit;
        }
        
        $result = $this->model->deletePreferensiByKriteriasAndDate($user_id, $created_at);
        
        if ($result) {
            $_SESSION['success'] = "Data preferensi berhasil dihapus.";
        } else {
            $_SESSION['error'] = "Terjadi kesalahan saat menghapus data.";
        }
        
        header("Location: index.php?controller=PreferensiOrangtua&action=riwayatKuisioner");
    }
}