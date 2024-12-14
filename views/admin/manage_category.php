<?php
require "views/partials/admin_header.php";
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$filtered_categories = array_filter($categories, function ($category) use ($search_query) {
    return stripos($category['category_name'], $search_query) !== false;
});

if ($search_query === '') {
    $filtered_categories = $categories;
}


$items_per_page = 20;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max($current_page, 1);


$total_items = isset($categories) && is_array($categories) ? count($categories) : 0;
$total_pages = ceil($total_items / $items_per_page);
$start_index = ($current_page - 1) * $items_per_page;


$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filtered_categories = [];
if (!empty($search)) {

    if (is_array($categories)) {

        $filtered_categories = array_filter($categories, function ($category) use ($search) {
            return stripos($category['id'], $search) !== false ||
                stripos($category['category_name'], $search) !== false;
        });
    }
} else {

    $filtered_categories = is_array($categories) ? $categories : [];
}


$total_items = count($filtered_categories);
$total_pages = ceil($total_items / $items_per_page);
$start_index = ($current_page - 1) * $items_per_page;
$paginated_categories = array_slice($filtered_categories, $start_index, $items_per_page);
?>
    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']); ?></div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                <div class="row g-3 mb-4 align-items-center justify-content-between shadow-sm p-3 bg-light rounded">

                    <div class="col-auto">
                        <h1 class="app-page-title mb-0 text-success fw-bold"
                            style="font-size: 2rem; text-shadow: 1px 1px 2px #d4edda;">
                            <i class="fas fa-receipt"></i>
                            Category

                        </h1>
                    </div>

                    <div class="col-auto">
                        <div class="page-utilities">
                            <div class="row g-2 align-items-center">

                                <div class="col-auto">
                                    <form class="docs-search-form row gx-1 align-items-center" method="GET" action="">
                                        <div class="col-auto">
                                            <input type="text" id="search-docs" name="search"
                                                   value="<?php echo htmlspecialchars($search); ?>"
                                                   class="form-control bg-light border-success rounded-pill"
                                                   placeholder="Search categories....">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn rounded-pill"
                                                    style="background-color: #5bb377; border-color: #5bb377;">
                                                <i class="fas fa-search text-white"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-auto mt-3">
                                    <a class="btn btn-success text-white d-flex align-items-center rounded-pill"
                                       href="#"
                                       data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                                        <i class="bi bi-plus-circle me-2"></i> Add New category
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create category Modal -->
                <div class="modal fade" id="createCategoryModal" tabindex="-1"
                     aria-labelledby="createCategoryModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="createCategoryForm" method="POST" enctype="multipart/form-data"
                                  onsubmit="submitCategoryForm(event)">

                                <div class="modal-header p-0">
                                    <div
                                            class="w-100 bg-primary text-white p-2 d-flex justify-content-between align-items-center">
                                        <h5 class="modal-title text-white" id="createCategoryModalLabel">Create New
                                            category
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="category_name" class="form-label">Category Name</label>
                                            <input type="text" class="form-control" id="category_name"
                                                   name="category_name"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="image_url" class="form-label">image url</label>
                                            <input type="file" class="form-control" id="image_url" name="image_url"
                                                   required>

                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn app-btn-primary">Create category</button>
                                    <button type="button" class="btn btn-danger text-white"
                                            data-bs-dismiss="modal">Close
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-borderless shadow-sm rounded">
                        <thead class="table-success">
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Image</th>
                            <th>Category Name</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($paginated_categories as $category): ?>
                            <tr class="text-center">
                                <td><?php echo htmlspecialchars($category['id']); ?></td>
                                <td>
                                    <?php
                                    $imageSrc = !empty($category['image_url']) ? htmlspecialchars($category['image_url']) : 'images/user-profile.png';
                                    ?>
                                   <img src="/public/<?= htmlspecialchars($category['image_url']) . '?' . time(); ?>" class="img-thumbnail" style="width: 50px; height: 50px;">

                                </td>
                                <td class="text-truncate" style="max-width: 150px;">
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="/admin/category_edit/<?= htmlspecialchars($category['id']); ?>"
                                           class="btn btn-success btn-sm me-2">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form id="deleteForm-<?= htmlspecialchars($category['id']); ?>"
                                              action="/admin/deleteCategory" method="POST"
                                              onsubmit="return confirmDelete(event, '<?= htmlspecialchars($category['id']); ?>')"
                                              class="ms-2">
                                            <input type="hidden" name="categoryId"
                                                   value="<?= htmlspecialchars($category['id']); ?>">
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
                </div>
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
 <!-- Load SweetAlert2 only (Remove SweetAlert1) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Load Popper.js and Bootstrap for functionality if needed -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
    // Function to submit the category form with AJAX
    function submitCategoryForm(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(document.getElementById('createCategoryForm'));

        fetch('/admin/category_create', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Display success message with SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Category Added',
                text: 'Category added successfully!',
            }).then(() => {
                location.reload(); // Optionally refresh the page or update the category list
            });
        })
        .catch(error => {
            console.error('Error:', error);
            // Display error with SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong!',
            });
        });
    }

    // Function to confirm deletion with SweetAlert2
    function confirmDelete(event, id) {
        event.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#D26D69",
            cancelButtonColor: "#15A362",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Delay before submitting the form
                setTimeout(() => {
                    document.getElementById("deleteForm-" + id).submit();
                }, 1000); // 1000 milliseconds = 1 second

                Swal.fire("Deleted!", "The category has been deleted.", "success");
            }
        });
    }
</script>

<!-- Display session messages with SweetAlert2 if available -->
<?php if (isset($_SESSION['message']) && !empty($_SESSION['message'])): ?>
    <script>
        Swal.fire({
            icon: '<?= htmlspecialchars($_SESSION['messageType']) ?>',
            title: '<?= ucfirst(htmlspecialchars($_SESSION['messageType'])) ?>',
            text: '<?= htmlspecialchars($_SESSION['message']) ?>',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    <?php unset($_SESSION['message'], $_SESSION['messageType']); ?>
<?php endif; ?>

<?php require "views/partials/admin_footer.php"; ?>