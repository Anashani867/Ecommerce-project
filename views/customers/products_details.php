<?php require 'views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center mb-5 s_product_inner">

        <!-- Main Product Image and Thumbnails Section -->
        <div class="col-lg-6 col-xl-6 d-flex align-items-start">
            <div class="product-slider d-flex flex-row">

                <!-- Main Product Image -->
                <div class="main-image-container position-relative">
                    <?php
                    $allImages = explode(',', $product['all_images']);
                    $mainImage = trim($allImages[0]);
                    ?>
                    <img id="main-image" width="540" height="540" src="/public/<?= htmlspecialchars($mainImage); ?>"
                        class="img-fluid rounded shadow" alt="<?= htmlspecialchars($product['product_name']); ?>">

                    <form action="/customer/profile/add" method="post" class="wishlist-button">
                        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                        <button type="submit"
                            class="btn action-button <?= in_array($product['id'], $_SESSION['wishlists'] ?? []) ? 'wishlist-added' : '' ?>">
                            <i class="fa-solid fa-heart" style="font-size: 30px;"></i>
                        </button>
                    </form>

                </div>


                <?php if (isset($errorMessage)): ?>
                    <script>
                        Swal.fire({
                            icon: 'warning',
                            title: 'Login First',
                            text: '<?php echo $errorMessage; ?>',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3B5D50'
                        }).then(() => {

                            window.history.replaceState(null, null, window.location.pathname);
                        });;
                    </script>
                <?php elseif (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Review Submitted!',
                            text: 'Your review has been added successfully.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3B5D50'
                        }).then(() => {
                            // Remove the `success` parameter from the URL
                            window.history.replaceState(null, null, window.location.pathname);
                        });
                    </script>
                <?php endif; ?>

                <!-- Thumbnails Section to the Right of Main Image with Scroll -->
                <div class="sub-images d-flex flex-column ms-3 customer-reviews"
                    style="max-height: 400px; overflow-y: auto;">
                    <?php foreach ($allImages as $image):
                        $image = trim($image); ?>
                        <img onclick="changeMainImage(this.src)" class="sub-image img-thumbnail mb-2" width="150"
                            height="150" src="/public/<?= htmlspecialchars($image); ?>"
                            alt="<?= htmlspecialchars($product['product_name']); ?>" style="cursor: pointer;">
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-xl-5">
            <div>
                <h2><?= htmlspecialchars(ucwords(str_replace('-', ' ', $product['product_name']))); ?></h2>
                <?php
                // Calculate Average Rating
                $totalRating = 0;
                $reviewCount = count($reviews);
                if ($reviewCount > 0) {
                    foreach ($reviews as $review) {
                        $totalRating += (int) $review['rating']; // Sum all the ratings
                    }
                    $averageRating = $totalRating / $reviewCount; // Calculate average
                } else {
                    $averageRating = 0; // Default to 0 if no reviews
                }
                ?>

                <!-- Display Average Rating as Stars -->
                <div class="star-rating mt-3 mb-2 ">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fa fa-star fs-5  <?= ($i <= $averageRating) ? 'text-warning' : 'text-muted'; ?>"></i>
                    <?php endfor; ?>
                </div>
                <a href="#reviews-section" class="text-primary" style="cursor: pointer;"><?= count($reviews); ?>
                    reviews</a>
                <h4 class="product-price text-primary mt-3"> JD
                    <?= htmlspecialchars(number_format($product['price'], 2)); ?>
                </h4>
                <p class="lh-lg mt-3"><?= htmlspecialchars($product['description']); ?></p>

                <div class="availability mb-1">
                    <strong>Availability:</strong>
                    <?php
                    if ($product['stock_quantity'] > 5) {
                        echo "<span class='text-success'>Available</span>";
                    } elseif ($product['stock_quantity'] > 0) {
                        echo "<span class='text-warning'>Hurry up, limited quantity!</span>";
                    } else {
                        echo "<span class='text-danger '>Out of Stock</span>";
                    }
                    ?>
                </div>
                <div class="d-flex align-items-center mb-5 mt-3 ">
                    <?php if ($product['stock_quantity'] > 0): ?>
                        <form action="/customer/cart" method="post"
                            class="button-form me-3 d-flex align-items-center gap-2">
                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">

                            <div class="product_count">
                                <span class="inumber-decrement" style="cursor: pointer;">
                                    <i class="fa-solid fa-minus"></i>
                                </span>
                                <input class="input-number" type="number" name="quantity" id="quantity" value="1" min="0"
                                    max="<?= $product['stock_quantity']; ?>" style="width: 50px;">
                                <span class="number-increment" style="cursor: pointer;">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                            </div>

                            <!-- Add to Cart Button -->
                            <button type="submit" class="btn btn-primary action-button" style="height: 50px; width: 200px;">
                                <i class="fa-solid fa-cart-plus" style="margin-right: 5px;"></i> ADD TO CART
                            </button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-secondary action-button" style="height: 50px; width: 200px;" disabled>Out of
                            Stock</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Reviews Section -->
    <div class="reviews-section my-5 mt-5" id="reviews-section">
        <div class="row">
            <!-- Left Column for Reviews -->
            <div class="col-md-6">
                <div class="customer-reviews">
                    <div class="reviews-filter mb-3">
                        <div class="d-flex align-items-center">
                            <!-- All Reviews Button -->
                            <button type="button"
                                class="btn review-filter-btn <?= empty($_GET['filter']) || $_GET['filter'] === 'all' ? 'active' : ''; ?>"
                                id="all-reviews">All Reviews</button>

                            <!-- My Reviews Button -->
                            <button type="button"
                                class="btn review-filter-btn <?= isset($_GET['filter']) && $_GET['filter'] === 'my' ? 'active' : ''; ?>"
                                id="my-reviews" style="margin-left:10px;">My Reviews</button>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="reviews-list">
                        <!-- If there are reviews -->
                        <?php if (!empty($reviews)): ?>
                            <?php foreach ($reviews as $review): ?>
                                <?php if ($review['status'] === 'accepted'): ?>
                                    <div
                                        class="review-card d-flex flex-column p-3 border rounded bg-light mb-3 position-relative shadow-lg">
                                        <!-- Delete Button -->
                                        <?php if (isset($user) && $user['id'] === $review['customer_id']): ?>
                                            <form action="" method="POST" style="display:inline;"
                                                id="delete-review-form-<?= $review['id']; ?>">
                                                <input type="hidden" name="delete_review_id" value="<?= $review['id']; ?>">
                                                <button type="button"
                                                    class="delete-review btn-danger btn-sm position-absolute top-0 end-0"
                                                    onclick="confirmDelete(<?= $review['id']; ?>)">X</button>
                                            </form>
                                        <?php endif; ?>

                                        <!-- Review Content -->
                                        <div class="review-info d-flex flex-column mb-4">
                                            <!-- User Image and Name -->
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="reviewer-image me-3">
                                                    <img src="/public/<?= htmlspecialchars($review['customer_image'] ?? '/public/images/user-profile.png') ?>"
                                                        alt="User Image" class="img-thumbnail rounded-circle"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                </div>
                                                <div class="review-text" style="flex: 1;">
                                                    <!-- Make Name Bold and Larger -->
                                                    <p class="reviewer-name mb-0" style="font-weight: bold; font-size: 1.2rem;">
                                                        <?= htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?>
                                                    </p>
                                                    <div class="star-rating">
                                                        <?php
                                                        $rating = (int) $review['rating'];
                                                        for ($i = 1; $i <= 5; $i++) {
                                                            echo $i <= $rating ? '<i class="fas fa-star text-warning" style="font-size: 0.8rem;"></i>' : '<i class="far fa-star text-warning" style="font-size: 0.8rem;"></i>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Review Comment and Image in the Same Div -->
                                            <div class="review-comment-container">
                                                <div class="review-comment">
                                                    <?= htmlspecialchars($review['comment']); ?>
                                                </div>
                                                <?php if (!empty($review['image_url'])): ?>
                                                    <div class="review-image ms-3">
                                                        <img src="/<?= htmlspecialchars($review['image_url']) ?>" alt="Review Image"
                                                            class="img-thumbnail" style="max-width: 150%; cursor: pointer;">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Review Date -->
                                        <p class="review-date text-end mt-2">
                                            <em><?= htmlspecialchars(date("F j, Y", strtotime($review['created_at']))); ?></em>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center">No reviews yet. Be the first to leave a review!</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

            <!-- Right Column for Review Form -->
            <div class="col-md-6">
                <div class="review-form-container">
                    <h4 class="text-primary font-weight-bold mb-4">Write a Review</h4>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="d-flex flex-column gap-3">
                            <!-- Rating Section -->
                            <div class="rating-section">
                                <label for="rating" class="form-label">Rating</label>
                                <div class="star-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fa fa-star" data-value="<?= $i; ?>" onclick="setRating(<?= $i; ?>)"
                                            id="star-<?= $i; ?>"></i>
                                    <?php endfor; ?>
                                    <input type="hidden" name="rating" id="rating" required>
                                </div>
                            </div>

                            <!-- Upload Image Section -->
                            <div class="upload-section">
                                <label for="image" class="form-label">Upload Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            </div>

                            <!-- Comment Section -->
                            <div class="comment-section mb-3">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="submit-btn d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    function confirmDelete(reviewId) {
        // SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor: '#C82333',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-review-form-' + reviewId).submit();
            }
        });
    }

    // Star rating click function
    function setRating(value) {
        document.getElementById("rating").value = value;
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById(`star-${i}`);
            if (i <= value) {
                star.classList.add("text-warning");
                star.classList.remove("text-muted");
            } else {
                star.classList.add("text-muted");
                star.classList.remove("text-warning");
            }
        }
    }

    // Change main image
    function changeMainImage(src) {
        document.getElementById("main-image").src = src;
    }

    // Get elements for quantity input and buttons
    const decrementBtn = document.querySelector('.inumber-decrement');
    const incrementBtn = document.querySelector('.number-increment');
    const quantityInput = document.getElementById('quantity');
    const maxQuantity = parseInt(quantityInput.max); // Get max quantity from the input attribute

    // Decrease quantity
    decrementBtn.addEventListener('click', function () {
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > 0) {
            quantityInput.value = currentQuantity - 1;
        }
    });

    // Increase quantity
    incrementBtn.addEventListener('click', function () {
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity < maxQuantity) {
            quantityInput.value = currentQuantity + 1;
        }
    });

    // Prevent input value from going below 0 or above max quantity
    quantityInput.addEventListener('input', function () {
        let value = parseInt(quantityInput.value);
        if (value < 0) {
            quantityInput.value = 0;
        } else if (value > maxQuantity) {
            quantityInput.value = maxQuantity;
        }
    });

    document.getElementById('all-reviews').addEventListener('click', function () {
        window.location.href = updateURL('filter', 'all');
    });

    document.getElementById('my-reviews').addEventListener('click', function () {
        window.location.href = updateURL('filter', 'my');
    });

    // Function to update the URL with the selected parameter and its value
    function updateURL(param, value) {
        const url = new URL(window.location.href); // Use current URL
        url.searchParams.set(param, value); // Set or update the parameter in the URL
        return url.toString(); // Return the updated URL with the new parameter
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.wishlist-button .action-button').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent form submission for visual feedback

                const icon = this.querySelector('i');
                // Toggle between outline and solid heart
                if (icon.classList.contains('fa-regular')) {
                    icon.classList.remove('fa-regular'); // Remove outline heart
                    icon.classList.add('fa-solid'); // Add solid heart
                    icon.style.color = '#3B5D50'; // Fill the heart with the specified color
                } else {
                    icon.classList.remove('fa-solid'); // Remove solid heart
                    icon.classList.add('fa-regular'); // Add outline heart
                    icon.style.color = '#6ca197'; // Set the original color
                }

                // Optionally, submit the form after color change
                this.closest('form').submit();
            });
        });
    });

