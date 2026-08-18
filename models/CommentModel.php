<?php

class CommentModel extends BaseModel
{

    /**
     * Lấy danh sách bình luận theo đúng cấu trúc bảng comments:
     * id, user_id, product_id, content, rating, is_locked, created_at.
     */
    public function getAll($keyword = '', $status = '', $page = 1, $perPage = 10)
    {
        if (!$this->isConnected()) {
            throw new RuntimeException('Không thể kết nối cơ sở dữ liệu.');
        }

        $where = [];
        $params = [];

        if ($keyword !== '') {
            $where[] = '(c.content LIKE :keyword OR u.fullname LIKE :keyword OR p.product_name LIKE :keyword)';
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if ($status === 'active') {
            $where[] = 'c.is_locked = 0';
        } elseif ($status === 'locked') {
            $where[] = 'c.is_locked = 1';
        }

        $whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';

        $countSql = "SELECT COUNT(*)
                     FROM comments c
                     LEFT JOIN users u ON u.id = c.user_id
                     LEFT JOIN products p ON p.id = c.product_id
                     {$whereSql}";
        $countStmt = $this->pdo->prepare($countSql);
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT
                    c.id,
                    c.user_id,
                    c.product_id,
                    c.content,
                    c.rating,
                    c.is_locked,
                    c.created_at,
                    u.fullname AS user_name,
                    u.email AS user_email,
                    p.product_name AS product_name
                FROM comments c
                LEFT JOIN users u ON u.id = c.user_id
                LEFT JOIN products p ON p.id = c.product_id
                {$whereSql}
                ORDER BY c.created_at DESC, c.id DESC
                LIMIT {$perPage} OFFSET {$offset}";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($items as &$item) {
            $item['normalized_status'] = ((int) $item['is_locked'] === 1) ? 'locked' : 'active';
        }

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'pages' => max(1, (int) ceil($total / $perPage)),
        ];
    }

    public function find($id)
    {
        if (!$this->isConnected()) {
            throw new RuntimeException('Không thể kết nối cơ sở dữ liệu.');
        }

        $sql = "SELECT
                    c.id,
                    c.user_id,
                    c.product_id,
                    c.content,
                    c.rating,
                    c.is_locked,
                    c.created_at,
                    u.fullname AS user_name,
                    u.email AS user_email,
                    p.product_name AS product_name
                FROM comments c
                LEFT JOIN users u ON u.id = c.user_id
                LEFT JOIN products p ON p.id = c.product_id
                WHERE c.id = ?
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([(int) $id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$item) {
            return null;
        }

        $item['normalized_status'] = ((int) $item['is_locked'] === 1) ? 'locked' : 'active';
        return $item;
    }

    /**
     * Khóa/mở khóa bằng cột comments.is_locked.
     * 0 = đang hiển thị, 1 = đã khóa.
     */
    public function setLocked($id, $locked)
    {
        if (!$this->isConnected()) {
            throw new RuntimeException('Không thể kết nối cơ sở dữ liệu.');
        }

        $stmt = $this->pdo->prepare(
            'UPDATE comments SET is_locked = ? WHERE id = ?'
        );

        return $stmt->execute([
            $locked ? 1 : 0,
            (int) $id,
        ]);
    }

    public function getStats()
    {
        if (!$this->isConnected()) {
            throw new RuntimeException('Không thể kết nối cơ sở dữ liệu.');
        }

        $stmt = $this->pdo->query(
            'SELECT
                COUNT(*) AS total,
                SUM(CASE WHEN is_locked = 0 THEN 1 ELSE 0 END) AS active,
                SUM(CASE WHEN is_locked = 1 THEN 1 ELSE 0 END) AS locked
             FROM comments'
        );

        $stats = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        return [
            'total' => (int) ($stats['total'] ?? 0),
            'active' => (int) ($stats['active'] ?? 0),
            'locked' => (int) ($stats['locked'] ?? 0),
        ];
    }
}
