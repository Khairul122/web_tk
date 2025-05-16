<?php
class VikorModel
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

    public function getBobotKriteria($jenis = 'ahp')
    {
        $query = "SELECT bk.*, k.nama as nama_kriteria, k.kode as kode_kriteria, k.jenis as jenis_kriteria 
                  FROM bobot_kriteria bk 
                  JOIN kriteria k ON bk.kriteria_id = k.id 
                  WHERE bk.jenis = ? 
                  ORDER BY k.kode ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $jenis);
        $stmt->execute();
        $result = $stmt->get_result();
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
            $this->simpanBobotKriteria($kriteria_id, $nilai_bobot, 'ahp');
            $this->simpanHasilAHP($kriteria_id, $nilai_bobot, $lambdaMax, $ci, $cr);
        }
        
        return $hasilPerhitungan;
    }

    public function simpanBobotKriteria($kriteria_id, $bobot, $jenis = 'ahp')
    {
        $stmt = $this->db->prepare("SELECT id FROM bobot_kriteria WHERE kriteria_id = ? AND jenis = ?");
        $stmt->bind_param("is", $kriteria_id, $jenis);
        $stmt->execute();
        $result = $stmt->get_result();
        
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

    public function simpanHasilAHP($kriteria_id, $bobot, $lambda_max, $ci, $cr)
    {
        $stmt = $this->db->prepare("SELECT id FROM hasil_ahp WHERE kriteria_id = ?");
        $stmt->bind_param("i", $kriteria_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt = $this->db->prepare("UPDATE hasil_ahp SET bobot = ?, lambda_max = ?, ci = ?, cr = ? WHERE id = ?");
            $stmt->bind_param("ddddi", $bobot, $lambda_max, $ci, $cr, $row['id']);
        } else {
            $stmt = $this->db->prepare("INSERT INTO hasil_ahp (kriteria_id, bobot, lambda_max, ci, cr) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("idddd", $kriteria_id, $bobot, $lambda_max, $ci, $cr);
        }
        
        return $stmt->execute();
    }

    public function getHasilAHP()
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

    public function getAlternatif()
    {
        $query = "SELECT * FROM sekolah_tk ORDER BY nama_tk ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNilaiAlternatif()
    {
        $query = "SELECT n.*, k.nama as nama_kriteria, k.kode as kode_kriteria, k.jenis as jenis_kriteria,
                  s.nama_tk, sub.nama as nama_subkriteria
                  FROM nilai_tk n
                  JOIN kriteria k ON n.kriteria_id = k.id
                  JOIN sekolah_tk s ON n.sekolah_id = s.id
                  LEFT JOIN subkriteria sub ON n.subkriteria_id = sub.id
                  ORDER BY s.nama_tk, k.kode ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPreferensiUser($user_id)
    {
        $query = "SELECT p.*, k.nama as nama_kriteria, k.kode as kode_kriteria
                  FROM preferensi_orangtua p
                  JOIN kriteria k ON p.kriteria_id = k.id
                  WHERE p.user_id = ?
                  ORDER BY k.kode ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function hitungVikor($user_id)
    {
        $alternatif = $this->getAlternatif();
        $kriteria = $this->getAllKriteria();
        $bobotKriteria = $this->getBobotKriteria('vikor');
        $nilaiAlternatif = $this->getNilaiAlternatif();
        $preferensiUser = $this->getPreferensiUser($user_id);

        $matriksKeputusan = [];
        $bobot = [];

        foreach ($bobotKriteria as $bk) {
            $bobot[$bk['kriteria_id']] = floatval($bk['bobot']);
        }

        if (!empty($preferensiUser)) {
            $totalPreferensi = 0;
            foreach ($preferensiUser as $pref) {
                $totalPreferensi += floatval($pref['nilai_preferensi']);
            }

            if ($totalPreferensi > 0) {
                $modifiedBobot = [];
                foreach ($preferensiUser as $pref) {
                    $origBobot = isset($bobot[$pref['kriteria_id']]) ? $bobot[$pref['kriteria_id']] : 0;
                    $prefWeight = floatval($pref['nilai_preferensi']) / 3.0; 
                    $modifiedBobot[$pref['kriteria_id']] = $origBobot * $prefWeight;
                }
                
                $totalModifiedBobot = array_sum($modifiedBobot);
                if ($totalModifiedBobot > 0) {
                    foreach ($modifiedBobot as $kritId => $b) {
                        $bobot[$kritId] = $b / $totalModifiedBobot;
                    }
                }
            }
        }

        foreach ($alternatif as $alt) {
            foreach ($kriteria as $krit) {
                $matriksKeputusan[$alt['id']][$krit['id']] = null;
            }
        }

        foreach ($nilaiAlternatif as $nilai) {
            if (isset($matriksKeputusan[$nilai['sekolah_id']][$nilai['kriteria_id']])) {
                $matriksKeputusan[$nilai['sekolah_id']][$nilai['kriteria_id']] = floatval($nilai['nilai']);
            }
        }

        $fPlus = [];
        $fMinus = [];

        foreach ($kriteria as $krit) {
            $values = [];
            foreach ($alternatif as $alt) {
                if (isset($matriksKeputusan[$alt['id']][$krit['id']]) && 
                    $matriksKeputusan[$alt['id']][$krit['id']] !== null) {
                    $values[] = $matriksKeputusan[$alt['id']][$krit['id']];
                }
            }

            if (!empty($values)) {
                if ($krit['jenis'] === 'benefit') {
                    $fPlus[$krit['id']] = max($values);
                    $fMinus[$krit['id']] = min($values);
                } else { 
                    $fPlus[$krit['id']] = min($values);
                    $fMinus[$krit['id']] = max($values);
                }
            } else {
                $fPlus[$krit['id']] = 0;
                $fMinus[$krit['id']] = 0;
            }
        }

        $sValues = [];
        $rValues = [];

        foreach ($alternatif as $alt) {
            $sValues[$alt['id']] = 0;
            $rValues[$alt['id']] = 0;
            $maxRValue = 0;

            foreach ($kriteria as $krit) {
                if (isset($matriksKeputusan[$alt['id']][$krit['id']]) && 
                    $matriksKeputusan[$alt['id']][$krit['id']] !== null && 
                    isset($fPlus[$krit['id']]) && 
                    isset($fMinus[$krit['id']]) && 
                    ($fPlus[$krit['id']] != $fMinus[$krit['id']])) {
                    
                    $nilai = $matriksKeputusan[$alt['id']][$krit['id']];
                    $normValue = ($fPlus[$krit['id']] - $nilai) / ($fPlus[$krit['id']] - $fMinus[$krit['id']]);
                    $weightedValue = $normValue * $bobot[$krit['id']];
                    
                    $sValues[$alt['id']] += $weightedValue;
                    
                    if ($weightedValue > $maxRValue) {
                        $maxRValue = $weightedValue;
                    }
                }
            }
            
            $rValues[$alt['id']] = $maxRValue;
        }

        $sMin = min($sValues);
        $sMax = max($sValues);
        $rMin = min($rValues);
        $rMax = max($rValues);

        $qValues = [];
        $v = 0.5; 

        foreach ($alternatif as $alt) {
            if (($sMax - $sMin) == 0 || ($rMax - $rMin) == 0) {
                $qValues[$alt['id']] = 0;
            } else {
                $qValues[$alt['id']] = 
                    $v * (($sValues[$alt['id']] - $sMin) / ($sMax - $sMin)) + 
                    (1 - $v) * (($rValues[$alt['id']] - $rMin) / ($rMax - $rMin));
            }
        }

        asort($qValues);

        $hasil = [];
        $rank = 1;

        foreach ($qValues as $id => $q) {
            $hasil[] = [
                'sekolah_id' => $id,
                'nilai_s' => $sValues[$id],
                'nilai_r' => $rValues[$id],
                'nilai_q' => $q,
                'peringkat' => $rank++
            ];
        }

        $this->simpanHasilRekomendasi($user_id, $hasil);

        return $hasil;
    }

    public function simpanHasilRekomendasi($user_id, $hasil)
    {
        $this->hapusHasilRekomendasi($user_id);

        $stmt = $this->db->prepare("INSERT INTO hasil_rekomendasi (user_id, sekolah_id, nilai_s, nilai_r, nilai_q, peringkat) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($hasil as $data) {
            $stmt->bind_param(
                "iidddi", 
                $user_id, 
                $data['sekolah_id'], 
                $data['nilai_s'], 
                $data['nilai_r'], 
                $data['nilai_q'], 
                $data['peringkat']
            );
            $stmt->execute();
        }
    }

    private function hapusHasilRekomendasi($user_id)
    {
        $stmt = $this->db->prepare("DELETE FROM hasil_rekomendasi WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    public function getHasilRekomendasi($user_id)
    {
        $query = "SELECT hr.*, s.nama_tk, s.alamat, s.foto, s.kontak, s.email, s.deskripsi 
                 FROM hasil_rekomendasi hr
                 JOIN sekolah_tk s ON hr.sekolah_id = s.id
                 WHERE hr.user_id = ?
                 ORDER BY hr.peringkat ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getDetailTK($id)
    {
        $query = "SELECT * FROM sekolah_tk WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getNilaiTK($id)
    {
        $query = "SELECT n.*, k.nama as nama_kriteria, k.kode as kode_kriteria, k.jenis as jenis_kriteria,
                  sub.nama as nama_subkriteria
                  FROM nilai_tk n
                  JOIN kriteria k ON n.kriteria_id = k.id
                  LEFT JOIN subkriteria sub ON n.subkriteria_id = sub.id
                  WHERE n.sekolah_id = ?
                  ORDER BY k.kode ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function userSudahIsiPreferensi($user_id)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM preferensi_orangtua WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }

    public function simpanPreferensi($user_id, $preferensi)
    {
        $this->hapusPreferensiUser($user_id);

        $stmt = $this->db->prepare("INSERT INTO preferensi_orangtua (user_id, kriteria_id, nilai_preferensi) VALUES (?, ?, ?)");
        $sukses = true;
        
        foreach ($preferensi as $kriteria_id => $nilai) {
            $stmt->bind_param("iid", $user_id, $kriteria_id, $nilai);
            if (!$stmt->execute()) {
                $sukses = false;
            }
        }
        
        return $sukses;
    }

    private function hapusPreferensiUser($user_id)
    {
        $stmt = $this->db->prepare("DELETE FROM preferensi_orangtua WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    public function getSubkriteria()
    {
        $query = "SELECT s.*, k.nama as nama_kriteria, k.kode as kode_kriteria
                  FROM subkriteria s
                  JOIN kriteria k ON s.kriteria_id = k.id
                  ORDER BY k.kode ASC, s.nilai DESC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSubkriteriaByKriteria($kriteria_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM subkriteria WHERE kriteria_id = ? ORDER BY nilai DESC");
        $stmt->bind_param("i", $kriteria_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}