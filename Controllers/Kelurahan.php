<?php
require_once 'Config/DB.php';

class Kelurahan
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT * FROM kelurahan");
        return $stmt;
    }

}

$kelurahan = new Kelurahan($pdo);
