<?php
require_once 'Config/DB.php';

class Mahasiswa
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT * FROM mahasiswa");
        return $stmt;
    }

    public function show($nim)
    {
        $stmt = $this->pdo->query("SELECT * FROM mahasiswa WHERE nim = $nim");
        return $stmt;
    }

    public function create($nim, $nama, $tmp_lahir, $tgl_lahir, $email, $thn_masuk, $sks_lulus, $ipk, $prodi_id) 
    {
        $stmt = $this->pdo->prepare("INSERT INTO mahasiswa (nim, nama, tmp_lahir, tgl_lahir, email, thn_masuk, sks_lulus, ipk, prodi_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nim, $nama, $tmp_lahir, $tgl_lahir, $email, $thn_masuk, $sks_lulus, $ipk, $prodi_id]);
    }

    public function update($nim, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE mahasiswa SET nama=?, tmp_lahir=?, tgl_lahir=?, email=?, thn_masuk=?, sks_lulus=?, ipk=?, prodi_id=? WHERE nim=?");
        return $stmt->execute([$data['nim'],$data['nama'],$data['tmp_lahir'],$data['tgl_lahir'],$data['email'],$data['thn_masuk'],$data['sks_lulus'],$data['ipk'],$data['prodi_id'],$nim]);
    }

    public function delete($nim)
    {
        // Validasi input
        if (!is_numeric($nim)) {
            throw new InvalidArgumentException("ID harus berupa angka.");
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM mahasiswa WHERE nim = ?");
            $result = $stmt->execute([$nim]);

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

$mahasiswa = new Mahasiswa($pdo);
