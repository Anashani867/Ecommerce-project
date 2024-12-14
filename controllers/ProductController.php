<?php

class ProductController extends Controller
{
    public function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
        $max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 1000;
        $category_id = isset($_GET['id']) ? $_GET['id'] : null;

        $productsPerPage = 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $productsPerPage;

        $results = $this->model ('Product') ->getProducts($search, $min_price, $max_price, $category_id, $offset, $productsPerPage);
        $totalProducts = $this->model ('Product')->getTotalProducts($search, $min_price, $max_price);
        $totalPages = ceil($totalProducts / $productsPerPage);

        require 'views/customers/shop.php';
    }
}