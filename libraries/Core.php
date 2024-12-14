<?php

class Core
{
    protected $routes = [
        // Default route to customer index
        '' => ['CustomerController@index', 'GET'],
//        'customers/rania'=>['RaniaController@Hello',['GET']],

        // Admin Routes
        'admin/login' => ['AdminController@login', ['GET', 'POST']],
        'admin/rest_password' => ['AdminController@restPassword', ['GET', 'POST']],
        'admin/dashboard' => ['AdminController@dashboard', 'GET'],
        'admin/manage_category' => ['AdminController@manageCategory', 'GET'],
        'admin/manage_products' => ['AdminController@manageProducts', 'GET'],
        'admin/manage_orders' => ['AdminController@manageOrders', 'GET'],
        'admin/manage_customers' => ['AdminController@manageCustomers', ['POST', 'GET']],
        'admin/manage_coupon' => ['AdminController@manageCoupon', 'GET'],
        'admin/coupon_create' => ['AdminController@createCoupon', ['POST', 'GET']],
        'admin/coupon_edit' => ['AdminController@editCoupon', 'GET'], // Specify POST for updates
        'admin/coupon_update' => ['AdminController@updateCoupon', 'POST'], // Specify POST for updates
        'admin/deleteCoupon' => ['AdminController@deleteCoupon', ['GET', 'POST']],
        'admin/messages' => ['AdminController@messages', 'GET'],
        'admin/account_settings' => ['AdminController@accountSettings', ['GET', 'POST']],
        'admin/logout' => ['AdminController@logout', 'GET'],
        'admin/product_create' => ['AdminController@createProduct', ['POST', 'GET']],
        'admin/product_edit' => ['AdminController@editProduct', 'GET'], // Specify POST for updates
        'admin/product_update' => ['AdminController@updateProduct', 'POST'], // Specify POST for updates
        'admin/deleteProduct' => ['AdminController@deleteProduct', ['GET', 'POST']],
        'admin/category_create' => ['AdminController@createCategory', ['POST', 'GET']],
        'admin/category_view' => ['AdminController@viewCategory', 'GET'],
        'admin/category_edit' => ['AdminController@editCategory', 'GET'], // Specify POST for updates
        'admin/category_update' => ['AdminController@updateCategory', 'POST'], // Specify POST for updates
        'admin/deleteCategory' => ['AdminController@deleteCategory', ['GET', 'POST']],
        'admin/customer_edit' => ['AdminController@editCustomer', 'GET', 'GET'], // Specify POST for updates
        'admin/Review' => ['AdminController@manageReviews', 'GET'],
        'admin/deleteReview' => ['AdminController@removeReviewAdmin', 'POST'],
        'admin/rejectReview' => ['AdminController@rejectReviewAdmin', 'POST'], // Route for rejecting a review
        'admin/acceptReview' => ['AdminController@acceptReviewAdmin', 'POST'],
        'admin/customer_update' => ['AdminController@updateCustomer', 'POST', 'GET'], // Specify POST for updates
        'admin/customer_create' => ['AdminController@createCustomer', ['POST', 'GET']],
        'admin/deleteCustomer' => ['AdminController@deleteCustomer', ['GET', 'POST']],
        'admin/manage_testimonials' => ['AdminController@displayTestimonials', ['GET', 'POST']],
        'admin/Coupon' => ['AdminController@manageCoupons', 'GET'],
        'admin/CouponDelete' => ['AdminController@CouponDelete', 'POST'],
        'admin/addCoupon' => ['AdminController@addCoupon', 'POST'],
        'admin/changeOrderStatus' => ['AdminController@changeOrderStatus', 'POST'],


        'admin/super_manage_admin' => ['AdminController@manageAdmin', ['GET', 'POST']],
        'admin/add_admin' => ['AdminController@addAdmin', ['GET', 'POST']],
        'admin/delete_admin' => ['AdminController@deleteAdmin', ['GET', 'POST']],

        // Customer Routes
        'customers/login_and_register' => ['CustomerController@login', ['GET', 'POST']],
        'customers/rest_password' => ['CustomerController@restPassword', ['GET', 'POST']],
        'customers/index' => ['CustomerController@index', 'GET'],
        'customers/about' => ['CustomerController@about', 'GET'],
        'customers/contact' => ['CustomerController@contact', ['GET', 'POST']],
        'customers/category' => ['CustomerController@categoryView', 'GET'],
        'customers/shop' => ['CustomerController@shop', 'GET'],
        'customers/product_details' => ['CustomerController@productDetails', ['GET', 'POST']],
        'customers/cart' => ['CustomerController@cart', 'GET'],
        'customers/checkout' => ['CustomerController@checkout', 'GET'],
        'customers/profile' => ['CustomerController@profile', 'GET'],
        'customers/logout' => ['CustomerController@logout', 'GET'],
        'customer/cart' => ['CartController@add', 'POST'],
        'customers/test' => ['CustomerController@test', 'GET'],
        'customers/cart/checkout' => ['CartController@checkout', 'POST'],
        'customers/cart/remove' => ['CartController@remove', ['POST', 'GET']],
        'customers/cart/remove-coupon' => ['CartController@removeCoupon', 'POST'],
        'customers/cart/apply-coupon' => ['CartController@applyCoupon', 'POST'],
        'customer/profile/add' => ['WishlistController@add', ['POST']],
        'customers/profile/remove' => ['WishlistController@remove', 'POST'],
        'customers/profile/view' => ['WishlistController@viewWishlist', 'GET'],
        'customers/profile/update' => ['CustomerController@updateProfile', ['POST']],
        'profile/uploadImage' => ['CustomerController@uploadImage', 'POST'],
        'shop/liveSearch' => ['ShopController@liveSearch', 'GET'],
        'customers/thankyou' => ['CustomerController@thankYou', 'GET'],
        'customers/profile/cancelOrder' => ['CustomerController@cancelOrder', ['POST']],
        'customers/cart/update' => ['CartController@updateCart', ['POST']],
        'chatbot/respond'=>['ChatbotController@respond',['POST']],
        
        
    ];

