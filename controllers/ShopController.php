<?php

class ShopController extends Controller
{
    public function liveSearch()
    {
        $query = $_GET['query'] ?? '';

        // Redirect to shop.php if search query is empty
        if (empty($query)) {
            header("Location: /shop.php");
            exit;
        }

        $productModel = $this->model('Product');
        $results = $productModel->searchProducts($query);

        // Limit the number of products to display (8 products for 2 rows)
        $maxProductsToShow = 8;
        $productCount = 0;

        if (!empty($results)) {
            echo "<div class='row'>";
            foreach ($results as $product) {
                // Check if we have reached the maximum number of products to show
                if ($productCount >= $maxProductsToShow) {
                    break; // Exit the loop if the limit is reached
                }

                $imageUrl = isset($product['image_url']) && !empty($product['image_url'])
                    ? '/public/' . $product['image_url']
                    : '/public/images/default-product.png';

                echo "
                    <div class='col-6 col-md-4 col-lg-3 mb-4 d-flex align-items-stretch'>
                        <a class='product-item d-block text-center' href='/customers/product_details/{$product['id']}'>
                            <img src='{$imageUrl}' class='img-fluid product-thumbnail' alt='" . htmlspecialchars($product['product_name']) . "'>
                            <h3 class='product-title mt-2'><b>" . ucwords(str_replace(['-', '_'], ' ', $product['product_name'])) . "</b></h3>
                            <strong class='product-price'><sup>JD</sup> {$product['price']}</strong>
                            <span class='icon-cross'>
                                    <img src='../public/images/cross.svg' class='img-fluid'>
                            </span>
                        </a>
                    </div>";

                $productCount++;
            }
            echo "</div>";
        } else {
            echo "<p class='text-center'>No products found for your search.</p>";
        }
    }
}