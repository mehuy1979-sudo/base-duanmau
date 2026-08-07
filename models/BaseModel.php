<?php

class BaseModel
{
    protected $table;
    protected $pdo;
    protected $connected = false;

    // Kết nối CSDL
    public function __construct()
    {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);

        try {
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
            $this->connected = true;
        } catch (PDOException $e) {
            $this->pdo = null;
            $this->connected = false;
        }
    }

    protected function isConnected()
    {
        return $this->connected && $this->pdo !== null;
    }

    // Hủy kết nối CSDL
    public function __destruct()
    {
        $this->pdo = null;
    }
}
