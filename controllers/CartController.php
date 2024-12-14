<?php
require_once 'models/Product.php';
require_once 'models/Coupon.php';
require_once 'models/Order.php';
require_once 'models/OrderItem.php';

class CartController extends Controller
{
    public function add()
    {
        if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $productModel = new Product();
            $product = $productModel->getProductByIdWithSingleImage($product_id);

            // Debug output for the product
            var_dump($product);

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // $customerId = $_SESSION['user']['id'] ?? null;
            // if ($customerId === null) {
            //      header('Location: /customers/cart?error=not_logged_in');
            //      exit();
            //  }

            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'name' => $product['product_name'],
                    'price' => $product['price'],
                    'image' => $product['image'], // Change to 'image'
                    'quantity' => $quantity
                ];
            }

            header('Location: /customers/cart');
            exit();
        }
    }

    public function remove()
    {
        // Start the session if it's not already started
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Check request method
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['product_id'])) {
                $product_id = $_POST['product_id'];

                if (isset($_SESSION['cart'][$product_id])) {
                    unset($_SESSION['cart'][$product_id]);

                    if (empty($_SESSION['cart'])) {
                        unset($_SESSION['cart']);
                        error_log("Cart is now empty, session cleared.");
                    } else {
                        error_log("Removed product ID: " . $product_id);
                    }
                    http_response_code(200);
                    return; // Successfully removed
                } else {
                    http_response_code(400);
                    exit('Product ID not found in cart.');
                }
            } else {
                http_response_code(400);
                exit('Product ID is required.');
            }
        } else {
            http_response_code(405);
            exit('Method not allowed. Please use POST.');
        }
    }


    public function applyCoupon()
    {
        if (isset($_POST['apply_coupon']) && !empty($_POST['coupon_code'])) {
            $coupon_code = $_POST['coupon_code'];
            $couponModel = new Coupon();
            $coupon = $couponModel->getCouponByCode($coupon_code);
    
            if ($coupon) {
                if (strtotime($coupon['expiration_date']) >= time()) {
                    // Check if usage limit is greater than zero
                    if ($coupon['usage_limit'] > 0) {
                        $_SESSION['discount'] = $coupon['discount'];
                        $_SESSION['success_message'] = 'Coupon applied successfully!';
    
                        // Decrease usage limit by 1
                        $couponModel->decrementUsageLimit($coupon['id']);
    
                        // Save the original usage limit and coupon ID to restore if removed
                        $_SESSION['original_usage_limit'] = $coupon['usage_limit'];
                        $_SESSION['coupon_id'] = $coupon['id'];
                    } else {
                        $_SESSION['error_message'] = 'This coupon has reached its usage limit.';
                    }
                } else {
                    $_SESSION['error_message'] = 'This coupon has expired.';
                }
            } else {
                $_SESSION['error_message'] = 'Invalid coupon code.';
            }
            header('Location: /customers/cart');
            exit();
        }
    }
    

    public function removeCoupon()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    
        // Check if the original usage limit and coupon ID are stored in the session
        if (isset($_SESSION['original_usage_limit']) && isset($_SESSION['coupon_id'])) {
            $couponModel = new Coupon();
    
            // Restore the usage limit by increasing it back by 1
            $couponModel->incrementUsageLimit($_SESSION['coupon_id']);
    
            // Clear the stored limit and coupon ID from the session
            unset($_SESSION['original_usage_limit']);
            unset($_SESSION['coupon_id']);
        }
    
        // Remove the discount and success message from the session
        unset($_SESSION['discount']);
        unset($_SESSION['success_message']);
    
        $_SESSION['success_message'] = 'Coupon removed successfully!';
        header('Location: /customers/cart');
        exit();
    }

    public function checkout()
    {
        $customerId = $_SESSION['user']['id'] ?? null;
        if ($customerId === null) {
             header('Location: /customers/cart?error=not_logged_in');
             exit();
         }
        echo '<pre>';
        echo "POST Data: ";
        print_r($_POST);
        echo "Session Data: ";
        print_r($_SESSION);
        echo '</pre>';
    
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $_SESSION['error_message'] = 'Your cart is empty.';
            header('Location: /customers/cart');
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerId = $_SESSION['user']['id'] ?? null;
    
            // Get address and phone number from POST data
            $address = $_POST['address'] ?? null;
            $phoneNumber = $_POST['phone_number'] ?? null;
    
          // Server-side validation
          if (empty($address) || empty($phoneNumber)) {
            $_SESSION['error_message'] = 'Both address and phone number are required.';
            $_SESSION['show_sweet_alert'] = true; // Set a flag for SweetAlert
            header('Location: /customers/checkout'); // Redirect back to checkout
            exit();
        }
    
            $orderData = [
                'customer_id' => $customerId,
                'order_date' => date('Y-m-d H:i:s'),
                'status' => 'pending',
                'coupon_id' => $_SESSION['discount'] ?? null,
                'total_amount' => $this->calculateTotalAmount(),
                'address' => $address,
                'phone_number' => $phoneNumber,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
    
            $orderModel = new Order();
    
            try {
                $orderId = $orderModel->create($orderData);
                if (empty($orderId)) {
                    throw new Exception("Order creation failed, order ID is NULL.");
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
                exit();
            }
    
            $orderItemModel = new OrderItem();
            foreach ($_SESSION['cart'] as $productId => $product) {
                $orderItemData = [
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity' => $product['quantity'],
                    'price' => $product['price']
                ];
                $orderItemModel->create($orderItemData);
            }
    
            unset($_SESSION['cart']);
            unset($_SESSION['discount']);
    
            header('Location: /customers/thankyou');
            exit();
        }
    
        include '../Ecommerce-website/views/checkout.php';
    }
    
    
    public function calculateTotalAmount()
    {
        $subtotal = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product) {
                $subtotal += $product['price'] * $product['quantity'];
            }
        }
        
        $discountPercentage = $_SESSION['discount'] ?? 0;
        $discountAmount = ($subtotal * $discountPercentage) / 100; // Calculate the discount as a percentage
        return $subtotal - $discountAmount;
    }
    
    public function updateCart() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
    
            if (isset($data['product_id']) && isset($data['action'])) {
                $product_id = $data['product_id'];
                $action = $data['action'];
    
                if (isset($_SESSION['cart'][$product_id])) {
                    if ($action === 'increase') {
                        $_SESSION['cart'][$product_id]['quantity']++;
                    } elseif ($action === 'decrease') {
                        if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
                            $_SESSION['cart'][$product_id]['quantity']--;
                        } else {
                            unset($_SESSION['cart'][$product_id]);
                            echo json_encode(['success' => false, 'message' => 'Product removed from cart']);
                            return;
                        }
                    } else {
                        http_response_code(400);
                        echo json_encode(['success' => false, 'message' => 'Invalid action']);
                        return;
                    }
    
                    // Return the new quantity in the response
                    echo json_encode([
                        'success' => true,
                        'newQuantity' => $_SESSION['cart'][$product_id]['quantity']
                    ]);
                    return;
                } else {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
                    return;
                }
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Product ID and action are required']);
                return;
            }
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed. Please use POST.']);
        }
    }
    
    }