</script>

<?php require 'views/partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Wishlist Button */
    .wishlist-button {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .wishlist-button .action-button {
        background-color: transparent;
        color: #6ca197;
        border: none;
        padding: 0;
        cursor: pointer;
    }

    .wishlist-button .action-button.wishlist-added {
        color: #3B5D50;
        /* Color for filled heart */
    }


    .action-button {
        width: 60px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        border-radius: 5px;
        background-color: #4c6a63;
        color: white;
        border: none;
    }

    .product-slider {
        display: flex;
        flex-direction: column;
    }

    .main-image-container {
        border: 3px solid #3B5D50;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    .sub-images {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 10px;
    }

    /* Hide scrollbar but keep the scrolling functionality */

    .reviews-list::-webkit-scrollbar {
        display: none;
    }

    .customer-reviews::-webkit-scrollbar {
        display: none;
        width: 8px;
    }

    .product_count {
        display: flex;
        align-items: center;
        gap: 10px;
        background-color: #f1f1f1;
        padding: 3px;
        border-radius: 5px;
        width: fit-content;
        border: 1px, solid #3B5D50;
        margin-top: -15px;
    }

    .inumber-decrement,
    .number-increment {
        cursor: pointer;
        padding: 8px;
        color: #333;
    }

    .input-number {
        font-size: 16px;
        text-align: center;
        width: 40px;
        background: none;
        border: none;
        outline: none;
        color: #333;
    }

    /* Star Rating */
    .star-rating i {
        font-size: 1.5rem;
    }

    .star-rating .text-warning {
        color: #FF6347;
    }

    .star-rating .text-muted {
        color: #d3d3d3;
    }

    /* Reviews Section */
    .reviews-section {
        margin-top: 3rem;
    }

    .reviews-filter {
        margin-bottom: 20px;
    }

    .reviews-list {
        max-height: 400px;
        /* You can adjust this value */
        overflow-y: auto;
        /* This will allow scrolling */
    }

    .review-card {
        display: flex;
        flex-direction: column;
        height: auto;
        overflow: hidden;
    }

    .review-info {
        display: flex;
        flex-direction: column;
    }

    .review-info .d-flex {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .review-text {
        flex: 1;
    }

    .review-text .reviewer-name {
        font-weight: bold;
        font-size: 1.2rem;
        color: #314D43;
    }

    .star-ratingg i {
        font-size: 0.8rem;
        /* Smaller star size */
    }

    .review-comment {
        flex: 1;
        padding-right: 10px;
    }

    .review-comment-container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: start;
        margin-top: 10px;
        overflow-y: auto;
        /* Enables scrolling within this section */
        max-height: 150px;
        /* Adjust the height to fit the desired area */
        padding-right: 10px;
        /* To prevent scrollbar overlapping content */
    }

    .review-image {
        text-align: end;
        width: 100px;
        margin-right: 60px;
    }

    .review-date {
        text-align: right;
        margin-top: 10px;
    }


    /* Review Form */
    .review-form-container {
        padding: 2rem;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .review-form-container h4 {
        font-weight: bold;
        color: #3DB5D8;
    }

    .rating-section .star-rating {
        display: flex;
        gap: 5px;
    }

    .upload-section input[type="file"] {
        font-size: 1rem;
    }

    .comment-section textarea {
        resize: none;
        font-size: 1rem;
        padding: 10px;
    }

    .submit-btn button {
        background-color: #3DB5D8;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 5px;
        cursor: pointer;
    }

    .submit-btn button:hover {
        background-color: #2c93b0;
    }

    /* Custom Button Styles */

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }


    /* Form Layout */
    .form-select {
        width: 150px;
    }

    /* Default button style */
    .review-filter-btn {
        border: 2px solid #314D43;
        background-color: transparent;
        color: #314D43;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    /* Active button style */
    .review-filter-btn.active {
        background-color: #314D43;
        color: #fff;
    }

    /* Button hover effect */
    .review-filter-btn:hover {
        background-color: #314D43;
        color: #fff;
    }
</style>