<?php
require "views/partials/admin_header.php";

$items_per_page = 20;
$current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$current_page = max($current_page, 1);

// Ensure $customers is an array before using count()
$total_items = isset($customers) && is_array($customers) ? count($customers) : 0;
$total_pages = ceil($total_items / $items_per_page);
$start_index = ($current_page - 1) * $items_per_page;

// Check if search term is set and not empty
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filtered_customers = []; // Initialize to an empty array

if (!empty($search)) {
    // Ensure $customers is an array before filtering
    if (is_array($customers)) {
        // Filter customers based on search term
        $filtered_customers = array_filter($customers, function ($customer) use ($search) {
            return stripos($customer['first_name'], $search) !== false ||
                stripos($customer['last_name'], $search) !== false ||
                stripos($customer['email'], $search) !== false ||
                stripos($customer['phone_number'], $search) !== false ||
                stripos($customer['address'], $search) !== false;
        });
    }
} else {
    // If no search term is provided, use the original customers array
    $filtered_customers = is_array($customers) ? $customers : [];
}


// Update pagination logic after filtering
$total_items = count($filtered_customers);
$total_pages = ceil($total_items / $items_per_page);
$start_index = ($current_page - 1) * $items_per_page;
$paginated_customers = array_slice($filtered_customers, $start_index, $items_per_page);
?>
<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between shadow-sm p-3 bg-light rounded">
                <!-- Page Title with Enhanced Style -->
                <div class="col-auto">
                    <h1 class="app-page-title mb-0 text-success fw-bold"
                        style="font-size: 2rem; text-shadow: 1px 1px 2px #d4edda;">
                        <i class="fas fa-users me-3"></i>Customers
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
                                            value="<?php echo htmlspecialchars($search); ?>"
                                            class="form-control bg-light border-success rounded-pill"
                                            placeholder="Search Customers....">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn rounded-pill"
                                            style="background-color: #5bb377; border-color: #5bb377;">
                                            <i class="fas fa-search text-white"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- Create Customer Button -->
                            <div class="col-auto mt-3">
                                <a class="btn btn-success text-white d-flex align-items-center rounded-pill" href="#"
                                    data-bs-toggle="modal" data-bs-target="#createCustomerModal">
                                    <i class="bi bi-plus-circle me-2"></i> Add New Customer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Customer Modal -->
            <div class="modal fade" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="createCustomerForm" action="/admin/customer_create" method="POST"
                            enctype="multipart/form-data">
                            <div class="modal-header p-0">
                                <div
                                    class="w-100 bg-primary text-white p-2 d-flex justify-content-between align-items-center">
                                    <h5 class="modal-title text-white" id="createCustomerModalLabel">Create New Customer
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="first_name" class="form-label">First name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name">
                                    </div>
                                    <div class="col">
                                        <label for="last_name" class="form-label">Last name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="col">
                                        <label for="phone_number" class="form-label">Phone number</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn app-btn-primary">Create Customer</button>
                                <button type="button" class="btn btn-danger text-white"
                                    data-bs-dismiss="modal">Close</button>
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
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paginated_customers as $customer): ?>
                            <tr class="text-center">
                                <td><?php echo htmlspecialchars($customer['id']); ?></td>
                                <td>
                                    <?php
                                    $imageSrc = !empty($customer['image_url']) ? htmlspecialchars($customer['image_url']) : 'images/user-profile.png';
                                    ?>
                                    <img src="/public/<?= $imageSrc; ?>" class="img-thumbnail"
                                        style="width: 50px; height: 50px;">
                                </td>
                                <td class="text-center" style="max-width: 150px;">
                                    <?php echo htmlspecialchars($customer['first_name']); ?>
                                </td>
                                <td class="text-center" style="max-width: 150px;">
                                    <?php echo htmlspecialchars($customer['last_name']); ?>
                                </td>
                                <td class="text-truncate" style="max-width: 120px;">
                                    <?php echo htmlspecialchars($customer['email']); ?>
                                </td>
                                <td class="text-truncate" style="max-width: 120px;">
                                    <?php echo htmlspecialchars($customer['phone_number']); ?>
                                </td>
                                <td class="text-truncate" style="max-width: 120px;">
                                    <?php echo htmlspecialchars($customer['address'] ?? ""); ?>
                                </td>
                                <td>
                                    <?php
                                    $date = new DateTime($customer['created_at']);
                                    echo htmlspecialchars($date->format('d-m-Y'));
                                    ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="/admin/customer_edit/<?= htmlspecialchars($customer['id']); ?>"
                                            class="btn btn-success btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form id="deleteForm-<?= htmlspecialchars($customer['id']); ?>"
                                            action="/admin/deleteCustomer" method="POST"
                                            onsubmit="return confirmDelete(event, '<?= htmlspecialchars($customer['id']); ?>')"
                                            class="ms-2">
                                            <input type="hidden" name="id"
                                                value="<?= htmlspecialchars($customer['id']); ?>">
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
            <?php if ($total_pages > 1): ?>
                <nav class="app-pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $current_page == 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?= $current_page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $current_page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $current_page == $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?= $current_page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.getElementById('createCustomerForm').addEventListener('submit', function (create) {
        create.preventDefault(); // Prevent the default form submission

        // Get values from the input fields
        var firstName = document.getElementById('first_name').value.trim();
        var lastName = document.getElementById('last_name').value.trim();
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();
        var phoneNumber = document.getElementById('phone_number').value.trim();

        // Check if any of the required fields are empty
        if (!firstName || !lastName || !email || !password || !phoneNumber) {
            Swal.fire({
                icon: 'warning',
                title: 'Error!',
                confirmButtonColor: "#d98380",
                cancelButtonColor: "#d98380",
                text: 'Please fill out all required fields!',
                confirmButtonText: 'OK'
            });
            return; // Exit the function
        }

        // If all fields are filled, submit the form
        this.submit();
    });

    function confirmDelete(create, id) {
        create.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("deleteForm-" + id).submit();
                Swal.fire("Deleted!", "The customer has been deleted.", "success");
            }
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<?php require "views/partials/admin_footer.php"; ?>