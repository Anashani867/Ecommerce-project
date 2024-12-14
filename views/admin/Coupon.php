<?php require "views/partials/admin_header.php"; ?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between shadow-sm p-3 bg-light rounded">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0 text-success fw-bold"
                        style="font-size: 2rem; text-shadow: 1px 1px 2px #d4edda;">
                        <i class="fas fa-tags me-3"></i> Coupons
                    </h1>
                </div>
                <div class="col-auto">
    <a class="btn btn-success text-white d-flex align-items-center rounded-pill" href="#" 
        data-bs-toggle="modal" data-bs-target="#addCouponModal">
        <i class="bi bi-plus-circle me-2"></i> Add New Coupon
    </a>
</div>
            </div>

            <!-- Coupons Table -->
            <div class="table-responsive">
                <table class="table table-hover table-borderless shadow-sm rounded">
                    <thead class="table-success">
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Coupon Code</th>
                            <th>Discount</th>
                            <th>Usage Limit</th>
                            <th>Expiration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coupons as $coupon): ?>
                            <tr class="text-center">
                                <td><?= htmlspecialchars($coupon['id']); ?></td>
                                <td><?= htmlspecialchars($coupon['code']); ?></td>
                                <td><?= htmlspecialchars($coupon['discount']); ?>%</td>
                                <td><?php echo htmlspecialchars($coupon['usage_limit']); ?></td>
                                <td><?php echo htmlspecialchars($coupon['expiration_date']); ?></td>
                                <td>
                                    <form id="deleteForm-<?= htmlspecialchars($coupon['id']); ?>" action="/admin/CouponDelete" method="POST" style="display:inline;">
                                        <input type="hidden" name="couponId" value="<?= htmlspecialchars($coupon['id']); ?>">
                                        <button type="button" class="btn btn-danger btn-sm" title="Delete" onclick="confirmDeletecp(<?= htmlspecialchars($coupon['id']); ?>)">
                                        <i class="bi bi-trash"></i> <!-- Garbage icon -->
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Coupon Modal -->
            <div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCouponModalLabel">Add New Coupon</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/admin/addCoupon" method="POST">
                                <div class="form-group mb-3">
                                    <label for="code">Coupon Code</label>
                                    <input type="text" name="code" id="code" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="discount">Discount (%)</label>
                                    <input type="number" name="discount" id="discount" class="form-control" required min="0" max="100" step="0.01">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="usage_limit">Usage Limit</label>
                                    <input type="number" name="usage_limit" id="usage_limit" class="form-control" min="0">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="expiration_date">Expiration Date</label>
                                    <input type="datetime-local" name="expiration_date" id="expiration_date" class="form-control">
                                </div>
                                <div class="modal-footer">
                                <button type="submit" class="btn btn-success text-white">Add Coupon</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require "views/partials/admin_footer.php"; ?>

<!-- Include SweetAlert2 and Bootstrap JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<script>
function confirmDeletecp(couponId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the delete form if confirmed
            document.getElementById('deleteForm-' + couponId).submit();
        }
    });
}
</script>
<?php if (isset($_SESSION['error'])): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '<?= htmlspecialchars($_SESSION['error']); ?>'
    });
</script>
<?php unset($_SESSION['error']); endif; ?>

<?php if (isset($_SESSION['message'])): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '<?= htmlspecialchars($_SESSION['message']); ?>'
    });
</script>
<?php unset($_SESSION['message']); endif; ?>