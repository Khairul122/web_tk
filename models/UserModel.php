<?php
class UserModel {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function getAllOrangtua() {
        $result = $this->db->query("SELECT * FROM users WHERE role = 'orangtua'");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
