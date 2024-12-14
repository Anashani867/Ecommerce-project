<?php require "views/partials/header.php"; ?>

    <!-- Start Hero Section -->
    <div class="hero" style="padding: calc(3rem - 30px) 0 1rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-excerptt text-center">
                        <h1 class="hero-title mb-3">Shop</h1>
                        <p class="hero-subtitle">Discover Your Perfect Style: Handpicked Furniture for Every Space.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <div class="filter-container d-flex justify-content-center">
        <div class="container">
            <form method="GET" class="row g-3 justify-content-center" id="filterForm">
                <!-- Search Filter -->
                <div class="col-md-3 mb-3">
                    <label for="search" class="form-label">Search</label>
                    <div class="input-group">
                        <span class="input-group-text" id="search-icon">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" id="search" name="search" placeholder="Search products..."
                               class="form-control"
                               onkeyup="performLiveSearch()">
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="col-md-3 mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select category-select" id="category_id" name="category_id">
                        <option value="">All Categories</option>
                        <?php
                        $categories = $this->model('Product')->getCategories();
                        foreach ($categories as $category) {
                            $selected = ($category_id ?? '') == $category['id'] ? 'selected' : '';
                            echo "<option value=\"" . htmlspecialchars($category['id']) . "\" $selected>" . htmlspecialchars($category['category_name']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Price Range Slider -->
                <div class="col-md-3 mb-3">
                    <label for="max_price" class="form-label">Max Price</label>
                    <div class="price-slider">
                        <input type="range" id="max_price" name="max_price" min="0" max="1000"
                               value="<?= htmlspecialchars($max_price ?? 1000); ?>" oninput="updateMaxPrice(this.value)"
                               class="range-slider">
                        <div class="price-label">
                            <span>Selected Price: </span> <strong id="maxPriceLabel">
                                JD <?= htmlspecialchars($max_price ?? 1000); ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-md-3 d-flex align-items-end mb-3">
                    <button type="submit" class="btn filter-button">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateMaxPrice(value) {
            document.getElementById("maxPriceLabel").textContent = "JD " + value;
        }

        function performLiveSearch() {
            const query = document.getElementById("search").value;
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "/shop/liveSearch?query=" + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("productResults").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

    </script>

    <!-- Display Filtered Products -->
    <div class="untree_co-section product-section before-footer-section">
        <div class="container">
            <div id="productResults">
                <div class="row">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-12 col-md-4 col-lg-3 mb-5">
                                <a class="product-item" href="/customers/product_details/<?php echo $product['id']; ?>">
                                    <img src="/public/<?php echo $product['image_url']; ?>"
                                         class="img-fluid product-thumbnail" width="261" height="261"
                                         alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                    <h3 class="product-title">
                                        <b><?php echo ucwords(str_replace(['-', '_'], ' ', $product['product_name'])); ?></b>
                                    </h3>
                                    <strong class="product-price">
                                            JD <?php echo htmlspecialchars($product['price']); ?></strong>
                                    <span class="icon-cross">
                                    <img src="../public/images/cross.svg" class="img-fluid">
                                </span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center">No products found matching your criteria.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: -80px; margin-top: -20px;">
            <div class="col-12 text-center">
                <div class="text-center mt-4">
                    <?php if (isset($totalPages) && $totalPages > 0): ?>
                        <!-- Previous Button -->
                        <?php if ($currentPage > 1): ?>
                            <a class=" btn-green btn-sm mx-1"
                               href="?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($search); ?>&category_id=<?php echo $category_id; ?>&max_price=<?php echo $max_price; ?>">&laquo; Previous</a>
                        <?php endif; ?>

                        <!-- Pagination Links -->
                        <?php
                        // Display page numbers
                        for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php if ($i <= 2 || $i >= $totalPages - 1 || ($i >= $currentPage - 1 && $i <= $currentPage + 1)): ?>
                                <a href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>&max_price=<?= $max_price; ?>&category_id=<?= $category_id; ?>"
                                   class=" <?= $i == $currentPage ? 'btn-yellow ' : 'btn-green'; ?> btn-sm mx-1"><?= $i; ?></a>
                            <?php elseif ($i == 3 && $currentPage > 4): ?>
                                <span class=" mx-1">...</span>
                            <?php elseif ($i == $totalPages - 2 && $currentPage < $totalPages - 3): ?>
                                <span class=" dot mx-1">...</span>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <!-- Next Button -->
                        <?php if ($currentPage < $totalPages): ?>
                            <a class=" btn-green btn-sm mx-1"
                               href="?page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($search); ?>&category_id=<?php echo $category_id; ?>&max_price=<?php echo $max_price; ?>">Next &raquo;</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Include footer here -->
<?php require "views/partials/footer.php"; ?>

<style>
    .pagination-btn {
        padding: 5px 10px; /* Adjust padding */
        font-size: 0.85rem; /* Adjust font size */
    }
</style>

