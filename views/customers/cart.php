<?php

require "views/partials/header.php"; ?>
<!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<div class="untree_co-section before-footer-section bg-light py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8">
                <form class="mb-4" method="post">
                    <div class="site-blocks-table">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th class="product-thumbnail">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $subtotal = 0; // Initialize subtotal
                            if (isset($cart) && !empty($cart)):
                                foreach ($cart as $product_id => $product):
                                    $total = $product['price'] * $product['quantity'];
                                    $subtotal += $total;
                                    ?>
                                    <tr>
                                        <td class="product-thumbnail">
                                            <img style="height: 80px; width: 80px; object-fit: contain;"
                                                 src="<?= htmlspecialchars('/public/' . $product['image']) ?>"
                                                 alt="<?= htmlspecialchars($product['name'] ?? 'Product Image') ?>">
                                        </td>


                                        <td class="product-name">
                                            <b><?= htmlspecialchars(ucwords(str_replace(['-', '_'], ' ', $product['name']))); ?></b>
                                        </td>
                                        <td class="product-price">JD<?= number_format($product['price'], 2); ?></td>
                                        <td class="product-quantity">
                                        <form action="/customers/cart/update" method="post" class="quantity-form">
    <input type="hidden" name="product_id" value="<?= $product_id; ?>">

    <!-- Decrease button -->
    <button type="button" onclick="updateQuantity('<?= $product_id ?>', -1)" class="quantity-button border-0">−</button>

    <!-- Quantity display -->
    <span class="quantity-display"><?= htmlspecialchars($product['quantity']); ?></span>

    <!-- Increase button -->
    <button type="button" onclick="updateQuantity('<?= $product_id ?>', 1)" class="quantity-button border-0">+</button>
</form>

                        
                                        </td>
                                        <td class="product-total">JD<?= number_format($total, 2); ?></td>
                                        <td class="product-remove">
                                            <button onclick="removeProduct('<?php echo $product_id; ?>')"
                                                    style="border: none; background: none; padding: 0; cursor: pointer; font-size: 30px;">
                                                &times;
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No items in the cart</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <a href="shop" class="btn btn-primary m-4">Continue Shopping</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
    <div class="border p-4 rounded bg-white mb-4">
        <h3 class="text-black h5 text-uppercase text-center mb-4">Cart Totals</h3>

        <!-- Subtotal Row -->
        <div class="row mb-2">
            <div class="col-md-6">
                <span class="text-black">Subtotal</span>
            </div>
            <div class="col-md-6 text-end">
                <strong class="text-black">
                    JD<?php echo number_format($subtotal, 2); ?>
                </strong>
            </div>
        </div>

        <!-- Discount Row (if applicable) -->
        <?php if (isset($_SESSION['discount']) && $_SESSION['discount'] > 0): ?>
            <?php 
                // Calculate the discount amount based on the percentage
                $discountAmount = ($subtotal * $_SESSION['discount']) / 100;
            ?>
            <div class="row mb-2">
                <div class="col-md-6">
                    <span class="text-black">Discount (<?= $_SESSION['discount'] ?>%)</span>
                </div>
                <div class="col-md-6 text-end">
                    <strong class="text-black">- JD<?php echo number_format($discountAmount, 2); ?></strong>
                </div>
            </div>
        <?php endif; ?>

        <!-- Total Row -->
        <div class="row mb-4">
            <div class="col-md-6">
                <span class="text-black">Total</span>
            </div>
            <div class="col-md-6 text-end">
                <strong class="text-black" id="cartFinalTotal">
                    JD<?= number_format($subtotal - ($discountAmount ?? 0), 2); ?>
                </strong>
            </div>
        </div>

                        <div class="row">
                            <div class="col-md-12">
                            <a href="checkout" class="btn btn-primary d-flex justify-content-center">Proceed to Checkout</a>
                            </div>
                        </div>

                    </div>

                    <div class="border p-4 rounded bg-white">
                        <h5 class="text-black mb-4">Coupon Code</h5>
                        <p>Enter your coupon code if you have one.</p>

                        <?php if (isset($_SESSION['discount']) && $_SESSION['discount'] > 0): ?>
                            <!-- Coupon applied, show the Remove button -->
                            <form method="post" action="/customers/cart/remove-coupon" class="d-inline">
                                <button type="submit" class="btn btn-primary btn-sm d-flex">Remove Coupon</button>
                            </form>
                        <?php else: ?>
                            <!-- No coupon applied, show the Apply button -->
                            <form method="post" action="/customers/cart/apply-coupon"
                                  class="d-flex mb-3 justify-content-center">
                                <input type="text" class="form-control me-2" id="coupon" name="coupon_code"
                                       placeholder="Coupon Code" required style="max-width: 250px;">
                                <button type="submit" name="apply_coupon" class="btn btn-primary btn-sm">Apply</button>
                            </form>
                        <?php endif; ?>
                    </div>

                </div>

        </div> <!-- End of row -->
        <script>
