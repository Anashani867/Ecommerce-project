<?php
require "views/partials/admin_header.php";
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$search_status = isset($_GET['status']) ? $_GET['status'] : '';
$filtered_messages = $messages;

// Apply filters
if ($search_status) {
    $filtered_messages = array_filter($filtered_messages, function ($message) use ($search_status) {
        return $message['status'] === $search_status;
    });
}

if ($search_query !== '') {
    $filtered_messages = array_filter($filtered_messages, function ($message) use ($search_query) {
        return stripos($message['content'], $search_query) !== false ||
            stripos($message['status'], $search_query) !== false;
    });
}

// Pagination
$items_per_page = 20;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_items = count($filtered_messages);
$total_pages = ceil($total_items / $items_per_page);
$current_page = max(min($current_page, $total_pages), 1);
$start_index = ($current_page - 1) * $items_per_page;
$paginated_messages = array_slice($filtered_messages, $start_index, $items_per_page);
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between shadow-sm p-3 bg-light rounded">
                <!-- Page Title -->
                <div class="col-auto">
                    <h1 class="app-page-title mb-0 text-success fw-bold"
                        style="font-size: 2rem; text-shadow: 1px 1px 2px #d4edda;">
                        <i class="fas fa-comments"></i>
                        Messages
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
                                               value="<?= htmlspecialchars($search_query) ?>"
                                               class="form-control bg-light border-success rounded-pill"
                                               placeholder="Search Messages....">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn rounded-pill"
                                                style="background-color: #5bb377; border-color: #5bb377;">
                                            <i class="fas fa-search text-white"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <nav id="orders-table-tab" role="group" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
                <a style="<?= $search_status === '' ? 'background-color: #5BB377; color: #fff; font-weight: bold;' : ''; ?>"
                   class="flex-sm-fill text-sm-center nav-link <?= $search_status === '' ? 'active' : ''; ?>" href="?status=">
                    <i class="fas fa-list-ul"></i> All
                </a>
                <a style="<?= $search_status === 'resolved' ? 'background-color: #5cb85c; color: #fff; font-weight: bold;' : ''; ?>"
                   class="flex-sm-fill text-sm-center nav-link <?= $search_status === 'resolved' ? 'active' : ''; ?>"
                   href="?status=resolved" id="orders-completed-tab">
                    <i class="fas fa-check-circle"></i> Resolved
                </a>
                <a style="<?= $search_status === 'unresolved' ? 'background-color: #d9534f; color: #fff; font-weight: bold;' : ''; ?>"
                   class="flex-sm-fill text-sm-center nav-link <?= $search_status === 'unresolved' ? 'active' : ''; ?>"
                   href="?status=unresolved" id="orders-cancelled-tab">
                    <i class="fas fa-times-circle"></i> Unresolved
                </a>
            </nav>

            <table class="table table-hover table-borderless shadow-sm rounded">
                <thead class="table-success">
                    <tr class="text-center">
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($paginated_messages as $message): ?>
                    <tr class="text-center">
                        <td><?php echo htmlspecialchars($message['customer_id']); ?></td>
                        <td><?= htmlspecialchars($message['customer_name'] ?? 'N/A') ?></td>
                        <td><?php echo htmlspecialchars($message['content']); ?></td>
                        <td class="<?php
                        if ($message['status'] === 'unresolved') {
                            echo 'text-danger';
                        } elseif ($message['status'] === 'resolved') {
                            echo 'text-success';
                        }
                        ?>"
                        ><?php echo htmlspecialchars(ucwords(strtolower($message['status']))); ?></td>
                        <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                        <td>
                            <button class="btn btn-outline-success" onclick="window.open('https://mail.google.com/mail/u/0/?ogbl#inbox', '_blank')">Reply</button>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<style>
    /* Base styles for each status tab */
    #orders-table-tab a#orders-all-tab {
        color: #5BB377; /* Green for All */
    }

    #orders-table-tab a#orders-pending-tab {
        color: #f0ad4e; /* Orange for Pending */
    }

    #orders-table-tab a#orders-completed-tab {
        color: #5cb85c; /* Dark Green for Completed */
    }

    #orders-table-tab a#orders-cancelled-tab {
        color: #d9534f; /* Red for Canceled */
    }

    /* Active state styles */
    #orders-table-tab .nav-link.active {
        color: #fff;
        font-weight: bold;
    }
</style>
