<?php require "views/partials/admin_header.php"; ?>


<body>
    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="main-container">
                        <!-- Profile Card -->
                        <div class="card shadow-lg border-0">
                            <div class="d-flex justify-content-between align-items-center p-4">
                                <div class="d-flex align-items-center">
                                    <img src="../images/shahed.jpeg" alt="Coupon Image" class="rounded-circle" style="width: 100px; height: 100px;">
                                    <h3 class="text-success ms-3 fw-bold">
                                        <?php
                                        $formattedName = str_replace('-', ' ', strtolower($coupon['code']));
                                        $formattedName = ucwords($formattedName);
                                        echo htmlspecialchars($formattedName);
                                        ?>
                                    </h3>
                                </div>
                                <button class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    Edit Coupon
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Coupon ID</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($coupon['id']); ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Discount</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($coupon['discount']); ?>" readonly>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Usage Limit</label>
                                        <textarea class="form-control" rows="2" readonly><?php echo htmlspecialchars($coupon['usage_limit']); ?></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Expiration Date</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($coupon['expiration_date']); ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Created At</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($coupon['created_at']); ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Updated At</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($coupon['updated_at']); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Editing Coupon -->
                    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/admin/coupon_update/<?php echo htmlspecialchars($coupon['id']); ?>" method="POST">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title text-white" id="editProfileModalLabel">Edit Coupon</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Coupon ID</label>
                                                <input type="text" class="form-control" name="id" value="<?php echo htmlspecialchars($coupon['id']); ?>" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Code</label>
                                                <input type="text" class="form-control" name="code" value="<?php echo htmlspecialchars($coupon['code']); ?>">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label>Discount</label>
                                                <textarea class="form-control" name="discount" rows="2"><?php echo htmlspecialchars($coupon['discount']); ?></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Usage Limit</label>
                                                <input type="text" class="form-control" name="usage_limit" value="<?php echo htmlspecialchars($coupon['usage_limit']); ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Expiration Date</label>
                                                <input type="date" class="form-control" name="expiration_date" value="<?php echo htmlspecialchars($coupon['expiration_date']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Save Changes</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- SweetAlert Script -->
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
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