function updateQuantity(productId, change) {
    const quantitySpan = document.querySelector(`.product-quantity span`);
    const currentQuantity = parseInt(quantitySpan.innerText);

    let newQuantity = currentQuantity + change;
    if (newQuantity < 1) newQuantity = 1; // Prevent negative quantity

    // Determine action based on the change
    const action = change > 0 ? 'increase' : 'decrease';

    // Update quantity in the cart
    fetch('/customers/cart/update', { // Ensure the URL matches your endpoint
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId, action: action })
    })
    .then(response => {
        if (response.ok) {
            // Update the UI
            quantitySpan.innerText = newQuantity;
            // Optionally update the total price dynamically here
            // You can also fetch updated totals from the server if needed
            location.reload(); // Refresh to update totals
        } else {
            // Handle errors here, e.g., product not found in cart
            console.error('Error updating quantity:', response.statusText);
        }
    })
    .catch(error => {
        console.error('Error updating quantity:', error);
    });
}

</script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                <?php if (isset($_SESSION['success_message'])): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?= htmlspecialchars($_SESSION['success_message']); ?>',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3B5D50'
                });
                <?php unset($_SESSION['success_message']); // Clear message after displaying ?>
                <?php endif; ?>

                    <?php if (isset($_SESSION['error_message'])): ?>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '<?= htmlspecialchars($_SESSION['error_message']); ?>',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3B5D50'
                    });
                    <?php unset($_SESSION['error_message']); // Clear message after displaying ?>
                    <?php endif; ?>
                });
            </script>
            <script>
                function removeProduct(productId) {
                    // Directly fetch without confirmation
                    fetch('/customers/cart/remove', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'product_id=' + encodeURIComponent(productId)
                    })
                        .then(response => {
                            if (response.ok) {
                                // Reload the page to reflect changes
                                window.location.reload(); // Reload the page
                            } else {
                                console.error('Failed to remove item. Please try again.'); // Log the error to the console
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }

                document.addEventListener('DOMContentLoaded', function () {
                    const increaseButtons = document.querySelectorAll('.increase-btn');
                    const decreaseButtons = document.querySelectorAll('.decrease-btn');

                    increaseButtons.forEach(button => button.addEventListener('click', updateQuantity));
                    decreaseButtons.forEach(button => button.addEventListener('click', updateQuantity));

                    function updateQuantity(event) {
                        const button = event.target;
                        const productId = button.getAttribute('data-product-id');
                        const quantityDisplay = document.getElementById('quantityDisplay_' + productId);
                        const unitPrice = parseFloat(document.querySelector(`.unit-price[data-product-id="${productId}"]`).dataset.price);

                        let quantity = parseInt(quantityDisplay.textContent);

                        if (button.classList.contains('increase-btn')) {
                            quantity++;
                        } else if (button.classList.contains('decrease-btn') && quantity > 1) {
                            quantity--;
                        }

                        quantityDisplay.textContent = quantity;

                        // Update the product total for this row
                        const productTotal = unitPrice * quantity;
                        document.getElementById('productTotal_' + productId).textContent = 'JD' + productTotal.toFixed(2);

                        console.log(`Product ID: ${productId}, Unit Price: ${unitPrice}, Quantity: ${quantity}, Product Total: ${productTotal}`);

                        // Recalculate the subtotal
                        recalculateSubtotal();
                    }

                    function recalculateSubtotal() {
                        let subtotal = 0;
                        document.querySelectorAll('.product-total').forEach(totalCell => {
                            const totalText = totalCell.textContent.replace('JD', '').trim(); // Remove 'JD' and trim whitespace
                            const totalValue = parseFloat(totalText); // Convert to float
                            if (!isNaN(totalValue)) { // Check if totalValue is a valid number
                                subtotal += totalValue; // Only add if it's a valid number
                            }
                        });

                        // Update the subtotal display
                        document.getElementById('cartSubtotal').textContent = 'JD' + subtotal.toFixed(2);

                        // If you have a discount applied, update the final total as well
                        const discount = parseFloat(document.getElementById('discountAmount')?.textContent.replace('JD', '').trim() || '0');
                        const finalTotal = subtotal - discount;

                        // Ensure finalTotal is valid
                        document.getElementById('cartFinalTotal').textContent = 'JD' + Math.max(finalTotal, 0).toFixed(2); // Ensure not negative
                    }

                });


            </script>
        </div> <!-- End of container -->
    </div> <!-- End of untree_co-section before-footer-section -->


    <!-- Start Footer Section -->
<?php require "views/partials/footer.php"; ?>
<?php if (isset($_GET['error']) && $_GET['error'] === 'not_logged_in'): ?>
    <script>
        Swal.fire({
            title: 'Error',
            text: 'Customer not logged in',
            icon: 'error',
            confirmButtonColor: '#3B5D50',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/customers/login_and_register';
            }
        });
    </script>
<?php endif; ?>