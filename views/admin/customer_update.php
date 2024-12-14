<?php require "views/partials/admin_header.php"; ?>
<link href="/public/css/user_profile_style.css" rel="stylesheet">

<body>
    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="main-container">
                        <!-- Profile Section -->
                        <form action="/admin/customer_update/<?= htmlspecialchars($customer['id']); ?>" method="POST"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProfileModalLabel">Edit Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <!-- Customer Details Form Fields -->
                                    <div class="col-md-6">
                                        <label>Customer ID</label>
                                        <input type="text" class="form-control" name="id"
                                            value="<?= htmlspecialchars($customer['id']); ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email"
                                            value="<?= htmlspecialchars($customer['email']); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>User Name</label>
                                        <input type="text" class="form-control" name="username"
                                            value="<?= htmlspecialchars($customer['username']); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="first_name"
                                            value="<?= htmlspecialchars($customer['first_name']); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="last_name"
                                            value="<?= htmlspecialchars($customer['last_name']); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number"
                                            value="<?= htmlspecialchars($customer['phone_number']); ?>">
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label>Upload Image</label>
                                        <input type="file" class="form-control" name="image_url">

                                    </div>
                                
                                    <div class="col-md-12 mt-3 mb-3">
                                        <label>Address</label>
                                        <textarea class="form-control" name="address"
                                            rows="5"><?= htmlspecialchars($customer['address']); ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                        </form>
                    </div>

                    <!-- SweetAlert Script -->
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
                    <script>
                        function showAlert(title, text, icon) {
                            Swal.fire({
                                title: title,
                                text: text,
                                icon: icon,
                                confirmButtonColor: '#3B5D50'
                            });
                        }

                        function updateUserProfile() {
                            showAlert('Success!', 'Your profile has been updated.', 'success');
                        }

                        function confirmRemoveItem(itemName) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: `You want to remove ${itemName} from your wishlist!`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, remove it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    showAlert('Removed!', `${itemName} has been removed from your wishlist.`, 'success');
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>