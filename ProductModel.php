<?php

class ProductController
{
    public function index()
    {
        // Khởi tạo ProductModel
        $productModel = new ProductModel();

        // Lấy toàn bộ sản phẩm
        $products = $productModel->getAll();

        // Gọi giao diện
        require_once PATH_VIEW . 'product.php';
    }
}