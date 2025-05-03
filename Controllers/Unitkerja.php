<?php
require_once 'Config/DB.php';

class Unitkerja
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT * FROM unit_kerja");
        return $stmt;
    }

}

$unitkerja = new Unitkerja($pdo);

?>
