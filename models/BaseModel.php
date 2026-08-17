<?php

class BaseModel
{
    protected $table;
    protected $pdo;

    // Kết nối CSDL (dùng chung 1 kết nối PDO của toàn hệ thống)
    public function __construct()
    {
        try {
            $this->pdo = Database::getConnection();
        } catch (PDOException $e) {
            // Xử lý lỗi kết nối
            die("Kết nối cơ sở dữ liệu thất bại: {$e->getMessage()}. Vui lòng thử lại sau.");
        }
    }

    // Lấy toàn bộ bản ghi
    public function all($orderBy = 'id DESC')
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        return $this->pdo->query($sql)->fetchAll();
    }

    // Tìm 1 bản ghi theo khóa chính
    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    // Thêm mới bản ghi, trả về id vừa tạo
    public function create(array $data)
    {
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
    }

    // Cập nhật bản ghi theo khóa chính
    public function update($id, array $data)
    {
        $sets = [];
        $params = [':id' => $id];

        foreach ($data as $key => $value) {
            $sets[] = "{$key} = :{$key}";
            $params[':' . $key] = $value;
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // Xóa bản ghi theo khóa chính
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Đếm tổng số bản ghi
    public function count()
    {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }

    // Hủy kết nối CSDL
    public function __destruct()
    {
        $this->pdo = null;
    }
}
