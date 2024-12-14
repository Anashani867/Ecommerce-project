<?php
require "views/partials/admin_header.php";
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$filtered_products = array_filter($products, function ($product) use ($search_query) {
	return stripos($product['product_name'], $search_query) !== false ||
		stripos($product['description'], $search_query) !== false;
});

if ($search_query === '') {
	$filtered_products = $products;
}

$items_per_page = 20;
$current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$current_page = max($current_page, 1);
$start_index = ($current_page - 1) * $items_per_page;
$paginated_products = array_slice($filtered_products, $start_index, $items_per_page);
$total_items = count($filtered_products);
$total_pages = ceil($total_items / $items_per_page);
?>

<div class="app-wrapper">
	<div class="app-content pt-3 p-md-3 p-lg-4">
		<div class="container-xl">
			<div class="row g-3 mb-4 align-items-center justify-content-between shadow-sm p-3 bg-light rounded">
				<!-- Page Title -->
				<div class="col-auto">
					<h1 class="app-page-title mb-0 text-success fw-bold"
						style="font-size: 2rem; text-shadow: 1px 1px 2px #d4edda;">
						<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-columns-gap" fill="currentColor"
							xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd"
								d="M6 1H1v3h5V1zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12h-5v3h5v-3zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8H1v7h5V8zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6h-5v7h5V1zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z" />
						</svg>
						Products
					</h1>
				</div>
				<!-- Utilities and Search Form -->
				<div class="col-auto">
					<div class="page-utilities">
						<div class="row g-2 align-items-center">
							<!-- Search Form -->
							<div class="col-auto">
								<form class="docs-search-form row gx-1 align-items-center" method="GET" action="">
									<div class="col-auto">
										<input type="text" id="search-docs" name="search"
											value="<?php echo htmlspecialchars($search_query); ?>"
											class="form-control bg-light border-success rounded-pill"
											placeholder="Search Products....">
									</div>
									<div class="col-auto">
										<button type="submit" class="btn rounded-pill"
											style="background-color: #5bb377; border-color: #5bb377;">
											<i class="fas fa-search text-white"></i>
										</button>
									</div>
								</form>

							</div>
							<!-- Add New Product Button -->
							<div class="col-auto mt-3">
								<a class="btn btn-success text-white d-flex align-items-center rounded-pill px-3 py-2"
									href="#" data-bs-toggle="modal" data-bs-target="#createProductModal">
									<i class="bi bi-plus-circle me-2"></i> Add New Products
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Create Product Modal -->
			<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
				aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<form id="createProductForm" action="/admin/product_create" method="POST"
							enctype="multipart/form-data">
							<div class="modal-header p-0">
								<div
									class="w-100 bg-success text-white p-2 d-flex justify-content-between align-items-center">
									<h5 class="modal-title text-white" id="createProductModalLabel">Create New Product
									</h5>
									<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
										aria-label="Close"></button>
								</div>
							</div>
							<div class="modal-body">
								<div class="mb-3">
									<label for="product_name" class="form-label">Product Name</label>
									<input type="text" class="form-control" id="product_name" name="product_name">
								</div>
								<div class="mb-3">
									<label for="description" class="form-label">Description</label>
									<textarea class="form-control" id="description" name="description"
										rows="2"></textarea>
								</div>
								<div class="row mb-3">
									<div class="col">
										<label for="price" class="form-label">Price (JD)</label>
										<input type="number" class="form-control" id="price" name="price" step="0.01">
									</div>
									<div class="col">
										<label for="stock_quantity" class="form-label">Stock Quantity</label>
										<input type="number" class="form-control" id="stock_quantity"
											name="stock_quantity">
									</div>
								</div>
								<div class="mb-3">
									<label for="category_id" class="form-label">Category</label>
									<select class="form-select" id="category_id" name="category_id">
										<option value="" disabled selected>Select a category</option>
										<?php foreach ($categories as $category): ?>
											<option value="<?php echo htmlspecialchars($category['id']); ?>">
												<?php echo htmlspecialchars($category['category_name']); ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="mb-3">
									<label for="image_url" class="form-label">Product Image</label>
									<input type="file" class="form-control" id="image_url" name="image_url"
										accept="image/*">
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success text-white">Save Product</button>
								<button type="button" class="btn btn-danger text-white"
									data-bs-dismiss="modal">Close</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<table class="table table-hover table-borderless shadow-sm rounded">
				<thead class="table-success">
					<tr class="text-center">
						<th>ID</th>
						<th>Image</th>
						<th>Category</th>
						<th>Product Name</th>
						<th>Price</th>
						<th>Average Rating</th>
						<th>Stock Quantity</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($paginated_products as $product): ?>
						<tr class="text-center">
							<td><?php echo htmlspecialchars($product['id']); ?></td>
							<td>
								<?php
								$imageSrc = !empty($product['image_url']) ? htmlspecialchars($product['image_url']) : 'images/product.png';
								?>
								<img src="/public/<?= $imageSrc; ?>" class="img-thumbnail"
									style="width: 70px; height: 70px;">
							</td>
							<td><?php echo htmlspecialchars($product['category_name']); ?></td>
							<td class="text-truncate" style="max-width: 150px;">
								<?php
								$formattedName = str_replace('-', ' ', strtolower($product['product_name']));
								$formattedName = ucwords($formattedName);
								echo $formattedName;
								?>
							</td>
							<td>JD<?php echo number_format($product['price'], 2); ?></td>
							<td><?php echo number_format($product['average_rating'], 1); ?>/5</td>
							<td><?php echo (int) $product['stock_quantity']; ?></td>
							<td>
								<div class="d-flex justify-content-center">
									<a href="/admin/product_edit/<?= htmlspecialchars($product['id']); ?>"
										class="btn btn-success btn-sm me-2">
										<i class="bi bi-pencil"></i>
									</a>
									<form id="deleteForm-<?= htmlspecialchars($product['id']); ?>"
										action="/admin/deleteProduct" method="POST"
										onsubmit="return confirmDelete(event, '<?= htmlspecialchars($product['id']); ?>')">
										<input type="hidden" name="productId"
											value="<?= htmlspecialchars($product['id']); ?>">
										<button type="submit" class="btn btn-danger btn-sm">
											<i class="bi bi-trash"></i>
										</button>
									</form>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<nav class="app-pagination" style="margin-top: 50px; margin-bottom: -30px;">
				<ul class="pagination justify-content-center">
					<li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
						<a class="page-link bg-primary text-white"
							href="?page=<?= $current_page - 1 ?>&search=<?= urlencode($search_query) ?>" tabindex="-1"
							aria-disabled="true">Previous</a>
					</li>
					<?php for ($page = 1; $page <= $total_pages; $page++): ?>
						<li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
							<a class="page-link <?= $page == $current_page ? 'bg-success text-white' : 'bg-light text-dark' ?>"
								href="?page=<?= $page ?>&search=<?= urlencode($search_query) ?>"><?= $page ?></a>
						</li>
					<?php endfor; ?>
					<li class="page-item <?= $current_page >= $total_pages ? 'disabled' : '' ?>">
						<a class="page-link bg-primary text-white"
							href="?page=<?= $current_page + 1 ?>&search=<?= urlencode($search_query) ?>">Next</a>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</div>

<?php require "views/partials/admin_footer.php"; ?>

<script>
	function confirmDelete(event, customerId) {
		event.preventDefault(); // Prevent the form from submitting immediately

		// Trigger SweetAlert confirmation dialog
		Swal.fire({
			title: 'Are you sure?',
			text: "This action cannot be undone!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#D26D69',
			cancelButtonColor: '#15A362',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				// Submit the form if user confirms
				document.getElementById('deleteForm-' + customerId).submit();
			}
		});
	}
</script>
<script src="assets/js/app.js"></script>
<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<?php
if (isset($_SESSION['success'])) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{$_SESSION['success']}'
        });
    </script>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{$_SESSION['error']}'
        });
    </script>";
    unset($_SESSION['error']);
}
?>

<?php if (isset($message)): ?>
    <script>
        Swal.fire({
            icon: '<?= $messageType ?>',
            title: '<?= ucfirst($messageType) ?>',
            text: '<?= $message ?>',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>