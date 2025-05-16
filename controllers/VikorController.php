<?php
class VikorController
{
    private $model;

    public function __construct()
    {
        require_once BASE_PATH . '/koneksi.php';
        require_once MODEL_PATH . 'VikorModel.php';
        global $koneksi;
        $this->model = new VikorModel($koneksi);
    }
    
    public function index()
    {
        $kriteria = $this->model->getAllKriteria();
        $bobotKriteria = $this->model->getBobotKriteria('vikor');
        $parameterVikor = $this->model->getParameterVikor();
        
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        $hasilRekomendasi = $this->model->getHasilRekomendasi($user_id);
        
        include VIEW_PATH . 'vikor/index.php';
    }
    
    public function parameterVikor()
    {
        $parameterVikor = $this->model->getParameterVikor();
        
        include VIEW_PATH . 'vikor/parameter_vikor.php';
    }
    
    public function simpanParameter()
    {
        $nilai_v = isset($_POST['nilai_v']) ? (float)$_POST['nilai_v'] : 0.5;
        $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
        
        if ($nilai_v < 0 || $nilai_v > 1) {
            $_SESSION['error'] = "Nilai V harus berada dalam rentang 0 sampai 1.";
            header("Location: index.php?controller=Vikor&action=parameterVikor");
            return;
        }
        
        $this->model->simpanParameterVikor($nilai_v, $keterangan);
        
        $_SESSION['success'] = "Parameter VIKOR berhasil disimpan.";
        header("Location: index.php?controller=Vikor&action=parameterVikor");
    }
    
    public function preferensiOrangTua()
    {
        $kriteria = $this->model->getAllKriteria();
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        $preferensiOrangTua = $this->model->getPreferensiOrangTua($user_id);
        
        include VIEW_PATH . 'vikor/preferensi_orangtua.php';
    }
    
