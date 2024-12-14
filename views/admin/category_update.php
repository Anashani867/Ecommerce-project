<?php require "views/partials/admin_header.php"; ?>

<form action="/admin/category_update/<?= htmlspecialchars($category['id']); ?>" method="POST">
    <div class="row">
        <div class="col-md-6">
            <label>category ID</label>
            <input type="text" class="form-control" name="category_id" value="<?= htmlspecialchars($category['id']); ?>" readonly>
        </div>
        <div class="col-md-6">
            <label>Price</label>
            <input type="text" class="form-control" name="price" value="<?= htmlspecialchars($category['category_name']); ?>">
        </div>
        <div class="col-md-12 mt-3">
            <label>Description</label>
            <textarea class="form-control" name="" rows="2"><?= htmlspecialchars($category['image_url']); ?></textarea>
        </div>

        <div class="col-md-6 mt-3">
            <label>Created At</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($category['created_at']); ?>" readonly>
        </div>
        <div class="col-md-6 mt-3">
            <label>Updated At</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($category['updated_at']); ?>" readonly>
        </div>
        <button type="submit" class="btn btn-success btn-sm mt-4 rounded shadow">Save Changes</button>
    </div>
</form>

<?php require "views/partials/admin_footer.php"; ?>