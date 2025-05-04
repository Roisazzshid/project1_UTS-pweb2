<?php
require_once 'Config/DB.php';

class Periksa
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT periksa.*, pasien.nama AS nama_pasien, paramedik.nama AS nama_paramedik
        FROM periksa
        JOIN pasien ON periksa.pasien_id = pasien.id
        JOIN paramedik ON periksa.paramedik_id = paramedik.id");
        return $stmt;
    }

    public function show($id)
    {
        $stmt = $this->pdo->query("SELECT periksa.*, pasien.nama AS nama_pasien, paramedik.nama AS nama_paramedik
        FROM periksa
        JOIN pasien ON periksa.pasien_id = pasien.id
        JOIN paramedik ON periksa.paramedik_id = paramedik.id
        WHERE periksa.id = $id");
        return $stmt;
    }

    public function create($pasien_id, $paramedik_id, $berat, $tinggi, $tensi, $tanggal, $keterangan) 
    {
        $stmt = $this->pdo->prepare("INSERT INTO periksa (pasien_id, paramedik_id, berat, tinggi, tensi, tanggal, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$pasien_id, $paramedik_id, $berat, $tinggi, $tensi, $tanggal, $keterangan]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE periksa SET pasien_id=?, paramedik_id=?, berat=?, tinggi=?, tensi=?, tanggal=?, keterangan=? WHERE id=?");
        return $stmt->execute([$data['pasien_id'],$data['paramedik_id'],$data['berat'],$data['tinggi'],$data['tensi'],$data['tanggal'],$data['keterangan'],$id]);
    }

    public function delete($id)
    {
        // Validasi input
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("ID harus berupa angka.");
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM periksa WHERE id = ?");
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

    public function getPasien()
    {
        $stmt = $this->pdo->query("SELECT * FROM pasien");
        return $stmt;
    }

    public function getParamedik()
    {
        $stmt = $this->pdo->query("SELECT * FROM paramedik");
        return $stmt;
    }
}

$periksa = new Periksa($pdo);
