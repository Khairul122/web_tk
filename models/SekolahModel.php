<?php
class SekolahModel
{
    private $db;

    public function __construct($koneksi)
    {
        $this->db = $koneksi;
    }

    public function getAll()
    {
        $result = $this->db->query("SELECT * FROM sekolah_tk ORDER BY id DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM sekolah_tk WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("INSERT INTO sekolah_tk 
        (nama_tk, alamat, deskripsi, kontak, email, latitude, longitude, foto) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "ssssddss",
            $data['nama_tk'],
            $data['alamat'],
            $data['deskripsi'],
            $data['kontak'],
            $data['email'],
            $data['latitude'],
            $data['longitude'],
            $data['foto']
        );

        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE sekolah_tk SET nama_tk=?, alamat=?, deskripsi=?, kontak=?, email=?, latitude=?, longitude=?, foto=? WHERE id=?");
        $stmt->bind_param(
            "ssssssddi",
            $data['nama_tk'],
            $data['alamat'],
            $data['deskripsi'],
            $data['kontak'],
            $data['email'],
            $data['latitude'],
            $data['longitude'],
            $data['foto'],
            $id
        );


        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM sekolah_tk WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
