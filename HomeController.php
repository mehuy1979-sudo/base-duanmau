<?php

class HomeController
{
    public function index() 
    {
        $title = "Trang chủ - CozaStore";
        $productModel = new ProductModel();
        $products = $productModel->getAll();
        $categories = $productModel->getCategories();

        require_once PATH_VIEW . 'main.php';
    }
}