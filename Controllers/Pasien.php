<?php
require_once 'Config/DB.php';

class Pasien
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT * FROM pasien");
        return $stmt;
    }

    public function show($id)
    {
        $stmt = $this->pdo->query("SELECT * FROM pasien WHERE id = $id");
        return $stmt;
    }

    public function create($kode, $nama, $tmp_lahir, $tgl_lahir, $gender, $email, $alamat, $kelurahan_id) 
    {
        $stmt = $this->pdo->prepare("INSERT INTO pasien (kode, nama, tmp_lahir, tgl_lahir, gender, email, alamat, kelurahan_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$kode, $nama, $tmp_lahir, $tgl_lahir, $gender, $email, $alamat, $kelurahan_id]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE pasien SET kode=?, nama=?, tmp_lahir=?, tgl_lahir=?, gender=?, email=?, alamat=?, kelurahan_id=? WHERE id=?");
        return $stmt->execute([$data['kode'],$data['nama'],$data['tmp_lahir'],$data['tgl_lahir'],$data['gender'],$data['email'],$data['alamat'],$data['kelurahan_id'],$id]);
    }

    public function delete($id)
    {
        // Validasi input
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("ID harus berupa angka.");
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM pasien WHERE id = ?");
            $result = $stmt->execute([$id]);

            // Cek apakah ada baris yang terpengaruh
            if ($result && $stmt->rowCount() > 0) {
                return true; // Penghapusan berhasil
            } else {
                return false; // Tidak ada baris yang dihapus (mungkin ID tidak ada)
            }
        } catch (PDOException $e) {
            // Tangani kesalahan PDO
            // Anda bisa mencatat kesalahan atau melempar pengecualian
            throw new Exception("Terjadi kesalahan saat menghapus data: " . $e->getMessage());
        }
    }
}

$pasien = new Pasien($pdo);
