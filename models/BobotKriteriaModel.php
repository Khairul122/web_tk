<?php
class BobotKriteriaModel {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function getAll() {
        $query = "
            SELECT b.*, k.nama AS nama_kriteria 
            FROM bobot_kriteria b 
            JOIN kriteria k ON b.kriteria_id = k.id 
            ORDER BY b.jenis, k.nama
        ";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM bobot_kriteria WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO bobot_kriteria (kriteria_id, bobot, jenis) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", 
            $data['kriteria_id'], 
            $data['bobot'], 
            $data['jenis']
        );
        return $stmt->execute();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE bobot_kriteria SET kriteria_id = ?, bobot = ?, jenis = ? WHERE id = ?");
        $stmt->bind_param("idsi", 
            $data['kriteria_id'], 
            $data['bobot'], 
            $data['jenis'], 
            $id
        );
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM bobot_kriteria WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getKriteriaOptions() {
        $result = $this->db->query("SELECT id, nama FROM kriteria ORDER BY nama ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
