<?php require "views/partials/admin_header.php"; ?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="main-container">
                    <!-- Profile Card -->
                    <div class="card shadow-lg border-0">
                        <div class="m-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <?php
                                $imageSrc = !empty($category['image_url']) ? htmlspecialchars($category['image_url']) : 'images/product.png';
                                ?>
                                <img src="/public/<?= $imageSrc; ?>" alt="Profile Image" class="img-thumbnail"
                                     style="width: 100px; height: 100px;">

                                <h3 class="text-success ms-3">
                                    <?php
                                    $formattedName = str_replace('-', ' ', strtolower($category['category_name']));
                                    echo ucwords(htmlspecialchars($formattedName));
                                    ?>
                                </h3>
                            </div>
                            <button class="btn btn-success text-white" data-bs-toggle="modal"
                                    data-bs-target="#editProfileModal">
                                Edit Category
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Category ID</label>
                                    <input type="text" class="form-control"
                                           value="<?= htmlspecialchars($category['id']); ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control"
                                           value="<?= htmlspecialchars($category['category_name']); ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Created At</label>
                                    <input type="text" class="form-control"
                                           value="<?= htmlspecialchars($category['created_at']); ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Updated At</label>
                                    <input type="text" class="form-control"
                                           value="<?= htmlspecialchars($category['updated_at']); ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Category Modal -->
                    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Updated form tag with enctype attribute -->
                                <form action="/admin/category_update/<?= htmlspecialchars($category['id']); ?>"
                                      method="POST" enctype="multipart/form-data">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title text-white" id="editProfileModalLabel">Edit Category</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Category ID</label>
                                                <input type="text" class="form-control" name="id"
                                                       value="<?= htmlspecialchars($category['id']); ?>" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Category Name</label>
                                                <input type="text" class="form-control" name="category_name"
                                                       value="<?= htmlspecialchars($category['category_name']); ?>">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label>Upload Image</label>
                                                <input type="file" class="form-control" name="image_url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success text-white">Save Changes</button>
                                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- JavaScript & SweetAlert -->
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
                    <script>
                        function updateUserProfile() {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Your profile has been updated.',
                                icon: 'success',
                                confirmButtonColor: '#3B5D50'
                            });
                        }

                        function removeItem(itemName) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You want to remove " + itemName + " from your wishlist!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, remove it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        title: 'Removed!',
                                        text: itemName + ' has been removed from your wishlist.',
                                        icon: 'success',
                                        confirmButtonColor: '#3B5D50'
                                    });
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
