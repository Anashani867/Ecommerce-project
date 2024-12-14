<?php require "views/partials/admin_header.php";

$search_status = isset($_GET['status']) ? $_GET['status'] : '';
$paginated_reviews = []; // Initialize the paginated reviews variable

// Filter reviews based on the selected status
if ($search_status) {
    $paginated_reviews = array_filter($reviews, function ($review) use ($search_status) {
        return $review['status'] === $search_status;
    });
} else {
    $paginated_reviews = $reviews; // Use all reviews if no status is set
}

// Pagination logic
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$reviews_per_page = 10; // Number of reviews per page
$total_reviews = count($paginated_reviews);
$total_pages = ceil($total_reviews / $reviews_per_page);

// Get the reviews for the current page
$offset = ($current_page - 1) * $reviews_per_page;
$current_reviews = array_slice($paginated_reviews, $offset, $reviews_per_page);
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between shadow-sm p-3 bg-light rounded">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0 text-success fw-bold"
                        style="font-size: 2rem; text-shadow: 1px 1px 2px #d4edda;">
                        <i class="fas fa-star me-3"></i>Product Reviews
                    </h1>
                </div>
            </div>

            <nav id="orders-table-tab" role="group" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
                <a style="<?= $search_status === '' ? 'background-color: #5BB377; color: #fff; font-weight: bold;' : ''; ?>"
                   class="flex-sm-fill text-sm-center nav-link <?= $search_status === '' ? 'active' : ''; ?>" href="?status=">
                    <i class="fas fa-list-ul"></i> All
                </a>
                <a style="<?= $search_status === 'pending' ? 'background-color: #f0ad4e; color: #fff; font-weight: bold;' : ''; ?>"
                        class="flex-sm-fill text-sm-center nav-link <?= $search_status === 'pending' ? 'active' : ''; ?>"
                   href="?status=pending" id="orders-pending-tab">
                    <i class="fas fa-hourglass-half"></i> Pending
                </a>
                <a style="<?= $search_status === 'accepted' ? 'background-color: #5cb85c; color: #fff; font-weight: bold;' : ''; ?>"
                        class="flex-sm-fill text-sm-center nav-link <?= $search_status === 'accepted' ? 'active' : ''; ?>"
                   href="?status=accepted" id="orders-completed-tab">
                    <i class="fas fa-check-circle"></i> Accepted
                </a>
                <a style="<?= $search_status === 'rejected' ? 'background-color: #d9534f; color: #fff; font-weight: bold;' : ''; ?>"
                        class="flex-sm-fill text-sm-center nav-link <?= $search_status === 'rejected' ? 'active' : ''; ?>"
                   href="?status=rejected" id="orders-cancelled-tab">
                    <i class="fas fa-times-circle"></i> Rejected
                </a>
            </nav>

            <div class="table-responsive">
                <table class="table table-hover table-borderless shadow-sm rounded">
                    <thead class="table-success">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Customer ID</th>
                        <th>Product ID</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($current_reviews)): ?>
                        <?php foreach ($current_reviews as $review): ?>
                            <tr class="text-center">
                                <td><?= htmlspecialchars($review['id']); ?></td>
                                <td><?= htmlspecialchars($review['customer_id']); ?></td>
                                <td><?= htmlspecialchars($review['product_id']); ?></td>
                                <td>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?= ($i <= $review['rating']) ? '-fill' : '' ?> text-success"></i>
                                    <?php endfor; ?>
                                </td>
                                <td class="text-truncate" style="max-width: 150px;"><?= htmlspecialchars($review['comment']); ?></td>
                                <td><?= date('d M Y', strtotime($review['created_at'])); ?></td>
                                <td class="<?php
                                if ($review['status'] === 'pending') {
                                    echo 'text-warning';
                                } elseif ($review['status'] === 'rejected') {
                                    echo 'text-danger';
                                } elseif ($review['status'] === 'accepted') {
                                    echo 'text-success';
                                }
                                ?>">
                                    <?= htmlspecialchars(ucfirst($review['status'])); ?>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form action="/admin/acceptReview" method="POST" class="ms-2">
                                            <input type="hidden" name="reviewId" value="<?= htmlspecialchars($review['id']); ?>">
                                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                        </form>
                                        <form action="/admin/rejectReview" method="POST" class="ms-2">
                                            <input type="hidden" name="reviewId" value="<?= htmlspecialchars($review['id']); ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No reviews available.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <nav class="app-pagination" style="margin-top: 50px; margin-bottom: -30px;">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link bg-primary text-white" href="?page=<?= $current_page - 1 ?>&status=<?= urlencode($search_status) ?>" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                        <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                            <a class="page-link <?= $page == $current_page ? 'bg-success text-white' : 'bg-light text-dark' ?>" href="?page=<?= $page ?>&status=<?= urlencode($search_status) ?>"><?= $page ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link bg-primary text-white" href="?page=<?= $current_page + 1 ?>&status=<?= urlencode($search_status) ?>">Next</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php require "views/partials/admin_footer.php"; ?>

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
