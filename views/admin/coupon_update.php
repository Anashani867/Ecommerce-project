<?php require "views/partials/admin_header.php"; ?>

<form action="/admin/coupon_update/<?= htmlspecialchars($coupon['id']); ?>" method="POST">
    <div class="row">
        <div class="col-md-6">
            <label>Code</label>
            <input type="text" class="form-control" name="coupon_id" value="<?= htmlspecialchars($coupon['code']); ?>" readonly>
        </div>
        <div class="col-md-6">
            <label>discount</label>
            <input type="text" class="form-control" name="price" value="<?= htmlspecialchars($coupon['discount']); ?>">
        </div>
        <div class="col-md-12 mt-3">
            <label>Usage Limit</label>
            <textarea class="form-control" name="description" rows="2"><?= htmlspecialchars($coupon['usage_limit']); ?></textarea>
        </div>
        <div class="col-md-6 mt-3">
            <label>Expiration date</label>
            <input type="text" class="form-control" name="category_id" value="<?= htmlspecialchars($coupon['expiration_date']); ?>">
        </div>
        <div class="col-md-6 mt-3">
            <label>Created At</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($coupon['created_at']); ?>" readonly>
        </div>
        <div class="col-md-6 mt-3">
            <label>Updated At</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($coupon['updated_at']); ?>" readonly>
        </div>
        <button type="submit" class="btn btn-success btn-sm mt-4 rounded shadow">Save Changes</button>
    </div>
</form>

<?php require "views/partials/admin_footer.php"; ?>
