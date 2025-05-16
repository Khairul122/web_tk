<?php
class PreferensiOrangtuaModel {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function insertMultiple($user_id, $preferensi) {
        $stmt = $this->db->prepare("INSERT INTO preferensi_orangtua (user_id, kriteria_id, nilai_preferensi) VALUES (?, ?, ?)");
        foreach ($preferensi as $kriteria_id => $nilai) {
            $stmt->bind_param("iid", $user_id, $kriteria_id, $nilai);
            $stmt->execute();
        }
    }

    public function userHasFilled($user_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM preferensi_orangtua WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }
}
