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
        $stmt = $this->pdo->query("SELECT * FROM unitkerja");
        return $stmt;
    }

}

$unitkerja = new Unitkerja($pdo);

?>
