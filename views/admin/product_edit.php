<?php require "views/partials/admin_header.php"; ?>
<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="main-container">
                <div class="card shadow-lg border-0">
    <div class="d-flex justify-content-between align-items-center p-4">
        <div class="d-flex align-items-center">

            <?php
            $imageSrc = !empty($product['image_url']) ? htmlspecialchars($product['image_url']) : 'images/product.png';
            ?>
            <img src="/public/<?= $imageSrc; ?>" alt="Product Image" class="img-thumbnail"
            style="width: 100px; height: 100px; object-fit: cover;">

            <h3 class="text-success ms-3 fw-bold">
                <?php
                $formattedName = str_replace('-', ' ', strtolower($product['product_name']));
                $formattedName = ucwords($formattedName);
                echo htmlspecialchars($formattedName);
                ?>
            </h3>
        </div>
        <button class="btn btn-success text-white" data-bs-toggle="modal"
            data-bs-target="#editProductModal">
            Edit Product
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Product ID</label>
                <input type="text" class="form-control" 
                    value="<?php echo htmlspecialchars($product['id']); ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Average Rating</label>
                <input type="text" class="form-control" 
                    value="<?php echo htmlspecialchars($product['average_rating']); ?>" readonly>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" rows="6" readonly><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Price</label>
                <input type="text" class="form-control" 
                    value="$<?php echo htmlspecialchars($product['price']); ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Stock Quantity</label>
                <input type="text" class="form-control" 
                    value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Created At</label>
                <input type="text" class="form-control" 
                    value="<?php echo htmlspecialchars($product['created_at']); ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Updated At</label>
                <input type="text" class="form-control" 
                    value="<?php echo htmlspecialchars($product['updated_at']); ?>" readonly>
            </div>
        </div>
    </div>
</div>


                    <!-- Edit Product Modal -->

                    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/admin/product_update/<?php echo htmlspecialchars($product['id']); ?>"
                                    method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Product ID</label>
                                                <input type="text" class="form-control" name="id"
                                                    value="<?php echo htmlspecialchars($product['id']); ?>" readonly>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label>Upload Image</label>
                                                <input type="file" class="form-control" name="image_url">
                                            </div>

                                            <div class="mb-3">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select class="form-select" id="category_id" name="category_id">
                                                    <option value="" disabled selected>Select a category</option>
                                                    <?php var_dump($categories) ?>
                                                    <?php foreach ($categories as $category): ?>
                                                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label>Description</label>
                                                <textarea class="form-control" name="description"
                                                    rows="6"><?php echo htmlspecialchars($product['description']); ?></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Price</label>
                                                <input type="text" class="form-control" name="price"
                                                    value="<?php echo htmlspecialchars($product['price']); ?>">
                                            </div>
                                           
                                            <div class="col-md-6 mb-3">
                                                <label>Stock Quantity</label>
                                                <input type="text" class="form-control" name="stock_quantity"
                                                    value="<?php echo htmlspecialchars($product['stock_quantity']); ?>">
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Save Changes</button>
                                        <button type="button" class="btn btn-danger "
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- SweetAlert Script -->
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
                    <script>
                        function updateProductProfile() {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Your product has been updated.',
                                icon: 'success',
                                confirmButtonColor: '#3B5D50'
                            });
                        }
                    </script>
                    <?php if (isset($message) && !empty($message)): ?>
        <script>
            Swal.fire({
                icon: '<?= $messageType ?>', 
                title: '<?= ucfirst($messageType) ?>',
                text: '<?= $message ?>',
                showConfirmButton: false,
                timer: 2000 
            });
        </script>
    <?php $message=null; endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                </div>
            </div>
        </div>
    </div>
</div>
