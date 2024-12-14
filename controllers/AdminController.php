<?php
class AdminController extends Controller
{
    // Admin login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formType = $_POST['form_type'];

            if ($formType === 'signin') {
                // Handle Sign In
                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = $this->model('Admin')->login($email);
                if ($user && password_verify($password, $user['password'])) {

                    // Store user information in the session
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'role' => $user['role'],
                        'image_url' => 'images/user-profile.png',
                    ];
                    echo json_encode(['loginSuccess' => true]);
                    exit();
                } else {
                    echo json_encode(['loginSuccess' => false]);
                    exit();
                }

            }
        }
        $this->view('admin/login');
    }
    // Rest Password page
    public function restPassword()
    {
        $this->view('admin/rest_password');
    }

    // Admin logout
    public function logout()
    {
        unset($_SESSION['admin_id']);
        session_destroy();
        header('Location: /admin/login');
    }

    // Admin dashboard
    public function dashboard()
    {
        $userCount = $this->model('Customer')->countCustomers();
        $orderCount = $this->model('Order')->countOrders();
        $orderTotal = $this->model('Order')->totalOrders();
        $couponCount = $this->model('Coupon')->CouponCount();

        // Fetch sales data for the chart
        $salesData = $this->model('Order')->getSalesData();

        $labels = [];
        $values = [];

        foreach ($salesData as $row) {
            $labels[] = $row['order_date'];
            $values[] = $row['total_amount'];
        }

        // Fetch most-selling products
        $mostSellingProducts = $this->model('Product')->getMostSellingProducts();

        // Pass all data to the view
        $this->view('admin/dashboard', [
            'userCount' => $userCount,
            'orderCount' => $orderCount,
            'orderTotal' => $orderTotal,
            'couponCount' => $couponCount,
            'labels' => json_encode($labels),
            'values' => json_encode($values),
            'mostSellingProducts' => $mostSellingProducts
        ]);
    }

    // Manage categories
    public function manageCategory()
    {
        $categories = $this->model('Category')->all();
        $this->view('admin/manage_category', ['categories' => $categories]);
    }


    // Manage products
    public function manageProducts()
    {
        $categories = $this->model('Category')->all();
        $products = $this->model('Product')->getProducts();
        $this->view('admin/manage_products', ['products' => $products, 'categories' => $categories]);

    }


    // Manage orders
    public function manageOrders()
    {
        $orders = $this->model('Order')->all();
        $this->view('admin/manage_orders', ['orders' => $orders]);
    }
    public function changeOrderStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['orderId'];
            $status = $_POST['status'];

            // Check if the order is already canceled or completed
            $currentStatus = $this->model('Order')->getStatusById($orderId); // Assuming you have a method to get the current status
            if ($currentStatus === 'canceled' || $currentStatus === 'completed') {
                // Handle the case where the order cannot be edited
                echo json_encode(['error' => 'This order cannot be changed.']);
                exit;
            }

            try {
                $this->model('Order')->updateStatus($orderId, $status);
                // Redirect or provide success feedback
                header('Location: /admin/manage_orders'); // Adjust this path as necessary
                exit;
            } catch (Exception $e) {
                // Handle error, perhaps log it and redirect with an error message
                echo json_encode(['error' => "Error: " . $e->getMessage()]);
            }
        }
    }


    //view Item
    public function viewProduct($id)
    {
        $product = $this->model('Product')->find($id);
        $this->view('admin/product_view', ['products' => $product]);
    }

    //view Item
    public function viewCustomer($id)
    {
        $customer = $this->model('Customer')->find($id);
        $this->view('admin/customer_view', ['customer' => $customer]);

    }

    //edit Customer
    public function editCustomer($id)
    {
        $customer = $this->model('Customer')->find($id);
        $this->view('admin/Customer_edit', ['customer' => $customer]);
    }
    //update Customer
    public function updateCustomer($id)
    {
        $customer = $this->model('Customer')->find($id);
        if (!$customer) {
            $_SESSION['message'] = "Customer not found!";
            return $this->view('admin/manage_customers', ['customers' => $this->model('Customer')->all()]);
        }

        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'phone_number' => $_POST['phone_number'],
            'address' => $_POST['address'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === 0) {
            $targetDir = 'public/uploads/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $imageName = uniqid() . '-' . basename($_FILES['image_url']['name']);
            $targetFile = $targetDir . $imageName;
            $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            // Check if the uploaded file type is allowed
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['image_url']['tmp_name'], $targetFile)) {
                    // Set the relative path to the uploaded image
                    $data['image_url'] = 'uploads/' . $imageName;
                } else {
                    $_SESSION['message'] = "Error uploading image.";
                    $_SESSION['messageType'] = "error";
                    return $this->view('admin/customer_edit', ['customer' => $customer]);
                }
            } else {
                $_SESSION['message'] = "Invalid image file type. Only JPG, JPEG, PNG, and GIF are allowed.";
                $_SESSION['messageType'] = "error";
                return $this->view('admin/customer_edit', ['customer' => $customer]);
            }
        } else {
            // No new image uploaded, keep the existing image URL
            $data['image_url'] = $customer['image_url'];
        }

        // Update customer data
        $this->model('Customer')->update($id, $data);

        // Retrieve the updated customer data to reflect the latest changes in the view
        $updatedCustomer = $this->model('Customer')->find($id);
        $_SESSION['message'] = "Customer updated successfully!";
        $_SESSION['messageType'] = "success";

        return $this->view('admin/customer_edit', ['customer' => $updatedCustomer]);
    }



    // Create Product
    public function createProduct()
    {
        $categories = $this->model('Category')->all();
        $message = null;
        $messageType = 'success';

        // Check if required POST data is set
        if (isset($_POST['product_name'], $_POST['price'], $_POST['description'], $_POST['category_id'], $_POST['stock_quantity'])) {

            $productData = [
                'product_name' => $_POST['product_name'],
                'price' => $_POST['price'],
                'description' => $_POST['description'],
                'category_id' => $_POST['category_id'],
                'average_rating' => $_POST['average_rating'] ?? 0,
                'stock_quantity' => $_POST['stock_quantity'],
            ];

            // Create the product and get its ID
            $productId = $this->model('Product')->create($productData);

            if ($productId) {
                // Directory for uploads
                $uploadDir = 'public/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Check if an image was uploaded
                if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === 0) {
                    // Generate a unique name for the image to prevent overwriting
                    $imageName = uniqid() . '-' . basename($_FILES['image_url']['name']);
                    $imagePath = $uploadDir . $imageName;

                    // Move the uploaded file to the designated directory
                    if (move_uploaded_file($_FILES['image_url']['tmp_name'], $imagePath)) {
                        $imageData = [
                            'product_id' => $productId,
                            'image_url' => 'uploads/' . $imageName,
                        ];
                        $this->model('ProductImage')->create($imageData);
                        $message = "Product created successfully!";
                    } else {
                        $message = "Failed to upload image.";
                        $messageType = 'error';
                    }
                }
            } else {
                $message = "Failed to create product.";
                $messageType = 'error';
            }
        }

        // Fetch updated products list and render the view
        $products = $this->model('Product')->getProducts();
        $this->view('admin/manage_products', [
            'products' => $products,
            'categories' => $categories,
            'message' => $message,
            'messageType' => $messageType,
        ]);
    }


    public function createCustomer()
    {
        if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['phone_number'])) {

            $customerData = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'phone_number' => $_POST['phone_number'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];


            if ($this->model('Customer')->isEmailTaken($_POST['email'])) {
                $_SESSION['message'] = "Email is already taken.";
                $_SESSION['messageType'] = "error";
                $this->view('admin/manage_customers', [
                    'customers' => $this->model('Customer')->all()
                ]);
                return;
            }


            $customerId = $this->model('Customer')->create($customerData);


            if ($customerId && isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $uploadDir = 'public/uploads/';
                $fileExtension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);


                if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                    $_SESSION['message'] = "Only images (jpg, jpeg, png, gif) are allowed.";
                    $_SESSION['messageType'] = "error";
                } else {
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $imageName = $uploadDir . basename($_FILES['profile_image']['name']);
                    $imagePath = $imageName;

                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $imagePath)) {

                        $this->model('Customer')->updateProfileImage($customerId, $imagePath);
                        $_SESSION['message'] = "Customer created successfully!";
                        $_SESSION['messageType'] = "success";
                    } else {
                        $_SESSION['message'] = "Failed to upload profile image.";
                        $_SESSION['messageType'] = "error";
                    }
                }
            } else {
                $_SESSION['message'] = "Customer created successfully!";
                $_SESSION['messageType'] = "success";
            }

            $this->view('admin/manage_customers', ['customers' => $this->model('Customer')->all()]);
        }
    }

    //delete Customer
    public function deleteCustomer()
    {
        $id = $_POST['id'] ?? null;

        if (!$id || !$this->model('Customer')->find($id)) {
            $_SESSION['error'] = "Customer not found!";
            header("Location: /admin/manage_customers");
            exit;
        }

        $this->model('Customer')->delete($id);

        $_SESSION['message'] = "Customer deleted successfully!";
        header("Location: /admin/manage_customers");
        exit;
    }

    // Manage customers
    public function manageCustomers()
    {

        $customers = $this->model('Customer')->all();
        $this->view('admin/manage_customers', ['customers' => $customers]);
    }

    public function editProduct($id)
    {
        $categories = $this->model('Category')->all();
        $product = $this->model('Product')->getProductWithImage($id);
        $this->view('admin/product_edit', ['product' => $product, 'categories' => $categories]);
    }

    public function updateProduct($id)
    {
        // Fetch all categories to display when updating the product
        $categories = $this->model('Category')->all();

        // Retrieve the current product data
        $existingProduct = $this->model('Product')->getProductWithImage($id);

        // Store the new data for the update, keeping previous values if inputs are null
        $data = [
            'description' => !empty($_POST['description']) ? $_POST['description'] : $existingProduct['description'],
            'price' => !empty($_POST['price']) ? $_POST['price'] : $existingProduct['price'],
            'category_id' => !empty($_POST['category_id']) ? $_POST['category_id'] : $existingProduct['category_id'],
            'stock_quantity' => !empty($_POST['stock_quantity']) ? $_POST['stock_quantity'] : $existingProduct['stock_quantity'],
        ];

        // Update the product data
        $this->model('Product')->update($id, $data);

        // Check if an image file is uploaded
        if (!empty($_FILES['image_url']['name'])) {
            $targetDir = 'public/uploads/';
            $imageName = uniqid() . '-' . basename($_FILES['image_url']['name']);
            $targetFile = $targetDir . $imageName;
            $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        
            // Verify that the uploaded file is an allowed image type
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['image_url']['tmp_name'], $targetFile)) {
                    // Store only the image name or the path in the database as needed
                    $imagePath = 'uploads/' . $imageName;
                    $this->model('ProductImage')->update($id, $imagePath);
        
                    $_SESSION['message'] = "Product image updated successfully!";
                    $_SESSION['messageType'] = "success";

                } else {
                    $_SESSION['message'] = "Sorry, there was an error uploading your file.";
                    $_SESSION['messageType'] = "error";
                }
            } else {
                $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                return;
            }
        } else {
            $_SESSION['message'] = "Product updated successfully!";
            $_SESSION['messageType'] = "success";
        }

        // Fetch the updated product data to display in the view
        $product = $this->model('Product')->getProductWithImage($id);

        // Set a success message after updating
        $_SESSION['message'] = "Product updated successfully!";

        // Display the product edit view with updated data
        $this->view('admin/product_edit', [
            'product' => $product,
            'categories' => $categories,
            'message' => $_SESSION['message'] ?? null,
            'messageType' => $_SESSION['messageType'] ?? null,
        ]);
        unset($_SESSION['message'], $_SESSION['messageType']);
        exit;
    }


    public function deleteProduct()
    {
        $id = $_POST['productId'] ?? null;
        if (!$id || !$this->model('Product')->find($id)) {
            $_SESSION['error'] = "Product not found!";
            header("Location: /admin/manage_products");
            exit;
        }
        $this->model('Product')->delete($id);
        $_SESSION['success'] = "Product deleted successfully!";
        header("Location: /admin/manage_products");
        exit;
    }

    public function accountSettings()
    {

        if (isset($_SESSION['user']['id'])) {
            $id = $_SESSION['user']['id'];

            $admin = $this->model('Admin')->find($id);

            $this->view('admin/account_settings', ['admin' => $admin]);
        } else {

            header('Location: /login');
            exit();
        }
    }

    public function createCategory()
    {
        if (isset($_POST['category_name']) && !empty($_FILES['image_url']['name'])) {
            $categoryData = [
                'category_name' => $_POST['category_name'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $uploadDir = 'public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $imageName = uniqid() . '-' . basename($_FILES['image_url']['name']);
            $imagePath = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['image_url']['tmp_name'], $imagePath)) {
                $categoryData['image_url'] = 'uploads/' . $imageName;

                $categoryModel = $this->model('Category');
                if ($categoryModel->create($categoryData)) {
                    echo json_encode(['success' => true, 'message' => 'Category created successfully.']);
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to save category to the database.']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to upload image. Error: ' . $_FILES['image_url']['error']]);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
            exit;
        }
    }


    public function viewCategory($id)
    {
        $category = $this->model('Category')->find($id);
        $this->view('admin/category_view', ['category' => $category]);
    }
    
    public function editCategory($id)
    {
        $category = $this->model('Category')->find($id);
        $this->view('admin/category_edit', ['category' => $category]);
    }

    public function updateCategory($id)
    {
        // Retrieve the existing category data
        $category = $this->model('Category')->find($id);
        if (!$category) {
            $_SESSION['message'] = "Category not found!";
            $_SESSION['messageType'] = "error";
            return $this->view('admin/manage_categories', ['categories' => $this->model('Category')->all()]);
        }

        // Set up data array with basic information
        $data = [
            'category_name' => $_POST['category_name']
        ];

        // Check if an image file is uploaded
        if (!empty($_FILES['image_url']['name'])) {
            $targetDir = 'public/uploads/';
            $imageName = uniqid() . '-' . basename($_FILES['image_url']['name']);
            $targetFile = $targetDir . $imageName;
            $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

            // Verify that the uploaded file is an allowed image type
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['image_url']['tmp_name'], $targetFile)) {
                    // Set the relative path to the uploaded image in the database
                    $data['image_url'] = 'uploads/' . $imageName;
                } else {
                    $_SESSION['message'] = "Error uploading image.";
                    $_SESSION['messageType'] = "error";
                    return $this->view('admin/category_edit', ['category' => $category]);
                }
            } else {
                $_SESSION['message'] = "Invalid image file type. Only JPG, JPEG, PNG, and GIF are allowed.";
                $_SESSION['messageType'] = "error";
                return $this->view('admin/category_edit', ['category' => $category]);
            }
        } else {
            // If no new image is uploaded, keep the existing image URL
            $data['image_url'] = $category['image_url'];
        }

        // Update the category data in the database
        $this->model('Category')->update($id, $data);

        // Retrieve the updated category data
        $updatedCategory = $this->model('Category')->find($id);


        return $this->view('admin/category_edit', ['category' => $updatedCategory]);
    }



    public function deleteCategory()
    {
        $id = $_POST['categoryId'] ?? null;

        if (!$id || !$this->model('Category')->find($id)) {
            $_SESSION['error'] = "Category not found!";
            header("Location: /admin/manage_category");
            exit;
        }

        $this->model('Category')->delete($id);


        header("Location: /admin/manage_category");
        exit;
    }


    public function addAdmin()
    {
        $data = [
            "email" => $_POST['email'] ?? null,
            "password" => $_POST['password'] ?? null,
            "role" => $_POST['role'] ?? 'admin',
        ];

        $this->model('Admin')->create($data);

        $admins = $this->model('Admin')->all();
        $this->view('admin/super_manage_admin', ['admins' => $admins]);
    }

    public function deleteAdmin()
    {
        $id = $_POST['id'] ?? null;

        if (!$id || !$this->model('Admin')->find($id)) {
            $_SESSION['error'] = "Admin not found!";
        } else {
            $this->model('Admin')->delete($id);
            $_SESSION['message'] = "Admin deleted successfully!";
        }

        $admins = $this->model('Admin')->all();
        $this->view('admin/super_manage_admin', ['admins' => $admins]);
    }

    public function displayTestimonials()
    {

        $testimonials = $this->model('Testimonial')->all();


        $testimonialCount = $this->model('Testimonial')->getTestimonialsCount();


        $this->view('admin/manage_testimonials', [
            'testimonials' => $testimonials,
            'testimonialCount' => $testimonialCount
        ]);
    }

    // coupons 

    // public function manageCoupon()
    // {
    //     $coupons = $this->model('Coupon')->All();
    //     $this->view('admin/manage_coupon', ['coupons' => $coupons]);
    // }
    // public function editCoupon($id) {
    //     $coupon = $this->model('Coupon')->find($id);
    //     $this->view('admin/coupon_edit', ['coupon' => $coupon]);
    // }
    // public function createCoupon()
    // {

    //     $data = [
    //         'code' => $_POST['code'],
    //         'discount' => $_POST['discount'],
    //         'description' => $_POST['description'],
    //         'usage_limit' => $_POST['usage_limit'],
    //         'expiration_date' => $_POST['expiration_date'] , 
    //     ];

    //     $this->model('Create')->create($data);
    //     $_SESSION['message'] = "Coupon created successfully!";
    //     header('Location: /admin/manage_coupon');
    //     exit;
    // }

    // public function updateCoupon($id) {
    //     $data= [
    //         'code' => $_POST['code'],
    //         'discount' => $_POST['discount'],
    //         'usage_limit' => $_POST['usage_limit'],
    //         'expiration_date' => $_POST['expiration_date'],
    //     ];

    //     $coupon = $this->model('Coupon')->find($id);

    //     $this->model('Coupon')->update($id, $data);

    //     $_SESSION['message'] = "Coupon updated successfully!";

    //     $this->view('admin/coupon_edit', ['coupon' => $coupon]);

    //     var_dump($_POST);
    //     exit;
    // }

    // public function deleteCoupon()
    // {
    //     $id = $_POST['id'] ?? null;

    //     if (!$id || !$this->model('Coupon')->find($id)) {
    //         $_SESSION['error'] = "Coupon not found!";
    //         header("Location: /admin/manage_coupon");
    //         exit;
    //     }

    //     $this->model('Coupon')->delete($id);

    //     $_SESSION['message'] = "Coupon deleted successfully!";
    //     header("Location: /admin/manage_coupon");
    //     exit;
    // }

    public function manageReviews()
    {
        // Fetch all reviews from the Review model
        $reviews = $this->model('ReviewModel')->all();

        // Pass the reviews data to the view
        $this->view('admin/Review', ['reviews' => $reviews]);
    }

    public function acceptReviewAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reviewId = isset($_POST['reviewId']) ? intval($_POST['reviewId']) : 0;

            if ($reviewId > 0) {
                $result = $this->model('Review')->acceptReview($reviewId);



                header("Location: /admin/Review");
                exit();
            }
        }
    }

    public function rejectReviewAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reviewId = isset($_POST['reviewId']) ? intval($_POST['reviewId']) : 0;

            if ($reviewId > 0) {
                $result = $this->model('Review')->rejectReview($reviewId);

                header("Location: /admin/Review");
                exit();
            }
        }
    }
    public function manageCoupons()
    {
        // Fetch all coupons from the Coupon model
        $coupons = $this->model('CouponModel')->all();

        // Pass the coupons data to the view
        $this->view('admin/Coupon', ['coupons' => $coupons]);
    }

    public function CouponDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate that the coupon ID is provided
            $couponId = isset($_POST['couponId']) ? intval($_POST['couponId']) : 0;

            if ($couponId > 0) {
                // Call the model to delete the coupon
                $result = $this->model('CouponModel')->CouponDelete($couponId);

                if ($result) {
                    // Set a success message
                    $_SESSION['message'] = "Coupon deleted successfully!";
                } else {
                    // Set an error message
                    $_SESSION['error'] = "Error deleting coupon. Please try again.";
                }
            } else {
                $_SESSION['error'] = "Invalid coupon ID.";
            }

            // Redirect back to the manage coupons page
            header("Location: /admin/Coupon");
            exit();
        }
    }
    public function addCoupon()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate that the required fields are provided
            $code = isset($_POST['code']) ? trim($_POST['code']) : '';
            $discount = isset($_POST['discount']) ? floatval($_POST['discount']) : 0;
            $usageLimit = isset($_POST['usage_limit']) ? intval($_POST['usage_limit']) : null;
            $expirationDate = isset($_POST['expiration_date']) ? $_POST['expiration_date'] : null;

            if (!empty($code) && $discount >= 0 && $discount <= 100) {
                // Check if the coupon code already exists
                $existingCoupon = $this->model('CouponModel')->getCouponByCode($code);

                if ($existingCoupon) {
                    $_SESSION['error'] = "Coupon code already exists. Please use a different code.";
                } else {
                    // Call the model to add the coupon
                    $result = $this->model('CouponModel')->addCoupon($code, $discount, $usageLimit, $expirationDate);

                    if ($result) {
                        $_SESSION['message'] = "Coupon added successfully!";
                    } else {
                        $_SESSION['error'] = "Error adding coupon. Please try again.";
                    }
                }
            } else {
                $_SESSION['error'] = "Please provide valid coupon code and discount.";
            }

            // Redirect back to the manage coupons page
            header("Location: /admin/Coupon");
            exit();
        }
    }
    public function messages()
    {
        $messages = $this->model('Message')->getMessagesWithCustomerNames();
        $this->view('admin/messages', ['messages' => $messages]);
    }

    public function manageAdmin()
    {
        // Logic for managing admin accounts
        $admins = $this->model('Admin')->all();
        $this->view('admin/super_manage_admin', ['admins' => $admins]);
    }
}



