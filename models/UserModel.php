<?php
class UserModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function getAllOrangtua()
    {
        $result = $this->db->query("SELECT * FROM users WHERE role = 'orangtua'");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (username, password, nama_lengkap, email, no_telp, alamat, role)
            VALUES (?, ?, ?, ?, ?, ?, 'orangtua')
        ");
        $stmt->bind_param(
            "ssssss",
            $data['username'],
            $data['password'],
            $data['nama_lengkap'],
            $data['email'],
            $data['no_telp'],
            $data['alamat']
        );
        return $stmt->execute();
    }

    public function isUsernameTaken($username)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function isEmailTaken($email)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
