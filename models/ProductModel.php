<?php

class ProductModel extends BaseModel 
{
    protected $table = "products";

    public function getproductByKey($keyword, $orderBy = 'ASC')
    {
        // Chống SQL Injection bằng cách validate chiều sắp xếp
        $direction = strtoupper($orderBy) === 'DESC' ? 'DESC' : 'ASC';
        $sql = "SELECT * FROM products WHERE product_name LIKE :keyword ORDER BY price {$direction}";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFilteredProducts($filters = []) 
    {
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];
        
        // 1. Lọc theo danh mục (nếu có)
        if (!empty($filters['category'])) {
            $sql .= " AND category_id = :category";
            $params['category'] = $filters['category'];
        }
        
        // 2. Lọc theo từ khóa tìm kiếm tên sản phẩm
        if (!empty($filters['keyword'])) {
            $sql .= " AND product_name LIKE :keyword";
            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }
        
        // 3. Sắp xếp (Sort By / Sort Price)
        $sort = $filters['sort'] ?? ($filters['sort_price'] ?? '');
        if (!empty($sort)) {
            switch ($sort) {
                case 'price-asc':
                case 'asc':
                    $sql .= " ORDER BY price ASC";
                    break;
                case 'price-desc':
                case 'desc':
                    $sql .= " ORDER BY price DESC";
                    break;
                case 'newest':
                default:
                    $sql .= " ORDER BY id DESC";
                    break;
            }
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        return $this->all();
    }

    public function getOne($id)
    {
        return $this->find($id);
    }

    public function insert($data)
    {
        return $this->create($data);
    }

    public function updateProduct($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteProduct($id)
    {
        return $this->delete($id);
    }
}