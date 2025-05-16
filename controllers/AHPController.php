<?php
class AHPController
{
    private $model;

    public function __construct()
    {
        require_once BASE_PATH . '/koneksi.php';
        require_once MODEL_PATH . 'AHPModel.php';
        global $koneksi;
        $this->model = new AHPModel($koneksi);
    }

    public function index()
    {
        $kriteria = $this->model->getAllKriteria();
        $matriks = $this->model->getMatriksPerbandingan();
        $bobotKriteria = $this->model->getBobotKriteria();
        
        $isBohotAHPExist = count($bobotKriteria) > 0;
        $isMatriksComplete = count($matriks) == (count($kriteria) * count($kriteria));
        
        $hasilPerhitungan = [];
        if ($isMatriksComplete) {
            $hasilPerhitungan = $this->model->getHasilPerhitungan();
        }
        
        $hasilAHPDB = $this->model->getHasilAHPDariDatabase();
        
        include VIEW_PATH . 'ahp/index.php';
    }

    public function matriksPerbandingan()
    {
        $kriteria = $this->model->getAllKriteria();
        $matriks = $this->model->getMatriksPerbandingan();
        $bobotKriteria = $this->model->getBobotKriteria();
        $isBohotAHPExist = count($bobotKriteria) > 0;
        
        $matriksValues = [];
        foreach ($matriks as $item) {
            $matriksValues[$item['kriteria_baris']][$item['kriteria_kolom']] = $item['nilai'];
        }
        
        include VIEW_PATH . 'ahp/matriks_perbandingan.php';
    }

    public function simpanMatriks()
    {
        $kriteria_baris = $_POST['kriteria_baris'];
        $kriteria_kolom = $_POST['kriteria_kolom'];
        $nilai = $_POST['nilai'];
        
        foreach ($kriteria_baris as $i => $baris) {
            $kolom = $kriteria_kolom[$i];
            $nilaiPerbandingan = (float)$nilai[$i];
            
            $this->model->simpanPerbandingan($baris, $kolom, $nilaiPerbandingan);
            
            if ($baris != $kolom) {
                $this->model->simpanPerbandingan($kolom, $baris, 1/$nilaiPerbandingan);
            }
        }
        
        $_SESSION['success'] = "Matriks perbandingan berhasil disimpan.";
        header("Location: index.php?controller=AHP&action=matriksPerbandingan");
    }

    public function hitungBobot()
    {
        $kriteria = $this->model->getAllKriteria();
        $matriks = $this->model->getMatriksPerbandingan();
        
        if (count($matriks) < (count($kriteria) * count($kriteria))) {
            $_SESSION['error'] = "Matriks perbandingan belum lengkap. Silakan lengkapi terlebih dahulu.";
            header("Location: index.php?controller=AHP&action=matriksPerbandingan");
            return;
        }
        
        $hasil = $this->model->hitungAHP();
        
        if ($hasil['cr'] > 0.1) {
            $_SESSION['error'] = "Matriks perbandingan tidak konsisten (CR = " . number_format($hasil['cr'], 3) . "). Silakan perbaiki perbandingan.";
            header("Location: index.php?controller=AHP&action=matriksPerbandingan");
            return;
        }
        
        foreach ($hasil['bobot'] as $kriteria_id => $bobot) {
            $this->model->simpanBobotKriteria($kriteria_id, $bobot);
        }
        
        $_SESSION['success'] = "Bobot kriteria berhasil dihitung dengan CR = " . number_format($hasil['cr'], 3) . " dan disimpan ke database.";
        header("Location: index.php?controller=AHP&action=index");
    }

    public function resetMatriks()
    {
        $this->model->hapusMatriksPerbandingan();
        $_SESSION['success'] = "Matriks perbandingan berhasil direset.";
        header("Location: index.php?controller=AHP&action=matriksPerbandingan");
    }

    public function hasilPerhitungan()
    {
        $kriteria = $this->model->getAllKriteria();
        $hasil = $this->model->getHasilPerhitungan();
        
        if (!$hasil) {
            $bobotKriteria = $this->model->getBobotKriteria();
            if (count($bobotKriteria) > 0) {
                $hasil = $this->model->rekonstruksiHasilPerhitungan();
            }
        }
        
        $hasilAHPDB = $this->model->getHasilAHPDariDatabase();
        
        include VIEW_PATH . 'ahp/hasil_perhitungan.php';
    }
    
    public function rekonstruksiMatriks()
    {
        if ($this->model->rekonstruksiMatriksPerbandingan()) {
            $_SESSION['success'] = "Matriks perbandingan berhasil direkonstruksi dari bobot yang ada.";
        } else {
            $_SESSION['error'] = "Tidak dapat merekonstruksi matriks. Pastikan bobot AHP sudah ada.";
        }
        header("Location: index.php?controller=AHP&action=matriksPerbandingan");
    }
    
    public function gunaBobotExisting()
    {
        $hasil = $this->model->rekonstruksiHasilPerhitungan();
        
        if ($hasil) {
            $_SESSION['success'] = "Berhasil menggunakan bobot AHP yang sudah ada di database dan menyimpan hasil perhitungan.";
        } else {
            $_SESSION['error'] = "Tidak dapat membuat hasil perhitungan dari bobot yang ada.";
        }
        
        header("Location: index.php?controller=AHP&action=index");
    }
    
    public function matriksOtomatis()
    {
        $this->model->hapusMatriksPerbandingan();
        if ($this->model->rekonstruksiMatriksPerbandingan()) {
            $_SESSION['success'] = "Matriks perbandingan telah diisi otomatis dari bobot yang ada.";
        } else {
            $_SESSION['error'] = "Tidak dapat mengisi matriks secara otomatis. Pastikan bobot AHP sudah ada.";
        }
        header("Location: index.php?controller=AHP&action=matriksPerbandingan");
    }
    
    public function matriksManual()
    {
        $this->model->hapusMatriksPerbandingan();
        $_SESSION['success'] = "Matriks perbandingan telah direset. Anda dapat mengisi matriks secara manual.";
        header("Location: index.php?controller=AHP&action=matriksPerbandingan");
    }
}