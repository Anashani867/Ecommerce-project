<?php

require_once '../Ecommerce-website/models/WishList.php';  // Include the Wishlist model

class WishlistController extends Controller {

    public function __construct() {
       // session_start(); // Start the session if not already started
    }
    public function add() {
        // Check if the user is logged in
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /customers/login_and_register');
            exit();
        }
    
        // Get the product ID from the request
        $productId = $_POST['product_id'] ?? null;
    
        if ($productId) {
            $customerId = $_SESSION['user']['id']; 
            $wishlistModel = new Wishlist();
            $success = $wishlistModel->addToWishlist($customerId, $productId);
    
            // Set success or error message in session
            if ($success) {
                // Update the session wishlist array
                $_SESSION['wishlists'][] = $productId; // Add the new product ID to the wishlist session array
    
                $_SESSION['wishlist_message'] = ['type' => 'success', 'text' => 'Product added to wishlist.'];
            } else {
                $_SESSION['wishlist_message'] = ['type' => 'error', 'text' => 'Product is already in wishlist.'];
            }
            
            // Redirect to the referring page (where the add to wishlist request came from)
            $referer = $_SERVER['HTTP_REFERER'] ?? '/'; // Default to home if no referer
            header('Location: ' . $referer);
            exit();
        } else {
            $_SESSION['wishlist_message'] = ['type' => 'error', 'text' => 'Invalid product ID.'];
            header('Location: /customers/profile'); // Redirect with error to profile
            exit();
        }
    }
    
    public function viewWishlist() {
        // Check if the user is logged in
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /customers/login_and_register');
            exit();
        }

        // Retrieve the customer ID from the session
        $customerId = $_SESSION['user']['id'];
        $wishlistModel = new Wishlist();
        $wishlistItems = $wishlistModel->getWishlistItems($customerId); // Fetch wishlist items

        // Pass the wishlist items to the view
        $this->view('customers/profile', ['wishlistItems' => $wishlistItems]);
    }
    public function remove() {
        // Check if the user is logged in
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /customers/login_and_register');
            exit();
        }

        // Get the product ID from the form submission
        $productId = $_POST['product_id'] ?? null;

        if ($productId) {
            $wishlistModel = new Wishlist();
            $result = $wishlistModel->removeItem($productId); // Remove the item from the wishlist

            if ($result) {
                // Check if the session wishlist exists and is an array
                if (isset($_SESSION['wishlists']) && is_array($_SESSION['wishlists'])) {
                    // Remove the product ID from the session wishlist array
                    if (($key = array_search($productId, $_SESSION['wishlists'])) !== false) {
                        unset($_SESSION['wishlists'][$key]); // Remove the product ID from the array
                    }
                }

                $_SESSION['wishlist_message'] = ['type' => 'success', 'text' => 'Item removed from wishlist.'];
            } else {
                $_SESSION['wishlist_message'] = ['type' => 'error', 'text' => 'Failed to remove item. Please try again.'];
            }
        } else {
            $_SESSION['wishlist_message'] = ['type' => 'error', 'text' => 'Invalid product ID.'];
        }

        // Redirect to profile page
        header('Location: /customers/profile');
        exit();
    }

}
