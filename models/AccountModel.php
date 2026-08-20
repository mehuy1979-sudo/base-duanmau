<?php

class AccountModel extends BaseModel
{
    protected $table = "users";

    // Vai trò & trạng thái hợp lệ trong hệ thống
    public const ROLES   = ['admin', 'customer'];
    public const STATUSES = ['active', 'locked'];

    /**
     * Xác thực đăng nhập
     */
    public function attemptLogin(string $email, string $password): ?array
    {
        $account = $this->findByEmail($email);
        if (!$account) {
            return null;
        }

        $storedPassword = (string)($account['password'] ?? '');

        // Kiểm tra mật khẩu mã hóa bcrypt hoặc mật khẩu thuần (hỗ trợ dữ liệu mẫu cũ)
        $isMatch = password_verify($password, $storedPassword) || ($password === $storedPassword);

        if ($isMatch) {
            // Tự động nâng cấp mật khẩu lên hash bcrypt nếu đang là plain-text
            if ($password === $storedPassword && password_needs_rehash($storedPassword, PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $this->update($account['id'], ['password' => $newHash]);
                $account['password'] = $newHash;
            }
            return $account;
        }

        return null;
    }

    /**
     * Đăng ký tài khoản mới
     */
    public function register(array $data)
    {
        if (!$this->pdo || empty($data)) return false;

        $hashedPassword = password_hash((string)($data['password'] ?? ''), PASSWORD_DEFAULT);

        $insertData = [
            'fullname'   => trim($data['fullname'] ?? ''),
            'email'      => strtolower(trim($data['email'] ?? '')),
            'phone'      => trim($data['phone'] ?? ''),
            'password'   => $hashedPassword,
            'role'       => $data['role'] ?? 'customer',
            'status'     => $data['status'] ?? 'active',
        ];

        return $this->create($insertData);
    }

    /**
     * Kiểm tra email đã tồn tại chưa (không phân biệt chữ hoa/thường)
     */
    public function findByEmail(string $email): ?array
    {
        if (!$this->pdo) return null;
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE LOWER(email) = LOWER(:email) LIMIT 1");
            $stmt->execute([':email' => trim($email)]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    /**
     * Danh sách tài khoản có tìm kiếm, lọc theo quyền/trạng thái và phân trang
     */
    public function getList(string $keyword = '', string $role = '', string $status = '', int $page = 1, int $perPage = 8): array
    {
        if (!$this->pdo) return ['items' => [], 'total' => 0, 'page' => 1, 'per_page' => $perPage, 'total_page' => 1];

        $where  = [];
        $params = [];

        if ($keyword !== '') {
            $where[] = "(fullname LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword)";
            $params[':keyword'] = "%{$keyword}%";
        }

        if (in_array($role, self::ROLES, true)) {
            $where[] = "role = :role";
            $params[':role'] = $role;
        }

        if (in_array($status, self::STATUSES, true)) {
            $where[] = "status = :status";
            $params[':status'] = $status;
        }

        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

        try {
            // Đếm tổng số bản ghi phù hợp điều kiện lọc
            $countStmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->table} {$whereSql}");
            $countStmt->execute($params);
            $total = (int) $countStmt->fetchColumn();

            $page    = max(1, $page);
            $perPage = max(1, $perPage);
            $offset  = ($page - 1) * $perPage;

            $sql = "SELECT * FROM {$this->table} {$whereSql} ORDER BY id DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return [
                'items'      => $stmt->fetchAll(PDO::FETCH_ASSOC),
                'total'      => $total,
                'page'       => $page,
                'per_page'   => $perPage,
                'total_page' => (int) max(1, ceil($total / $perPage)),
            ];
        } catch (\PDOException $e) {
            return ['items' => [], 'total' => 0, 'page' => 1, 'per_page' => $perPage, 'total_page' => 1];
        }
    }

    /**
     * Chi tiết 1 tài khoản
     */
    public function getById(int $id): ?array
    {
        return $this->find($id);
    }

    /**
     * Thống kê nhanh cho các thẻ tổng quan (tổng số, đang hoạt động, bị khóa, admin)
     */
    public function getStats(): array
    {
        return [
            'total'    => $this->count(),
            'active'   => $this->countByCondition("status = 'active'"),
            'locked'   => $this->countByCondition("status = 'locked'"),
            'admin'    => $this->countByCondition("role = 'admin'"),
        ];
    }

    private function countByCondition(string $condition): int
    {
        if (!$this->pdo) return 0;
        try {
            return (int) $this->pdo->query("SELECT COUNT(*) FROM {$this->table} WHERE {$condition}")->fetchColumn();
        } catch (\PDOException $e) {
            return 0;
        }
    }

    /**
     * Khóa / Mở khóa tài khoản (đảo trạng thái hiện tại)
     */
    public function toggleLock(int $id): ?string
    {
        $account = $this->getById($id);

        if (!$account) {
            return null;
        }

        $newStatus = ($account['status'] ?? 'active') === 'active' ? 'locked' : 'active';

        $this->update($id, ['status' => $newStatus]);

        return $newStatus;
    }

    /**
     * Sửa quyền tài khoản: admin / customer
     */
    public function changeRole(int $id, string $role): bool
    {
        if (!in_array($role, self::ROLES, true)) {
            return false;
        }

        $account = $this->getById($id);

        if (!$account) {
            return false;
        }

        return (bool) $this->update($id, ['role' => $role]);
    }
}
