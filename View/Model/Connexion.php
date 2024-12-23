<?php
class Connexion {
    private $host = 'np16029-001.privatesql';
    private $dbname = 'licence07';
    private $username = 'licence07';
    private $password = 'Q542d20C1a';
    private $port = '35815';
    private PDO $db;

    public function __construct() {
        try {
            $this->db = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getDb(): PDO {
        return $this->db;
    }
}
