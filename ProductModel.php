<?php

class ProductModel extends BaseModel
{
    protected $table = "products";

    public function getAll()
    {
        if (!$this->pdo) return [];
        try {
            $sql = "SELECT p.*, c.category_name,
                    (SELECT COUNT(*) FROM product_variants pv WHERE pv.product_id = p.id) as variant_count
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.id
                    ORDER BY p.id DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getOne($id)
    {
        if (!$this->pdo || empty($id)) return null;
        try {
            $sql = "SELECT p.*, c.category_name 
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.id
                    WHERE p.id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $product = $stmt->fetch() ?: null;
            if ($product) {
                $product['variants'] = $this->getVariants($id);
                $product['images']   = $this->getImages($id);
            }
            return $product;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getRelatedProducts($categoryId, $excludeId = 0, $limit = 4)
    {
        if (!$this->pdo) return [];
        try {
            $sql = "SELECT p.*, c.category_name 
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.id
                    WHERE p.id != :excludeId";
            if ($categoryId) {
                $sql .= " AND p.category_id = :catId";
            }
            $sql .= " ORDER BY p.id DESC LIMIT " . (int)$limit;
            $stmt = $this->pdo->prepare($sql);
            $params = ['excludeId' => $excludeId];
            if ($categoryId) {
                $params['catId'] = $categoryId;
            }
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function insertProduct($data)
    {
        if (!$this->pdo || empty($data)) return false;
        try {
            $keys = array_keys($data);
            $fields = implode(', ', $keys);
            $placeholders = ':' . implode(', :', $keys);

            $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute($data);
            if ($ok) {
                return (int) $this->pdo->lastInsertId();
            }
            return false;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function insert($data)
    {
        return $this->insertProduct($data);
    }

    public function updateProduct($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteProduct($id)
    {
        if (!$this->pdo) return false;
        try {
            $stmtVar = $this->pdo->prepare("DELETE FROM product_variants WHERE product_id = :id");
            $stmtVar->execute(['id' => $id]);

            $stmtImg = $this->pdo->prepare("DELETE FROM product_images WHERE product_id = :id");
            $stmtImg->execute(['id' => $id]);

            return $this->delete($id);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getCategories()
    {
        if (!$this->pdo) return [];
        try {
            $sql = "SELECT * FROM categories ORDER BY id ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getVariants($productId)
    {
        if (!$this->pdo) return [];
        try {
            $sql = "SELECT * FROM product_variants WHERE product_id = :pid ORDER BY id ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['pid' => $productId]);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function saveVariants($productId, array $variants)
    {
        if (!$this->pdo || empty($productId)) return false;
        try {
            $del = $this->pdo->prepare("DELETE FROM product_variants WHERE product_id = :pid");
            $del->execute(['pid' => $productId]);

            if (empty($variants)) {
                return true;
            }

            $sql = "INSERT INTO product_variants (product_id, size, color, original_price, sale_price, quantity, sku)
                    VALUES (:product_id, :size, :color, :original_price, :sale_price, :quantity, :sku)";
            $stmt = $this->pdo->prepare($sql);

            $totalQty = 0;
            $sizes = [];
            $colors = [];
            $minSalePrice = null;
            $minOrigPrice = null;

            foreach ($variants as $v) {
                $size = trim($v['size'] ?? '');
                $rawColor = $v['color'] ?? ($v['colors'] ?? '');
                $origPrice = (float)($v['original_price'] ?? 0);
                $salePrice = (float)($v['sale_price'] ?? 0);
                $qty = (int)($v['quantity'] ?? 0);
                $sku = trim($v['sku'] ?? '');

                $colorList = [];
                if (is_array($rawColor)) {
                    $colorList = $rawColor;
                } elseif (is_string($rawColor) && trim($rawColor) !== '') {
                    $colorList = explode(',', $rawColor);
                }
                $colorList = array_values(array_filter(array_map('trim', $colorList)));

                if (empty($colorList)) {
                    $colorList = [''];
                }

                foreach ($colorList as $color) {
                    if ($size !== '') $sizes[] = $size;
                    if ($color !== '') $colors[] = $color;
                    $totalQty += $qty;

                    if ($minSalePrice === null || ($salePrice > 0 && $salePrice < $minSalePrice)) {
                        $minSalePrice = $salePrice;
                    }
                    if ($minOrigPrice === null || ($origPrice > 0 && $origPrice < $minOrigPrice)) {
                        $minOrigPrice = $origPrice;
                    }

                    $stmt->execute([
                        'product_id'     => $productId,
                        'size'           => $size,
                        'color'          => $color,
                        'original_price' => $origPrice,
                        'sale_price'     => $salePrice,
                        'quantity'       => $qty,
                        'sku'            => $sku ?: null,
                    ]);
                }
            }

            $uniqueSizes = implode(', ', array_unique(array_filter($sizes)));
            $uniqueColors = implode(', ', array_unique(array_filter($colors)));

            $updateData = [
                'sizes'          => $uniqueSizes,
                'colors'         => $uniqueColors,
                'quantity'       => $totalQty,
            ];
            if ($minSalePrice !== null) {
                $updateData['price'] = $minSalePrice;
            }
            if ($minOrigPrice !== null) {
                $updateData['original_price'] = $minOrigPrice;
            }

            $this->update($productId, $updateData);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getImages($productId)
    {
        if (!$this->pdo) return [];
        try {
            $sql = "SELECT * FROM product_images WHERE product_id = :pid ORDER BY id ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['pid' => $productId]);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function saveImages($productId, array $imagePaths)
    {
        if (!$this->pdo || empty($productId) || empty($imagePaths)) return false;
        try {
            $sql = "INSERT INTO product_images (product_id, image) VALUES (:product_id, :image)";
            $stmt = $this->pdo->prepare($sql);
            foreach ($imagePaths as $path) {
                $stmt->execute([
                    'product_id' => $productId,
                    'image'      => $path
                ]);
            }
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}