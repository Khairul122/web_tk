<?php
class SubkriteriaModel {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function getAll() {
        $query = "
            SELECT s.*, k.nama AS nama_kriteria 
            FROM subkriteria s 
            JOIN kriteria k ON s.kriteria_id = k.id 
            ORDER BY s.kriteria_id, s.nilai DESC
        ";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM subkriteria WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO subkriteria (kriteria_id, nama, nilai, keterangan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", 
            $data['kriteria_id'],
            $data['nama'],
            $data['nilai'],
            $data['keterangan']
        );
        return $stmt->execute();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE subkriteria SET kriteria_id = ?, nama = ?, nilai = ?, keterangan = ? WHERE id = ?");
        $stmt->bind_param("isisi", 
            $data['kriteria_id'],
            $data['nama'],
            $data['nilai'],
            $data['keterangan'],
            $id
        );
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM subkriteria WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getKriteriaOptions() {
        $result = $this->db->query("SELECT id, nama FROM kriteria ORDER BY nama ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
