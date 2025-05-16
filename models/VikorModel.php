<?php
class VikorModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function getDb()
    {
        return $this->db;
    }

    public function getAllKriteria()
    {
        $query = "SELECT * FROM kriteria ORDER BY kode ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getBobotKriteria($jenis = 'vikor')
    {
        $query = "SELECT bk.*, k.nama as nama_kriteria, k.kode as kode_kriteria, k.jenis as jenis_kriteria 
                  FROM bobot_kriteria bk 
                  JOIN kriteria k ON bk.kriteria_id = k.id 
                  WHERE bk.jenis = '$jenis' 
                  ORDER BY k.kode ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllSekolahTK()
    {
        $query = "SELECT * FROM sekolah_tk ORDER BY nama_tk ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNilaiTK()
    {
        $query = "SELECT ntk.*, stk.nama_tk, k.nama as nama_kriteria, k.kode as kode_kriteria, k.jenis as jenis_kriteria, 
                  sk.nama as nama_subkriteria, sk.nilai as nilai_subkriteria 
                  FROM nilai_tk ntk
                  JOIN sekolah_tk stk ON ntk.sekolah_id = stk.id
                  JOIN kriteria k ON ntk.kriteria_id = k.id
                  LEFT JOIN subkriteria sk ON ntk.subkriteria_id = sk.id
                  ORDER BY stk.nama_tk ASC, k.kode ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPreferensiOrangTua($user_id)
    {
        $query = "SELECT po.*, k.nama as nama_kriteria, k.kode as kode_kriteria, k.jenis as jenis_kriteria 
                  FROM preferensi_orangtua po 
                  JOIN kriteria k ON po.kriteria_id = k.id 
                  WHERE po.user_id = $user_id 
                  ORDER BY k.kode ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function simpanParameterVikor($nilai_v, $keterangan)
    {
        $stmt = $this->db->prepare("SELECT id FROM parameter_vikor LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt = $this->db->prepare("UPDATE parameter_vikor SET nilai_v = ?, keterangan = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bind_param("dsi", $nilai_v, $keterangan, $row['id']);
        } else {
            $stmt = $this->db->prepare("INSERT INTO parameter_vikor (nilai_v, keterangan, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
            $stmt->bind_param("ds", $nilai_v, $keterangan);
        }

        return $stmt->execute();
    }

    public function getParameterVikor()
    {
        $query = "SELECT * FROM parameter_vikor LIMIT 1";
        $result = $this->db->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return ['nilai_v' => 0.5, 'keterangan' => 'Default parameter'];
    }

    public function simpanHasilRekomendasi($user_id, $sekolah_id, $nilai_s, $nilai_r, $nilai_q, $peringkat)
    {
        $stmt = $this->db->prepare("SELECT id FROM hasil_rekomendasi WHERE user_id = ? AND sekolah_id = ?");
        $stmt->bind_param("ii", $user_id, $sekolah_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt = $this->db->prepare("UPDATE hasil_rekomendasi SET nilai_s = ?, nilai_r = ?, nilai_q = ?, peringkat = ?, tanggal_rekomendasi = NOW() WHERE id = ?");
            $stmt->bind_param("dddii", $nilai_s, $nilai_r, $nilai_q, $peringkat, $row['id']);
        } else {
            $stmt = $this->db->prepare("INSERT INTO hasil_rekomendasi (user_id, sekolah_id, nilai_s, nilai_r, nilai_q, peringkat, tanggal_rekomendasi) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("iidddi", $user_id, $sekolah_id, $nilai_s, $nilai_r, $nilai_q, $peringkat);
        }

        return $stmt->execute();
    }

    public function getHasilRekomendasi($user_id)
    {
        $query = "SELECT hr.*, stk.nama_tk, stk.alamat, stk.deskripsi, stk.kontak, stk.email, stk.latitude, stk.longitude, stk.foto 
                  FROM hasil_rekomendasi hr 
                  JOIN sekolah_tk stk ON hr.sekolah_id = stk.id 
                  WHERE hr.user_id = $user_id 
                  ORDER BY hr.peringkat ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function hitungVIKOR($user_id)
    {
        $kriteria = $this->getAllKriteria();
        $sekolahTK = $this->getAllSekolahTK();
        $nilaiTK = $this->getNilaiTK();
        $bobotKriteria = $this->getBobotKriteria('vikor');
        $preferensiOrangTua = $this->getPreferensiOrangTua($user_id);
        $parameterVikor = $this->getParameterVikor();
        $v = $parameterVikor['nilai_v'];

        $matriksKeputusan = [];
        foreach ($sekolahTK as $sekolah) {
            $matriksKeputusan[$sekolah['id']] = [];
            foreach ($kriteria as $k) {
                $matriksKeputusan[$sekolah['id']][$k['id']] = 0;
            }
        }

        foreach ($nilaiTK as $nilai) {
            $matriksKeputusan[$nilai['sekolah_id']][$nilai['kriteria_id']] = $nilai['nilai'];
        }

        $fPlus = [];
        $fMinus = [];
        foreach ($kriteria as $k) {
            $values = array_column(array_map(function ($sekolah) use ($k) {
                return $sekolah[$k['id']];
            }, $matriksKeputusan), null);

            if ($k['jenis'] == 'benefit') {
                $fPlus[$k['id']] = max($values);
                $fMinus[$k['id']] = min($values);
            } else {
                $fPlus[$k['id']] = min($values);
                $fMinus[$k['id']] = max($values);
            }
        }

        $S = [];
        $R = [];
        foreach ($sekolahTK as $sekolah) {
            $S[$sekolah['id']] = 0;
            $R[$sekolah['id']] = 0;

            foreach ($kriteria as $k) {
                $bobot = 0;
                foreach ($bobotKriteria as $bk) {
                    if ($bk['kriteria_id'] == $k['id']) {
                        $bobot = $bk['bobot'];
                        break;
                    }
                }

                $preferensi = 1;
                foreach ($preferensiOrangTua as $po) {
                    if ($po['kriteria_id'] == $k['id']) {
                        $preferensi = $po['nilai_preferensi'] / 5;
                        break;
                    }
                }

                $bobotModifikasi = $bobot * $preferensi;

                $fPlus_j = $fPlus[$k['id']];
                $fMinus_j = $fMinus[$k['id']];
                $f_ij = $matriksKeputusan[$sekolah['id']][$k['id']];

                if ($fPlus_j != $fMinus_j) {
                    $nilai = $bobotModifikasi * abs($fPlus_j - $f_ij) / abs($fPlus_j - $fMinus_j);
                    $S[$sekolah['id']] += $nilai;
                    $R[$sekolah['id']] = max($R[$sekolah['id']], $nilai);
                }
            }
        }

        $Splus = max($S);
        $Sminus = min($S);
        $Rplus = max($R);
        $Rminus = min($R);

        $Q = [];
        foreach ($sekolahTK as $sekolah) {
            if ($Splus != $Sminus && $Rplus != $Rminus) {
                $Q[$sekolah['id']] = $v * ($S[$sekolah['id']] - $Sminus) / ($Splus - $Sminus) +
                    (1 - $v) * ($R[$sekolah['id']] - $Rminus) / ($Rplus - $Rminus);
            } else {
                $Q[$sekolah['id']] = 0.5;
            }
        }

        asort($Q);

        $peringkat = 1;
        foreach ($Q as $sekolah_id => $nilai_q) {
            $this->simpanHasilRekomendasi(
                $user_id,
                $sekolah_id,
                $S[$sekolah_id],
                $R[$sekolah_id],
                $nilai_q,
                $peringkat
            );
            $peringkat++;
        }

        $_SESSION['hasil_vikor'] = [
            'matriksKeputusan' => $matriksKeputusan,
            'fPlus' => $fPlus,
            'fMinus' => $fMinus,
            'S' => $S,
            'R' => $R,
            'Q' => $Q,
            'peringkat' => array_keys($Q)
        ];

        return $_SESSION['hasil_vikor'];
    }

    public function getHasilVIKOR()
    {
        return isset($_SESSION['hasil_vikor']) ? $_SESSION['hasil_vikor'] : null;
    }
}
