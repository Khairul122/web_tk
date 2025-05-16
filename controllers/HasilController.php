<?php
class HasilController
{
    private $model;
    private $vikorModel;

    public function __construct()
    {
        require_once BASE_PATH . '/koneksi.php';
        require_once MODEL_PATH . 'HasilModel.php';
        require_once MODEL_PATH . 'VikorModel.php';
        global $koneksi;
        $this->model = new HasilModel($koneksi);
        $this->vikorModel = new VikorModel($koneksi);
    }

    public function index()
    {
        if (!isset($_SESSION['id'])) {
            $_SESSION['error'] = "Anda harus login terlebih dahulu";
            header("Location: index.php?controller=Login&action=login");
            return;
        }

        $user_id = $_SESSION['id'];
        $kriteria = $this->model->getKriteria();
        $sekolah = $this->model->getSekolahTK();
        $preferensi = $this->model->getPreferensiUser($user_id);
        $bobot = $this->model->getBobotKriteria();
        $hasil = $this->model->getHasilRekomendasi($user_id);

        if (empty($hasil)) {
            $hasil = $this->model->hitungVikorAhp($user_id);
        }

        $nilaiSekolah = [];
        foreach ($hasil as $item) {
            $nilaiSekolah[$item['sekolah_id']] = $this->model->getNilaiKriteria($item['sekolah_id']);
        }

        include VIEW_PATH . 'hasil/index.php';
    }

    public function detail()
    {
        if (!isset($_SESSION['id'])) {
            $_SESSION['error'] = "Anda harus login terlebih dahulu";
            header("Location: index.php?controller=Login&action=login");
            return;
        }

        $sekolah_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($sekolah_id <= 0) {
            $_SESSION['error'] = "ID sekolah tidak valid";
            header("Location: index.php?controller=Hasil&action=index");
            return;
        }

        $detailSekolah = $this->model->getDetailSekolah($sekolah_id);
        $nilaiKriteria = $this->model->getNilaiKriteria($sekolah_id);

        if (!$detailSekolah) {
            $_SESSION['error'] = "Data sekolah tidak ditemukan";
            header("Location: index.php?controller=Hasil&action=index");
            return;
        }

        include VIEW_PATH . 'hasil/detail.php';
    }

    public function hitungUlang()
    {
        if (!isset($_SESSION['id'])) {
            $_SESSION['error'] = "Anda harus login terlebih dahulu";
            header("Location: index.php?controller=Login&action=login");
            return;
        }

        $user_id = $_SESSION['id'];
        $this->model->hitungVikorAhp($user_id);
        $_SESSION['success'] = "Hasil rekomendasi berhasil dihitung ulang";
        header("Location: index.php?controller=Hasil&action=index");
    }

    public function cetak()
    {
        if (!isset($_SESSION['id'])) {
            $_SESSION['error'] = "Anda harus login terlebih dahulu";
            header("Location: index.php?controller=Login&action=login");
            return;
        }

        $user_id = $_SESSION['id'];
        $hasil = $this->model->getHasilRekomendasi($user_id);
        $preferensi = $this->model->getPreferensiUser($user_id);
        $bobot = $this->model->getBobotKriteria();
        header('Content-Type: text/html');
        include VIEW_PATH . 'hasil/cetak.php';
    }
}
