<?php

class ProductController
{
    public function detail()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $id = 1;
        }

        $productModel = new ProductModel();
        $product = $productModel->find((int) $id);

        if (empty($product)) {
            $product = [
                'id' => (int) $id,
                'name' => 'Demo Product',
                'price' => 29.99,
                'description' => 'This is a sample product description shown because the database is currently unavailable.',
                'image' => null,
            ];
        }

        require PATH_VIEW . 'product/detail.php';
    }
}
