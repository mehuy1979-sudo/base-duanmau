<?php

class BaseModel
{
    protected $table;
    protected $pdo;

    // Kết nối CSDL
    public function __construct()
    {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);

        try {
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        } catch (PDOException $e) {
            $this->pdo = null;
        }
    }

    public function all()
    {
        if (!$this->pdo || !$this->table) return [];
        try {
            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    public function find($id)
    {
        if (!$this->pdo || !$this->table) return null;
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function create($data)
    {
        if (!$this->pdo || !$this->table || empty($data)) return false;
        try {
            $keys = array_keys($data);
            $fields = implode(', ', $keys);
            $placeholders = ':' . implode(', :', $keys);

            $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data)
    {
        if (!$this->pdo || !$this->table || empty($data)) return false;
        try {
            $set = [];
            foreach (array_keys($data) as $key) {
                $set[] = "{$key} = :{$key}";
            }
            $setString = implode(', ', $set);

            $sql = "UPDATE {$this->table} SET {$setString} WHERE id = :id";
            $data['id'] = $id;

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id)
    {
        if (!$this->pdo || !$this->table) return false;
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Hủy kết nối CSDL
    public function __destruct()
    {
        $this->pdo = null;
    }
}

