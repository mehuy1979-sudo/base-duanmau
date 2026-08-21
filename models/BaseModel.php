<?php

class BaseModel
{
    protected $table;
    protected $pdo;
    protected $connected = false;

    // Kết nối CSDL (dùng chung 1 kết nối PDO của toàn hệ thống)
    public function __construct()
    {
        try {
            if (class_exists('Database')) {
                $this->pdo = Database::getConnection();
            } else {
                $dsn = sprintf("mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4", DB_HOST, DB_PORT, DB_NAME);
                $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
            }
            $this->connected = ($this->pdo !== null);
        } catch (PDOException $e) {
            $this->pdo = null;
            $this->connected = false;
        }
    }

    // Kiểm tra đã kết nối CSDL thành công hay chưa
    protected function isConnected(): bool
    {
        return $this->connected && $this->pdo !== null;
    }

    // Lấy toàn bộ bản ghi
    public function all($orderBy = 'id DESC')
    {
        if (!$this->pdo || !$this->table) return [];
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
            $stmt = $this->pdo->query($sql);
            return $stmt ? $stmt->fetchAll() : [];
        } catch (PDOException $e) {
            return [];
        }
    }

    // Tìm 1 bản ghi theo khóa chính
    public function find($id)
    {
        if (!$this->pdo || !$this->table) return null;
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch();
            return $row ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Thêm mới bản ghi, trả về id vừa tạo
    public function create(array $data)
    {
        if (!$this->pdo || !$this->table || empty($data)) return false;
        try {
            $columns = array_keys($data);
            $placeholders = array_map(fn($c) => ':' . $c, $columns);

            $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") "
                 . "VALUES (" . implode(', ', $placeholders) . ")";

            $stmt = $this->pdo->prepare($sql);

            $params = [];
            foreach ($data as $key => $value) {
                $params[':' . $key] = $value;
            }
            $stmt->execute($params);

            return (int) $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Cập nhật bản ghi theo khóa chính
    public function update($id, array $data)
    {
        if (!$this->pdo || !$this->table || empty($data)) return false;
        try {
            $sets = [];
            $params = [':id' => $id];

            foreach ($data as $key => $value) {
                $sets[] = "{$key} = :{$key}";
                $params[':' . $key] = $value;
            }

            $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa bản ghi theo khóa chính
    public function delete($id)
    {
        if (!$this->pdo || !$this->table) return false;
        try {
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Đếm tổng số bản ghi
    public function count()
    {
        if (!$this->pdo || !$this->table) return 0;
        try {
            return (int) $this->pdo->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    // Hủy kết nối CSDL
    public function __destruct()
    {
        $this->pdo = null;
    }
}