    public function __construct()
    {
        $this->dispatch();
    }

    private function dispatch()
    {
        $url = $this->getUrl();
        $method = $_SERVER['REQUEST_METHOD']; // Get the current request method

        // Split URL into parts
        $urlParts = explode('/', $url);
        $lastPart = end($urlParts);

        // Determine route path and optional ID
        if (ctype_digit($lastPart)) {
            $id = $lastPart;
            $routePath = implode('/', array_slice($urlParts, 0, -1)); // Remove last part for route path
        } else {
            $routePath = $url; // Use full URL as route path
            $id = null;         // No ID
        }

        if (isset($this->routes[$routePath])) {
            $route = $this->routes[$routePath];
            $controllerMethod = explode('@', $route[0]);
            $controllerName = $controllerMethod[0];
            $methodName = $controllerMethod[1];
            $routeMethod = $route[1] ?? 'GET'; // Default to GET if no method is specified
            $controllers = isset($urlParts[1]) ? $urlParts[1] : null;

            // Check if route allows the request method
            if ((is_array($routeMethod) && in_array($method, $routeMethod)) || $method === $routeMethod) {
                if (file_exists('controllers/' . $controllerName . '.php')) {
                    require_once 'controllers/' . $controllerName . '.php';
                    $controller = new $controllerName;

                    if (method_exists($controller, $methodName)) {
                        // Call the method with or without ID
                        if ($id !== null) {
                            $controller->$methodName($id);
                        } else {
                            $controller->$methodName();
                        }
                        return;
                    } else {
                        die("ERROR: Method $methodName not found in $controllerName.");
                    }
                } else {
                    die("ERROR: Controller $controllerName not found.");
                }
            } else {
                die("ERROR: Method not allowed for URL '$url'. Expected $routeMethod.");
            }
        } else {
            die("ERROR: Route not found for URL '$url' and method $method.");
        }
    }

    private function getUrl()
    {
        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $url = trim($url, '/');  // Trim leading and trailing slashes

        if (strpos($url, '?') !== false) {
            $url = strstr($url, '?', true);  // Remove query strings for clean URL
        }

        return $url;
    }
}