<?php
class KriteriaModel {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function getAll() {
        $result = $this->db->query("SELECT * FROM kriteria ORDER BY id ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM kriteria WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO kriteria (kode, nama, deskripsi, jenis) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", 
            $data['kode'], 
            $data['nama'], 
            $data['deskripsi'], 
            $data['jenis']
        );
        return $stmt->execute();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE kriteria SET kode = ?, nama = ?, deskripsi = ?, jenis = ? WHERE id = ?");
        $stmt->bind_param("ssssi", 
            $data['kode'], 
            $data['nama'], 
            $data['deskripsi'], 
            $data['jenis'], 
            $id
        );
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM kriteria WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
}
