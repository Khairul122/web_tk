<?php
class HasilModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function getKriteria()
    {
        $query = "SELECT * FROM kriteria ORDER BY kode ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getBobotKriteria()
    {
        $query = "SELECT bk.*, k.nama as nama_kriteria, k.kode as kode_kriteria, k.jenis as jenis_kriteria FROM bobot_kriteria bk JOIN kriteria k ON bk.kriteria_id = k.id WHERE bk.jenis = 'vikor' ORDER BY k.kode ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPreferensiUser($user_id)
    {
        $stmt = $this->db->prepare("SELECT p.*, k.nama as nama_kriteria, k.kode as kode_kriteria FROM preferensi_orangtua p JOIN kriteria k ON p.kriteria_id = k.id WHERE p.user_id = ? ORDER BY k.kode ASC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getNilaiKriteria($sekolah_id)
    {
        $stmt = $this->db->prepare("SELECT n.*, k.nama as nama_kriteria, k.kode as kode_kriteria, k.jenis as jenis_kriteria, sub.nama as nama_subkriteria, sub.nilai as nilai_subkriteria FROM nilai_tk n JOIN kriteria k ON n.kriteria_id = k.id LEFT JOIN subkriteria sub ON n.subkriteria_id = sub.id WHERE n.sekolah_id = ? ORDER BY k.kode ASC");
        $stmt->bind_param("i", $sekolah_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getDetailSekolah($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM sekolah_tk WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getHasilRekomendasi($user_id)
    {
        $stmt = $this->db->prepare("SELECT hr.*, s.nama_tk, s.alamat, s.foto, s.kontak, s.email, s.deskripsi FROM hasil_rekomendasi hr JOIN sekolah_tk s ON hr.sekolah_id = s.id WHERE hr.user_id = ? ORDER BY hr.peringkat ASC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getSekolahTK()
    {
        $query = "SELECT * FROM sekolah_tk ORDER BY nama_tk ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


   public function hitungVikorAhp($user_id)
{
    $this->db->query("DELETE FROM hasil_rekomendasi WHERE user_id = $user_id");

    $sekolah = $this->getSekolahTK();
    $kriteria = $this->getKriteria();
    $bobot = [];
    foreach ($this->getBobotKriteria() as $b) {
        $bobot[$b['kriteria_id']] = $b['bobot'];
    }

    $preferensi = $this->getPreferensiUser($user_id);
    $totalPreferensi = array_sum(array_column($preferensi, 'nilai_preferensi'));
    if ($totalPreferensi > 0) {
        foreach ($preferensi as $p) {
            $k = $p['kriteria_id'];
            $bobot[$k] = ($bobot[$k] * ($p['nilai_preferensi'] / 3.0));
        }
        $sum = array_sum($bobot);
        foreach ($bobot as $k => $v) {
            $bobot[$k] = $v / $sum;
        }
    }

    $rata2 = count($preferensi) > 0 ? $totalPreferensi / count($preferensi) : 0;
    $v = ($rata2 >= 4.5) ? 0.7 : (($rata2 >= 3.5) ? 0.5 : 0.3);

    $this->db->query("DELETE FROM parameter_vikor");
    $stmt = $this->db->prepare("INSERT INTO parameter_vikor (nilai_v, keterangan, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
    $ket = "Nilai v berdasarkan rata-rata preferensi user $user_id";
    $stmt->bind_param("ds", $v, $ket);
    $stmt->execute();

    $nilai = [];
    foreach ($sekolah as $s) {
        $sid = $s['id'];
        foreach ($kriteria as $k) {
            $kid = $k['id'];
            $res = $this->db->query("SELECT nilai FROM nilai_tk WHERE sekolah_id = $sid AND kriteria_id = $kid")->fetch_assoc();
            $nilai[$sid][$kid] = $res ? floatval($res['nilai']) : 0;
        }
    }

    $fPlus = [];
    $fMin = [];
    foreach ($kriteria as $k) {
        $kid = $k['id'];
        $jenis = $k['jenis'];
        $kolom = array_column($nilai, $kid);
        $fPlus[$kid] = ($jenis == 'benefit') ? max($kolom) : min($kolom);
        $fMin[$kid] = ($jenis == 'benefit') ? min($kolom) : max($kolom);
    }

    $S = [];
    $R = [];
    foreach ($nilai as $sid => $vRow) {
        $s = 0;
        $r = -INF;
        foreach ($kriteria as $k) {
            $kid = $k['id'];
            $d = ($fPlus[$kid] - $vRow[$kid]) / (($fPlus[$kid] - $fMin[$kid]) ?: 1);
            $ws = $bobot[$kid] * $d;
            $s += $ws;
            if ($ws > $r) $r = $ws;
        }
        $S[$sid] = $s;
        $R[$sid] = $r;
    }

    $Smin = min($S);
    $Smax = max($S);
    $Rmin = min($R);
    $Rmax = max($R);

    $Q = [];
    foreach ($nilai as $sid => $vTmp) {
        $q = 0;
        if ($Smax - $Smin != 0)
            $q += $v * (($S[$sid] - $Smin) / ($Smax - $Smin));
        if ($Rmax - $Rmin != 0)
            $q += (1 - $v) * (($R[$sid] - $Rmin) / ($Rmax - $Rmin));
        $Q[$sid] = $q;
    }

    asort($Q);
    $stmt = $this->db->prepare("INSERT INTO hasil_rekomendasi (user_id, sekolah_id, nilai_s, nilai_r, nilai_q, peringkat) VALUES (?, ?, ?, ?, ?, ?)");
    $peringkat = 1;
    foreach ($Q as $sid => $q) {
        $s = $S[$sid];
        $r = $R[$sid];
        $stmt->bind_param("iidddi", $user_id, $sid, $s, $r, $q, $peringkat);
        $stmt->execute();
        $peringkat++;
    }

    return $this->getHasilRekomendasi($user_id);
}
}
