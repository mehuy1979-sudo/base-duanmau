<?php

class ProductController 
{
    private $productModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        // Tổng hợp tất cả các tham số lọc từ phương thức GET
        $filters = [
            'category' => $_GET['category'] ?? null,
            'sort'     => $_GET['sort'] ?? ($_GET['sort_price'] ?? null),
            'keyword'  => trim($_GET['keyword'] ?? ($_GET['search-product'] ?? ''))
        ];
        
        $products = $this->productModel->getFilteredProducts($filters);
        
        // Gọi View hiển thị
        require_once PATH_VIEW . 'product.php';
    }

    public function search()
    {
        $view = 'search';
        $orderBy = 'asc';

        if (isset($_POST['sort_price'])) {
            $orderBy = $_POST['sort_price'];
        }

        if (isset($_POST['keyword'])) {
            $listproduct = $this->productModel->getproductByKey($_POST['keyword'], $orderBy);
        }

        require_once PATH_VIEW . 'search.php';
    }
}