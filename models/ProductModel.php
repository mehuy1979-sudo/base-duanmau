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
            'description' => 'This is a sample product description shown because the database is currently unavailable.',
            'image' => null,
        ];
    }
}
