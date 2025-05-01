<?php
require_once 'Config/DB.php';

class Prodi
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT * FROM prodi");
        return $stmt;
    }

    public function show($id)
    {
        $stmt = $this->pdo->query("SELECT * FROM prodi WHERE id = $id");
        return $stmt;
    }

    public function create($kode, $nama, $kaprodi) 
    {
        $stmt = $this->pdo->prepare("INSERT INTO prodi (kode, nama, kaprodi) VALUES (?, ?, ?)");
        return $stmt->execute([$kode, $nama, $kaprodi]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE prodi SET kode=?,nama=?,kaprodi=? WHERE id=?");
        return $stmt->execute([$data['kode'],$data['nama'],$data['kaprodi'],$id]);
    }

    public function delete($id)
    {
        // Validasi input
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("ID harus berupa angka.");
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM prodi WHERE id = ?");
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

$prodi = new Prodi($pdo);
