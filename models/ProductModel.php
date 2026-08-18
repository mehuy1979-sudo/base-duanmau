
<?php

class ProductModel extends BaseModel
{
    public function find($id)
    {
        if (!$this->isConnected()) {
            return $this->getFallbackProduct($id);
        }

        try {
            $sql = "SELECT * FROM products WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            return $product ?: $this->getFallbackProduct($id);
        } catch (PDOException $e) {
            return $this->getFallbackProduct($id);
        }
    }

    private function getFallbackProduct($id)
    {
        return [
            'id' => (int) $id,
            'name' => 'Lightweight Jacket',
            'price' => 29.99,
            'description' => 'Áo khoác thời trang nam.',
            'image' => null,
        ];
    }
    // protected $table = "products";

    // public function getAll()
    // {
    //     return $this->all();
    // }

    // public function getOne($id)
    // {
    //     return $this->find($id);
    // }

    // public function insert($data)
    // {
    //     return $this->create($data);
    // }

    // public function updateProduct($id, $data)
    // {
    //     return $this->update($id, $data);
    // }

    // public function deleteProduct($id)
    // {
    //     return $this->delete($id);
    // }
}



    
