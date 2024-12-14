<?php

class CustomerController extends Controller
{

    // Customer login & registration
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formType = $_POST['form_type'];

            if ($formType === 'signup') {
                $data = [
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone_number'],
                    'password' => $_POST['password'],
                    'confirm_password' => $_POST['confirm_password'],
                    'address' => $_POST['address'],
                ];

                // Check if the email is already in use
                if ($this->model('Customer')->isEmailTaken($data['email'])) {
                    echo json_encode(['emailTaken' => true]);
                    exit();
                }

                // If registration is successful
                if ($this->model('Customer')->register($data)) {
                    echo json_encode(['registrationSuccess' => true]);
                    exit();
                } else {
                    echo json_encode(['registrationSuccess' => false]);
                    exit();
                }

            } elseif ($formType === 'signin') {
                // Handle Sign In
                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = $this->model('Customer')->login($email);
                if ($user && password_verify($password, $user['password'])) {
                    // Define the default image path
                    $defaultImagePath = '/public/images/user-profile.png'; // Adjusted path

                    // Check if the user has a valid image path; use default if it's empty or incomplete
                    $imagePath = (!empty($user['image_url']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/' . $user['image_url']))
                        ? '/public/' . $user['image_url'] // Full path to image
                        : $defaultImagePath;

                    // Store user information in the session
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'image_url' => $imagePath, // Ensure this is correctly set
                        'name' => $user['first_name'] . ' ' . $user['last_name']
                    ];

                    echo json_encode(['loginSuccess' => true]);
                    exit();
                } else {
                    echo json_encode(['loginSuccess' => false]);
                    exit();
                }
            }
        }
        $this->view('customers/login_and_register');
    }

    // Rest Password for customers
    public function restPassword()
    {
        $this->view('customers/rest_password');
    }

    // Home page for customers
    public function index()
    {
        $products = $this->model('Product')->getMainCategoriesWithProducts();
        $this->view('customers/index', ['products' => $products]);
    }

    // About Us page
    public function about()
    {
        $this->view('customers/about');
    }

    // About Us page
    public function thankYou()
    {
        $this->view('customers/thankyou');
    }

    public function contact()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user'])) {
                header('Location: /customers/contact?error=not_logged_in');
                exit();
            }

            $this->model('Message')->saveMessage();
            header('Location: /customers/contact?success=true');
            exit();
        }

        $this->view('customers/contact');
    }


    // Category details page
    public function categoryView($id)
    {
        $products = $this->model('Product')->getProductCategory($id);
        $this->view('customers/category', ['products' => $products]);
    }

    // Products page
    public function shop()
    {
        // Get search, category, and price range filters from GET request
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null; // Make sure to get category_id
        $min_price = isset($_GET['min_price']) ? (float) $_GET['min_price'] : 0;
        $max_price = isset($_GET['max_price']) ? (float) $_GET['max_price'] : 1000;

        // Pagination setup
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $itemsPerPage = 8; // Number of items to display per page

        // Calculate total items and pages
        $totalItems = $this->model('Product')->getProductCount($search, $min_price, $max_price, $category_id);
        $totalPages = ceil($totalItems / $itemsPerPage);

        // Retrieve products based on current page and filters
        $products = $this->model('Product')->getProductsByPage($search, $min_price, $max_price, $category_id, $currentPage, $itemsPerPage);

        // Pass data to the view, including pagination and filter states
        $this->view('customers/shop', [
            'products' => $products,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'search' => $search,
            'category_id' => $category_id, // Pass selected category_id
            'min_price' => $min_price,
            'max_price' => $max_price,
        ]);
    }

    public function filter()
    {
        try {
            $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
            $min_price = isset($_GET['min_price']) ? (float) $_GET['min_price'] : 0;
            $max_price = isset($_GET['max_price']) ? (float) $_GET['max_price'] : 1000;

            $products = $this->model('Product')->getProductsByFilter($category_id, $min_price, $max_price);

            echo json_encode(['success' => true, 'products' => $products]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    //rania: Product details page
    public function productDetails($id)
    {
        $product = $this->model('Product')->getProductById($id);
        $reviews = $this->model('Review')->getReviewsByProductId($id);
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

        $errorMessage = null;

        // Handle review submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete_review_id'])) {
                // Handle review deletion
                $reviewId = $_POST['delete_review_id'];
                // Call the deleteReview method from the model
                if ($this->model('Review')->deleteReview($reviewId)) {
                    // Redirect with a success message
                    header("Location: " . $_SERVER['REQUEST_URI'] . "?deleted=true");
                    exit();
                } else {
                    // Redirect with an error message (if deletion fails)
                    header("Location: " . $_SERVER['REQUEST_URI'] . "?deleted=false");
                    exit();
                }
            } elseif ($user) {
                // Handle review submission
                $reviewData = [
                    'product_id' => $id,
                    'customer_id' => $user['id'],
                    'rating' => isset($_POST['rating']) ? $_POST['rating'] : null,
                    'comment' => isset($_POST['comment']) ? $_POST['comment'] : null
                ];

                if ($this->model('Review')->addReview($reviewData)) {
                    header("Location: " . $_SERVER['REQUEST_URI'] . "?success=true");
                    exit();
                } else {
                    $errorMessage = "Failed to submit review. Please try again.";
                }
            } else {
                $errorMessage = "Please log in to submit a review.";
            }
        }


        // Get filter and sort criteria from URL parameters
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $sortOrder = isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'DESC' : 'ASC';
        $imageFilter = isset($_GET['image_filter']) ? $_GET['image_filter'] : 'with_images';

        // Initialize filter and sorting values
        $filter = $_GET['filter'] ?? 'all';
        $sortOrder = $_GET['sort'] ?? 'asc';
        $imageFilter = $_GET['image_filter'] ?? 'all';

        // Filter reviews based on selected criteria
        if ($filter === 'my' && $user) {
            // Filter out only the user's reviews
            $reviews = array_filter($reviews, function ($review) use ($user) {
                return $review['customer_id'] === $user['id']; // Assuming review has customer_id field
            });
        }

        // Filter reviews based on image criteria
        if ($imageFilter === 'with_images') {
            // Keep only reviews that have images
            $reviews = array_filter($reviews, function ($review) {
                return !empty($review['image_url']); // Assuming review has an 'image_url' field
            });
        } elseif ($imageFilter === 'without_images') {
            // Keep only reviews that do not have images
            $reviews = array_filter($reviews, function ($review) {
                return empty($review['image_url']); // Assuming review has an 'image_url' field
            });
        }

        // No additional filtering for 'all', so all reviews remain unchanged.

        // Sort reviews by rating
        usort($reviews, function ($a, $b) use ($sortOrder) {
            return $sortOrder === 'asc' ? $a['rating'] <=> $b['rating'] : $b['rating'] <=> $a['rating'];
        });


        // Pass the error message and updated reviews to the view
        $this->view('customers/products_details', [
            'product' => $product,
            'reviews' => $reviews,
            'user' => $user,
            'errorMessage' => $errorMessage
        ]);
    }

    // Cart page
    public function cart()
    {

        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : []; // Check if cart exists
        $this->view('customers/cart', ['cart' => $cart]); // Pass cart data to the view
    }

    // Checkout page
    public function checkout()
    {
        if (!isset($_SESSION['user'])) { // assuming 'customer_id' holds the user's session
            // If not logged in, redirect to the login page
            header("Location:../customers/login_and_register");
        }
        $customer = $this->model('Customer')->getCustomerById();
        $this->view('customers/checkout', [
            'customers' => $customer,
        ]);
    }

    // Profile page for customer
    public function profile()
    {
        $customer = $this->model('Customer')->getCustomerById();
        $customerId = $_SESSION['user']['id'];

        $orderItemsData = $this->model('OrderItem')->getOrderDetails();

        // Group order items by order_id
        $orders = [];
        foreach ($orderItemsData as $item) {
            $orderId = $item->order_id;
            if (!isset($orders[$orderId])) {
                $orders[$orderId] = [
                    'order_id' => $item->order_id,
                    'order_date' => $item->order_date,
                    'status' => $item->status,
                    'total_amount' => $item->total_amount,
                    'items' => []
                ];
            }
            $orders[$orderId]['items'][] = $item;
        }

        $wishlistItems = $this->model('Wishlist')->getWishlistItems($customerId);

        $this->view('customers/profile', [
            'customers' => $customer,
            'orders' => $orders,
            'wishlistItems' => $wishlistItems
        ]);
    }


    public function updateProfile()
    {
        $id = $_POST['id'];
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $phoneNumber = trim($_POST['phone_number']);
        $address = trim($_POST['address']);

        $errors = [];

        // Validate first name (letters only, 2-30 characters)
        if (!preg_match('/^[a-zA-Z\s]{2,30}$/', $firstName)) {
            $errors[] = "First name must contain only letters and be between 2 and 30 characters.";
        }

        // Validate last name (letters only, 2-30 characters)
        if (!preg_match('/^[a-zA-Z\s]{2,30}$/', $lastName)) {
            $errors[] = "Last name must contain only letters and be between 2 and 30 characters.";
        }

        // Validate email
        // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //     $errors[] = "Invalid email format.";
        // } elseif ($this->model('Customer')->isEmailTaken($email, $id)) {
        //     $errors[] = "Email already taken! Please choose a different email address.";
        // }

        // Validate phone number (Jordanian format: starts with 07 and has 10 digits)
        if (!preg_match('/^07\d{8}$/', $phoneNumber)) {
            $errors[] = "Phone number must be in the format 07XXXXXXXX.";
        }

        // Validate address (non-empty)
        if (empty($address)) {
            $errors[] = "Address cannot be empty.";
        }

        // If there are errors, redirect back with SweetAlert error messages
        if (!empty($errors)) {
            $_SESSION['profile_errors'] = json_encode($errors); // Encode errors as JSON
            header("Location: /customers/profile"); // Redirect back to profile
            exit;
        }

        $imageName = null;

        // Handle image upload if a file is provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image'];

            // Basic image type and size validation can be added here
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($image['type'], $allowedTypes)) {
                $_SESSION['profile_errors'] = json_encode(["Invalid image type! Please upload a JPEG, PNG, or GIF."]);
                header("Location: /customers/profile");
                exit;
            }

            $imageName = 'uploads/' . time() . '_' . basename($image['name']);
            $uploadDir = 'public/';
            $uploadFilePath = $uploadDir . $imageName;

            // Move uploaded file to the designated directory
            if (!move_uploaded_file($image['tmp_name'], $uploadFilePath)) {
                $_SESSION['profile_errors'] = json_encode(["Image upload failed! Please try again."]);
                header("Location: /customers/profile");
                exit;
            }
        }

        try {
            // Update customer profile information in the database
            $updateSuccess = $this->model('Customer')->updateCustomer($id, $firstName, $lastName, $email, $phoneNumber, $address, $imageName);
            if ($updateSuccess) {
                if ($imageName) {
                    // Include 'public/' in the image URL
                    $_SESSION['user']['image_url'] = '/public/' . $imageName; // Update image URL in session
                }
                header("Location: /customers/profile"); // Redirect on success
                exit;
            }
        } catch (PDOException $e) {
            // Handle specific database error for email duplication
            if ($e->getCode() == 23000) {
                $_SESSION['profile_errors'] = json_encode(["Email already taken! Please choose a different email address."]);
                header("Location: /customers/profile");
                exit;
            } else {
                // General error handling
                $_SESSION['profile_errors'] = json_encode(["An error occurred while updating your profile."]);
                header("Location: /customers/profile");
                exit;
            }
        }


        header("Location: /customers/profile");
        exit;
    }


    // Customer logout
    public function logout()
    {
        unset($_SESSION['id']);
        session_destroy();
        header('Location: /customers/login_and_register');
    }

    public function cancelOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'];

            $orderModel = $this->model('Order');
            if ($orderModel->canCancelOrder($orderId)) {
                $orderModel->updateStatus($orderId, 'canceled');
                // Redirect to the customer profile page after successful cancellation
                header("Location: /customers/profile"); // Adjust the URL as needed
                exit(); // Ensure no further code is executed
            } else {
                // Handle failure (order cannot be canceled)
                // You might want to set a session message or redirect back with an error
                $_SESSION['error'] = "Order cannot be canceled.";
                header("Location: /customers/profile"); // Redirect to the profile or any other appropriate page
                exit();
            }
        }
    }
}