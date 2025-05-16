<?php
class NilaiTkModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function getAll()
    {
        $query = "
            SELECT n.*, 
                   s.nama_tk, 
                   k.nama AS nama_kriteria, 
                   k.kode AS kode_kriteria,
                   sub.nama AS nama_subkriteria,
                   sub.nilai AS nilai_subkriteria
            FROM nilai_tk n
            JOIN sekolah_tk s ON n.sekolah_id = s.id
            JOIN kriteria k ON n.kriteria_id = k.id
            LEFT JOIN subkriteria sub ON n.subkriteria_id = sub.id
            ORDER BY k.kode ASC
        ";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM nilai_tk WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("INSERT INTO nilai_tk (sekolah_id, kriteria_id, nilai, subkriteria_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param(
            "iidi",
            $data['sekolah_id'],
            $data['kriteria_id'],
            $data['nilai'],
            $data['subkriteria_id']
        );
        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE nilai_tk SET sekolah_id=?, kriteria_id=?, nilai=?, subkriteria_id=? WHERE id=?");
        $stmt->bind_param(
            "iidii",
            $data['sekolah_id'],
            $data['kriteria_id'],
            $data['nilai'],
            $data['subkriteria_id'],
            $id
        );
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM nilai_tk WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getSekolahOptions()
    {
        $result = $this->db->query("SELECT id, nama_tk FROM sekolah_tk ORDER BY nama_tk ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getKriteriaOptions()
    {
        $result = $this->db->query("SELECT id, nama, kode FROM kriteria ORDER BY kode ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSubkriteriaOptions()
    {
        $result = $this->db->query("SELECT id, nama, nilai, kriteria_id FROM subkriteria ORDER BY kriteria_id, nama ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
