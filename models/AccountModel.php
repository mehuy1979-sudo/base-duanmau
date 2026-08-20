<?php

class AccountModel extends BaseModel
{
    protected $table = "users";

    // Vai trò & trạng thái hợp lệ trong hệ thống
    public const ROLES   = ['admin', 'customer'];
    public const STATUSES = ['active', 'locked'];

    /**
     * Danh sách tài khoản có tìm kiếm, lọc theo quyền/trạng thái và phân trang
     */
    public function getList(string $keyword = '', string $role = '', string $status = '', int $page = 1, int $perPage = 8): array
    {
        $where  = [];
        $params = [];

        if ($keyword !== '') {
            $where[] = "(fullname LIKE :keyword OR email LIKE :keyword)";
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
            'items'      => $stmt->fetchAll(),
            'total'      => $total,
            'page'       => $page,
            'per_page'   => $perPage,
            'total_page' => (int) max(1, ceil($total / $perPage)),
        ];
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
        return (int) $this->pdo->query("SELECT COUNT(*) FROM {$this->table} WHERE {$condition}")->fetchColumn();
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

        $newStatus = $account['status'] === 'active' ? 'locked' : 'active';

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

    /**
     * Kiểm tra email đã tồn tại chưa (dùng khi cần, ví dụ mở rộng thêm chức năng)
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Kiểm tra đăng nhập: đúng email + mật khẩu thì trả về bản ghi tài khoản, sai thì trả về false
     */
    public function attemptLogin(string $email, string $password): array|false
    {
        $account = $this->findByEmail($email);

        if (!$account) {
            return false;
        }

        if (!password_verify($password, $account['password'])) {
            return false;
        }

        return $account;
    }

    /**
     * Đăng ký tài khoản mới.
     * Tài khoản đầu tiên của hệ thống sẽ tự động là admin, các tài khoản sau là customer.
     */
    public function register(array $data): int
    {
        $role = $this->count() === 0 ? 'admin' : 'customer';

        return $this->create([
            'fullname' => $data['fullname'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => $role,
            'status'   => 'active',
        ]);
    }
}