    public function simpanPreferensi()
    {
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        
        if ($user_id == 0) {
            $_SESSION['error'] = "Anda harus login terlebih dahulu.";
            header("Location: index.php?controller=Login&action=login");
            return;
        }
        
        $kriteria_ids = $_POST['kriteria_id'];
        $nilai_preferensi = $_POST['nilai_preferensi'];
        
        $db = $this->model->getDb();
        $db->begin_transaction();
        
        try {
            foreach ($kriteria_ids as $i => $kriteria_id) {
                $nilai = (float)$nilai_preferensi[$i];
                
                $stmt = $db->prepare("SELECT id FROM preferensi_orangtua WHERE user_id = ? AND kriteria_id = ?");
                $stmt->bind_param("ii", $user_id, $kriteria_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $stmt = $db->prepare("UPDATE preferensi_orangtua SET nilai_preferensi = ?, updated_at = NOW() WHERE id = ?");
                    $stmt->bind_param("di", $nilai, $row['id']);
                } else {
                    $stmt = $db->prepare("INSERT INTO preferensi_orangtua (user_id, kriteria_id, nilai_preferensi, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
                    $stmt->bind_param("iid", $user_id, $kriteria_id, $nilai);
                }
                
                $stmt->execute();
            }
            
            $db->commit();
            $_SESSION['success'] = "Preferensi orang tua berhasil disimpan.";
        } catch (Exception $e) {
            $db->rollback();
            $_SESSION['error'] = "Terjadi kesalahan saat menyimpan preferensi: " . $e->getMessage();
        }
        
        header("Location: index.php?controller=Vikor&action=preferensiOrangTua");
    }
    
    public function hitungRekomendasi()
    {
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        
        if ($user_id == 0) {
            $_SESSION['error'] = "Anda harus login terlebih dahulu.";
            header("Location: index.php?controller=Login&action=login");
            return;
        }
        
        $hasil = $this->model->hitungVIKOR($user_id);
        
        if ($hasil) {
            $_SESSION['success'] = "Perhitungan rekomendasi berhasil dilakukan.";
        } else {
            $_SESSION['error'] = "Gagal melakukan perhitungan rekomendasi.";
        }
        
        header("Location: index.php?controller=Vikor&action=hasilRekomendasi");
    }
    
    public function hasilRekomendasi()
    {
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        
        if ($user_id == 0) {
            $_SESSION['error'] = "Anda harus login terlebih dahulu.";
            header("Location: index.php?controller=Login&action=login");
            return;
        }
        
        $hasilRekomendasi = $this->model->getHasilRekomendasi($user_id);
        $hasilVIKOR = $this->model->getHasilVIKOR();
        
        include VIEW_PATH . 'vikor/hasil_rekomendasi.php';
    }
    
    public function detailRekomendasi()
    {
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        
        if ($user_id == 0) {
            $_SESSION['error'] = "Anda harus login terlebih dahulu.";
            header("Location: index.php?controller=Login&action=login");
            return;
        }
        
        $sekolah_id = isset($_GET['sekolah_id']) ? (int)$_GET['sekolah_id'] : 0;
        
        if ($sekolah_id == 0) {
            $_SESSION['error'] = "ID sekolah tidak valid.";
            header("Location: index.php?controller=Vikor&action=hasilRekomendasi");
            return;
        }
        
        $db = $this->model->getDb();
        $stmt = $db->prepare("SELECT hr.*, stk.* FROM hasil_rekomendasi hr 
                             JOIN sekolah_tk stk ON hr.sekolah_id = stk.id 
                             WHERE hr.user_id = ? AND hr.sekolah_id = ?");
        $stmt->bind_param("ii", $user_id, $sekolah_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            $_SESSION['error'] = "Data rekomendasi tidak ditemukan.";
            header("Location: index.php?controller=Vikor&action=hasilRekomendasi");
            return;
        }
        
        $detailRekomendasi = $result->fetch_assoc();
        
        $stmt = $db->prepare("SELECT ntk.*, k.nama as nama_kriteria, k.kode as kode_kriteria 
                             FROM nilai_tk ntk 
                             JOIN kriteria k ON ntk.kriteria_id = k.id 
                             WHERE ntk.sekolah_id = ?");
        $stmt->bind_param("i", $sekolah_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $detailNilai = $result->fetch_all(MYSQLI_ASSOC);
        
        include VIEW_PATH . 'vikor/detail_rekomendasi.php';
    }
    
    public function matriksKeputusan()
    {
        $kriteria = $this->model->getAllKriteria();
        $sekolahTK = $this->model->getAllSekolahTK();
        $nilaiTK = $this->model->getNilaiTK();
        $bobotKriteria = $this->model->getBobotKriteria('vikor');
        
        $matriksKeputusan = [];
        foreach ($sekolahTK as $sekolah) {
            $matriksKeputusan[$sekolah['id']] = [];
            foreach ($kriteria as $k) {
                $matriksKeputusan[$sekolah['id']][$k['id']] = 0;
            }
        }
        
        foreach ($nilaiTK as $nilai) {
            if (isset($matriksKeputusan[$nilai['sekolah_id']][$nilai['kriteria_id']])) {
                $matriksKeputusan[$nilai['sekolah_id']][$nilai['kriteria_id']] = $nilai['nilai'];
            }
        }
        
        include VIEW_PATH . 'vikor/matriks_keputusan.php';
    }
    
    public function cetakRekomendasi()
    {
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        
        if ($user_id == 0) {
            $_SESSION['error'] = "Anda harus login terlebih dahulu.";
            header("Location: index.php?controller=Login&action=login");
            return;
        }
        
        $hasilRekomendasi = $this->model->getHasilRekomendasi($user_id);
        $parameterVikor = $this->model->getParameterVikor();
        $_SESSION['parameter_vikor_v'] = $parameterVikor['nilai_v'];
        
        include VIEW_PATH . 'vikor/cetak_rekomendasi.php';
    }
}