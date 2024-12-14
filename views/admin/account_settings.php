<?php
require "views/partials/admin_header.php";
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0 text-success">admins</h1>
                </div>
                <div class="col-auto">
                    <div class="page-utilities">
                        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                            <div class="col-auto">
                                <form class="docs-search-form row gx-1 align-items-center" method="GET" action="">
                                    <div class="col-auto">
                                    
                                    </div>
                                </form>
                            </div>
                            <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="/admin/admin_update/<?= htmlspecialchars($admin['id']); ?>" method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editProfileModalLabel">Edit admin</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>admin ID</label>
                                                        <input type="text" class="form-control" name="id" value="<?= htmlspecialchars($admin['id']); ?>" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Customer ID</label>
                                                        <input type="text" class="form-control" name="customer_id" value="<?= htmlspecialchars($admin['username']); ?>">
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <label>admin Date</label>
                                                        <textarea class="form-control" name="description" rows="2"><?= htmlspecialchars($admin['email']); ?></textarea>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label>Status</label>
                                                        <input type="text" class="form-control" name="status" value="<?= htmlspecialchars($admin['password']); ?>">
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label>Coupon ID</label>
                                                        <input type="text" class="form-control" name="admin_id" value="<?= htmlspecialchars($admin['role']); ?>">
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label>Total Amount</label>
                                                        <input type="text" class="form-control" name="total_amount" value="<?= htmlspecialchars($admin['created_at']); ?>">
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label>Total Amount</label>
                                                        <input type="text" class="form-control" name="total_amount" value="<?= htmlspecialchars($admin['updated_at']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- "Create" Button -->
                          

                            <!-- Create admin Modal -->
                            <div class="modal fade" id="createadminModal" tabindex="-1" aria-labelledby="createadminModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="/admin/admin_create" method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="createadminModalLabel">Create New admin</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="id" class="form-label">ID</label>
                                                    <input type="text" class="form-control" id="id" name="id" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="customer_id" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="admin_date" class="form-label">email</label>
                                                    <textarea class="form-control" id="email" name="email" rows="2" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Password</label>
                                                    <input type="text" class="form-control" id="password" name="password" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="coupon_id" class="form-label">Role</label>
                                                    <input type="text" class="form-control" id="role" name="role">
                                                </div>
                                        
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save admin</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="container-xl">
    <div class="row gy-4">

            <div class="col-12 col-lg-12">
                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
                    <div class="app-card-header p-3 border-bottom-0">
                        <div class="row align-items-center gx-3">
                            <div class="col-auto">
                                <div class="app-icon-holder">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                    </svg>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="app-card-body px-4 w-100">
                   
                        <div class="item border-bottom py-2">
                            <div class="item-label"><strong>Email:</strong></div>
                            <div class="item-data"><?= htmlspecialchars($admin['email']); ?></div>
                        </div>
                      
                        <div class="item border-bottom py-2">
                            <div class="item-label"><strong>Role:</strong></div>
                            <div class="item-data"><?= htmlspecialchars($admin['role']); ?></div>
                        </div>
                        <div class="item border-bottom py-2">
                            <div class="item-label"><strong>Created At:</strong></div>
                            <div class="item-data"><?= htmlspecialchars($admin['created_at']); ?></div>
                        </div>
                        <div class="item border-bottom py-2">
                            <div class="item-label"><strong>Updated At:</strong></div>
                            <div class="item-data"><?= htmlspecialchars($admin['updated_at']); ?></div>
                        </div>
                    </div>
                    <div class="app-card-footer p-4 mt-auto">
                    
                    </div>
                </div>
            </div>
    
    </div>
</div>

<style>
    
</style>




<?php
require "views/partials/admin_footer.php";
?>