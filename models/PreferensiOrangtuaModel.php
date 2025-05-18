<?php
class PreferensiOrangtuaModel {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function insertMultiple($user_id, $preferensi) {
        $stmt = $this->db->prepare("INSERT INTO preferensi_orangtua (user_id, kriteria_id, nilai_preferensi) VALUES (?, ?, ?)");
        foreach ($preferensi as $kriteria_id => $nilai) {
            $nilai_decimal = is_numeric($nilai) ? $nilai : 0;
            $stmt->bind_param("iid", $user_id, $kriteria_id, $nilai_decimal);
            $stmt->execute();
        }
        return true;
    }

    public function userHasFilled($user_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM preferensi_orangtua WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }
    
    public function getPreferensiByUserId($user_id) {
        $stmt = $this->db->prepare("SELECT p.id, p.kriteria_id, p.nilai_preferensi, p.created_at, k.nama as nama_kriteria 
                                    FROM preferensi_orangtua p 
                                    JOIN kriteria k ON p.kriteria_id = k.id 
                                    WHERE p.user_id = ? 
                                    ORDER BY p.created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $preferensi = [];
        $timestamps = [];
        
        while ($row = $result->fetch_assoc()) {
            $timestamp = date('Y-m-d H:i:s', strtotime($row['created_at']));
            
            if (!isset($timestamps[$timestamp])) {
                $timestamps[$timestamp] = [];
            }
            
            $timestamps[$timestamp][$row['kriteria_id']] = [
                'id' => $row['id'],
                'nilai' => $row['nilai_preferensi'],
                'nama_kriteria' => $row['nama_kriteria']
            ];
        }
        
        return $timestamps;
    }
    
    public function getLatestPreferensi($user_id) {
        $stmt = $this->db->prepare("SELECT kriteria_id, nilai_preferensi 
                                    FROM preferensi_orangtua 
                                    WHERE user_id = ? 
                                    ORDER BY created_at DESC 
                                    LIMIT 10"); // Ambil 10 kriteria terbaru
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $preferensi = [];
        while ($row = $result->fetch_assoc()) {
            $preferensi[$row['kriteria_id']] = $row['nilai_preferensi'];
        }
        
        return $preferensi;
    }
    
    public function deletePreferensiByKriteriasAndDate($user_id, $created_at) {
        $timestamp = date('Y-m-d H:i:s', strtotime($created_at));
        $stmt = $this->db->prepare("DELETE FROM preferensi_orangtua 
                                    WHERE user_id = ? 
                                    AND DATE(created_at) = DATE(?)");
        $stmt->bind_param("is", $user_id, $timestamp);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}