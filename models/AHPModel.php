<?php
class AHPModel
{
    private $db;
    private $randomIndex = [
        1 => 0.00,
        2 => 0.00,
        3 => 0.58,
        4 => 0.90,
        5 => 1.12,
        6 => 1.24,
        7 => 1.32,
        8 => 1.41,
        9 => 1.45,
        10 => 1.49,
        11 => 1.51,
        12 => 1.48,
        13 => 1.56,
        14 => 1.57,
        15 => 1.59
    ];

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function getAllKriteria()
    {
        $query = "SELECT * FROM kriteria ORDER BY kode ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMatriksPerbandingan()
    {
        $query = "SELECT * FROM matriks_perbandingan_ahp";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getBobotKriteria()
    {
        $query = "SELECT bk.*, k.nama as nama_kriteria, k.kode as kode_kriteria 
                  FROM bobot_kriteria bk 
                  JOIN kriteria k ON bk.kriteria_id = k.id 
                  WHERE bk.jenis = 'ahp' 
                  ORDER BY k.kode ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function simpanPerbandingan($kriteria_baris, $kriteria_kolom, $nilai)
    {
        $stmt = $this->db->prepare("SELECT id FROM matriks_perbandingan_ahp WHERE kriteria_baris = ? AND kriteria_kolom = ?");
        $stmt->bind_param("ii", $kriteria_baris, $kriteria_kolom);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt = $this->db->prepare("UPDATE matriks_perbandingan_ahp SET nilai = ? WHERE id = ?");
            $stmt->bind_param("di", $nilai, $row['id']);
        } else {
            $stmt = $this->db->prepare("INSERT INTO matriks_perbandingan_ahp (kriteria_baris, kriteria_kolom, nilai) VALUES (?, ?, ?)");
            $stmt->bind_param("iid", $kriteria_baris, $kriteria_kolom, $nilai);
        }
        
        return $stmt->execute();
    }

    public function hapusMatriksPerbandingan()
    {
        return $this->db->query("DELETE FROM matriks_perbandingan_ahp");
    }
    
    public function simpanHasilAHP($kriteria_id, $bobot, $lambda_max, $ci, $cr)
    {
        // Periksa apakah hasil AHP untuk kriteria ini sudah ada
        $stmt = $this->db->prepare("SELECT id FROM hasil_ahp WHERE kriteria_id = ?");
        $stmt->bind_param("i", $kriteria_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Update hasil yang sudah ada
            $row = $result->fetch_assoc();
            $stmt = $this->db->prepare("UPDATE hasil_ahp SET bobot = ?, lambda_max = ?, ci = ?, cr = ? WHERE id = ?");
            $stmt->bind_param("ddddi", $bobot, $lambda_max, $ci, $cr, $row['id']);
        } else {
            // Insert hasil baru
            $stmt = $this->db->prepare("INSERT INTO hasil_ahp (kriteria_id, bobot, lambda_max, ci, cr) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("idddd", $kriteria_id, $bobot, $lambda_max, $ci, $cr);
        }
        
        return $stmt->execute();
    }
    
    public function getHasilAHPDariDatabase()
    {
        $query = "SELECT ha.*, k.nama as nama_kriteria, k.kode as kode_kriteria 
                 FROM hasil_ahp ha 
                 JOIN kriteria k ON ha.kriteria_id = k.id 
                 ORDER BY k.kode ASC";
        $result = $this->db->query($query);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        return [];
    }

    public function hitungAHP()
    {
        $kriteria = $this->getAllKriteria();
        $matriks = $this->getMatriksPerbandingan();
        
        $matriksA = [];
        foreach ($kriteria as $k) {
            foreach ($kriteria as $l) {
                $matriksA[$k['id']][$l['id']] = 1;
            }
        }
        
        foreach ($matriks as $m) {
            $matriksA[$m['kriteria_baris']][$m['kriteria_kolom']] = $m['nilai'];
        }
        
        $jumlahKolom = [];
        foreach ($kriteria as $k) {
            $jumlahKolom[$k['id']] = 0;
            foreach ($kriteria as $l) {
                $jumlahKolom[$k['id']] += $matriksA[$l['id']][$k['id']];
            }
        }
        
        $matriksNormalisasi = [];
        foreach ($kriteria as $k) {
            foreach ($kriteria as $l) {
                $matriksNormalisasi[$k['id']][$l['id']] = $matriksA[$k['id']][$l['id']] / $jumlahKolom[$l['id']];
            }
        }
        
        $bobot = [];
        foreach ($kriteria as $k) {
            $jumlahBaris = 0;
            foreach ($kriteria as $l) {
                $jumlahBaris += $matriksNormalisasi[$k['id']][$l['id']];
            }
            $bobot[$k['id']] = $jumlahBaris / count($kriteria);
        }
        
        $consistencyVector = [];
        foreach ($kriteria as $k) {
            $hasil = 0;
            foreach ($kriteria as $l) {
                $hasil += $matriksA[$k['id']][$l['id']] * $bobot[$l['id']];
            }
            $consistencyVector[$k['id']] = $hasil / $bobot[$k['id']];
        }
        
        $lambdaMax = 0;
        foreach ($consistencyVector as $cv) {
            $lambdaMax += $cv;
        }
        $lambdaMax = $lambdaMax / count($kriteria);
        
        $ci = (count($kriteria) > 1) ? ($lambdaMax - count($kriteria)) / (count($kriteria) - 1) : 0;
        
        $ri = isset($this->randomIndex[count($kriteria)]) ? $this->randomIndex[count($kriteria)] : 1.59;
        $cr = ($ri != 0) ? $ci / $ri : 0;
        
        $hasilPerhitungan = [
            'matriksA' => $matriksA,
            'jumlahKolom' => $jumlahKolom,
            'matriksNormalisasi' => $matriksNormalisasi,
            'bobot' => $bobot,
            'consistencyVector' => $consistencyVector,
            'lambdaMax' => $lambdaMax,
            'ci' => $ci,
            'ri' => $ri,
            'cr' => $cr
        ];
        
        $_SESSION['hasil_ahp'] = $hasilPerhitungan;
        
        foreach ($bobot as $kriteria_id => $nilai_bobot) {
            $this->simpanHasilAHP($kriteria_id, $nilai_bobot, $lambdaMax, $ci, $cr);
        }
        
        return $hasilPerhitungan;
    }

    public function getHasilPerhitungan()
    {
        $hasil = isset($_SESSION['hasil_ahp']) ? $_SESSION['hasil_ahp'] : null;
        
        if (!$hasil) {
            $hasilDB = $this->getHasilAHPDariDatabase();
            
            if (count($hasilDB) > 0) {
                $lambdaMax = $hasilDB[0]['lambda_max'];
                $ci = $hasilDB[0]['ci'];
                $ri = isset($this->randomIndex[count($hasilDB)]) ? $this->randomIndex[count($hasilDB)] : 1.59;
                $cr = $hasilDB[0]['cr'];
                
                $bobot = [];
                foreach ($hasilDB as $h) {
                    $bobot[$h['kriteria_id']] = (float)$h['bobot'];
                }
                
                $hasil = $this->rekonstruksiHasilPerhitungan();
                
                if ($hasil) {
                    $_SESSION['hasil_ahp'] = $hasil;
                }
            }
        }
        
        return $hasil;
    }

    public function simpanBobotKriteria($kriteria_id, $bobot)
    {
        $stmt = $this->db->prepare("SELECT id FROM bobot_kriteria WHERE kriteria_id = ? AND jenis = 'ahp'");
        $stmt->bind_param("i", $kriteria_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $jenis = 'ahp';
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt = $this->db->prepare("UPDATE bobot_kriteria SET bobot = ? WHERE id = ?");
            $stmt->bind_param("di", $bobot, $row['id']);
        } else {
            $stmt = $this->db->prepare("INSERT INTO bobot_kriteria (kriteria_id, bobot, jenis) VALUES (?, ?, ?)");
            $stmt->bind_param("ids", $kriteria_id, $bobot, $jenis);
        }
        
        return $stmt->execute();
    }
    
    public function rekonstruksiMatriksPerbandingan()
    {
        $bobotKriteria = $this->getBobotKriteria();
        if (count($bobotKriteria) === 0) {
            return false;
        }
        
        $kriteriaBobot = [];
        foreach ($bobotKriteria as $bk) {
            $kriteriaBobot[$bk['kriteria_id']] = $bk['bobot'];
        }
        
        $kriteria = $this->getAllKriteria();
        foreach ($kriteria as $baris) {
            foreach ($kriteria as $kolom) {
                if (isset($kriteriaBobot[$baris['id']]) && isset($kriteriaBobot[$kolom['id']])) {
                    $nilai = $kriteriaBobot[$baris['id']] / $kriteriaBobot[$kolom['id']];
                    $this->simpanPerbandingan($baris['id'], $kolom['id'], $nilai);
                }
            }
        }
        
        return true;
    }
    
    public function rekonstruksiHasilPerhitungan()
    {
        $kriteria = $this->getAllKriteria();
        $bobotKriteria = $this->getBobotKriteria();
        
        if (count($bobotKriteria) === 0) {
            return null;
        }
        
        $bobot = [];
        foreach ($bobotKriteria as $bk) {
            $bobot[$bk['kriteria_id']] = (float)$bk['bobot'];
        }
        
        $matriks = $this->getMatriksPerbandingan();
        if (count($matriks) === 0) {
            $this->rekonstruksiMatriksPerbandingan();
            $matriks = $this->getMatriksPerbandingan();
        }
        
        $matriksA = [];
        foreach ($kriteria as $k) {
            foreach ($kriteria as $l) {
                $matriksA[$k['id']][$l['id']] = 1;
            }
        }
        
        foreach ($matriks as $m) {
            $matriksA[$m['kriteria_baris']][$m['kriteria_kolom']] = $m['nilai'];
        }
        
        $jumlahKolom = [];
        foreach ($kriteria as $k) {
            $jumlahKolom[$k['id']] = 0;
            foreach ($kriteria as $l) {
                $jumlahKolom[$k['id']] += $matriksA[$l['id']][$k['id']];
            }
        }
        
        $matriksNormalisasi = [];
        foreach ($kriteria as $k) {
            foreach ($kriteria as $l) {
                $matriksNormalisasi[$k['id']][$l['id']] = $matriksA[$k['id']][$l['id']] / $jumlahKolom[$l['id']];
            }
        }
        
        $consistencyVector = [];
        foreach ($kriteria as $k) {
            $hasil = 0;
            foreach ($kriteria as $l) {
                $hasil += $matriksA[$k['id']][$l['id']] * $bobot[$l['id']];
            }
            $consistencyVector[$k['id']] = $hasil / $bobot[$k['id']];
        }
        
        $lambdaMax = 0;
        foreach ($consistencyVector as $cv) {
            $lambdaMax += $cv;
        }
        $lambdaMax = $lambdaMax / count($kriteria);
        
        $ci = (count($kriteria) > 1) ? ($lambdaMax - count($kriteria)) / (count($kriteria) - 1) : 0;
        
        $ri = isset($this->randomIndex[count($kriteria)]) ? $this->randomIndex[count($kriteria)] : 1.59;
        $cr = ($ri != 0) ? $ci / $ri : 0;
        
        foreach ($bobot as $kriteria_id => $nilai_bobot) {
            $this->simpanHasilAHP($kriteria_id, $nilai_bobot, $lambdaMax, $ci, $cr);
        }
        
        $hasilPerhitungan = [
            'matriksA' => $matriksA,
            'jumlahKolom' => $jumlahKolom,
            'matriksNormalisasi' => $matriksNormalisasi,
            'bobot' => $bobot,
            'consistencyVector' => $consistencyVector,
            'lambdaMax' => $lambdaMax,
            'ci' => $ci,
            'ri' => $ri,
            'cr' => $cr
        ];
        
        $_SESSION['hasil_ahp'] = $hasilPerhitungan;
        
        return $hasilPerhitungan;
    }
}