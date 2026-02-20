<?php

namespace Login\Database;

use mysqli;

class DBConnection
{
    private static $instance = null;
    private $conn;

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "senac";

    private function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die('Não foi possível conectar ao Banco de Dados: ' . $this->conn->connect_error);
        }
    }

    public static function getConnection(): mysqli
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance->conn;
    }

    private function __clone() {}
}
