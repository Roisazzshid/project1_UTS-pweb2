<?php
require_once 'Config/DB.php';

class Admin
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT * FROM admin");
        return $stmt;
    }

    public function show($id)
    {
        $stmt = $this->pdo->query("SELECT * FROM admin WHERE id = $id");
        return $stmt;
    }

    public function create($email, $password, $nama, $level) 
    {
        $stmt = $this->pdo->prepare("INSERT INTO admin (email, password, nama, level) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$email, $password, $nama, $level]);
    }

}

$admin = new Admin($pdo);
