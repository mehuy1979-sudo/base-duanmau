<?php

// class ProductController
// {
//     public function index() 
//     {
//         require_once PATH_VIEW . 'product.php';
//     }
// }
class ProductController
{
    public function index()
    {
        $view = 'product';
        require_once PATH_VIEW . 'main.php';
    }
}