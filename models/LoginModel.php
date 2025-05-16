<?php
class LoginModel {
    private $koneksi;

    public function __construct($db) {
        $this->koneksi = $db;
    }

    public function getUserByUsername($username) {
        $stmt = $this->koneksi->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
