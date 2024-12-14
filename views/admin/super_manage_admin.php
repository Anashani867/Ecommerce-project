<?php require "views/partials/admin_header.php"; ?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                
                <div class="container my-5">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-4 text-success fw-bold"
                            style="font-size: 2rem; text-shadow: 1px 1px 2px #d4edda;">
                            <i class="fas fa-user-shield me-2"></i> Admins
                        </h1>
                    </div>

                    <div class="table-responsive mb-5">
                        <table class="table table-hover table-borderless shadow-sm rounded">
                            <thead class="table-success">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($admins as $admin): ?>
                                    <tr class="text-center">
                                        <td><?php echo htmlspecialchars($admin['id']); ?></td>
                                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                                        <td><?php echo htmlspecialchars($admin['role']); ?></td>
                                        <td>
                                            <form action="delete_admin" method="POST" class="d-inline delete-admin-form">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($admin['id']); ?>">
                                                <button type="button" class="btn btn-danger btn-sm delete-admin-btn">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="col-auto mb-4">
                        <h1 class="app-page-title mb-4 text-success fw-bold"
                            style="font-size: 2rem; text-shadow: 1px 1px 2px #d4edda;">
                            <i class="fas fa-user-plus me-2"></i>Add New Admin
                        </h1>
                    </div>
                  
                    <div class="card shadow mb-5">
                        <div class="card-body">
                            <form id="addAdminForm" action="add_admin" method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="admin">Admin</option>
                                        <option value="super_admin">Super Admin</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success text-white">Add Admin</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Handle SweetAlert for Add Admin Form
    document.getElementById('addAdminForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Show SweetAlert for confirmation
        Swal.fire({
            title: 'Admin Added!',
            text: 'The admin has been added successfully.',
            icon: 'success',
            confirmButtonColor: '#3B5D50',
            timer: 1500
        }).then(() => {
            this.submit(); // Submit the form after the alert is closed
        });
    });

    // Handle delete confirmation
    document.querySelectorAll('.delete-admin-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.delete-admin-form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#D26D69',
                cancelButtonColor: '#5bb377',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(() => {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The user has been deleted.',
                            icon: 'success',
                            confirmButtonColor: '#3B5D50'
                        }).then(() => {
                            form.submit();
                        });
                    }, 300);
                }
            });
        });
    });
</script>
