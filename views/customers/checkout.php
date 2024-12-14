<?php require "views/partials/header.php"; ?>

<!-- Include SweetAlert CSS and JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<div class="untree_co-section" style="margin-top: -50px;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-5 mb-md-0">
                <h2 class="h3 mb-3 text-black">Billing Details</h2>
                <div class="p-3 p-lg-5 border bg-white">
             <!-- Displaying customer info as basic information without a form -->
<!-- Displaying customer info as basic information without a form -->
<div class="container mt-4">
<form id="checkoutForm" action="/customers/cart/checkout" method="POST" onsubmit="return validateForm()">
    <h2 class="mb-4">Checkout</h2>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="text-black font-weight-bold">First Name:</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($customers->first_name); ?>" readonly>
        </div>

        <div class="col-md-6">
            <label class="text-black font-weight-bold">Last Name:</label>
            <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($customers->last_name); ?>" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="text-black font-weight-bold">Email Address:</label>
            <p class="form-control-plaintext"><?php echo htmlspecialchars($customers->email); ?></p>
        </div>

        <div class="col-md-6">
            <label class="text-black font-weight-bold">Current Address:</label>
            <p class="form-control-plaintext"><?php echo htmlspecialchars($customers->address); ?></p>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="text-black font-weight-bold">Enter New Address:</label>
            <input type="text" name="address" class="form-control" placeholder="123 Main St" required>
        </div>

        <div class="col-md-6">
            <label class="text-black font-weight-bold">Enter Phone Number:</label>
            <input type="text" name="phone_number" class="form-control" placeholder="(962)" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary m-auto d-flex p-3" id="proceedBtn">Proceed to Payment</button>
</form>
</div>
<?php if (isset($_SESSION['error_message']) && isset($_SESSION['show_sweet_alert'])): ?>
    <script>
        swal({
            title: "Error!",
            text: "<?php echo htmlspecialchars($_SESSION['error_message']); ?>",
            icon: "error", // Change `type` to `icon`
            button: "OK", // Change `confirmButtonText` to `button`
            confirmButtonColor: '#3B5D50',
        }).then(() => {
            // Optional: Redirect after closing
            window.location = '/customers/checkout'; // Redirect to checkout page if needed
        });
        <?php unset($_SESSION['error_message'], $_SESSION['show_sweet_alert']); // Clear the message after displaying it ?>
    </script>
<?php endif; ?>
     <script>
                        document.getElementById('proceedBtn').addEventListener('click', function (event) {
                            event.preventDefault(); // Prevent the form from submitting immediately

                            // Show SweetAlert confirmation dialog
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You are about to proceed to payment.",
                                icon: 'warning',
                                showCancelButton: true,
                                cancelButtonText: 'Cancel',
                                confirmButtonText: 'Yes, proceed!',
                                confirmButtonColor: '#3b5d50',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // If confirmed, submit the form
                                    document.getElementById('checkoutForm').submit();
                                }
                            });
                        });
                    </script>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">Your Order</h2>
                        <div class="p-3 p-lg-5 border bg-white">
                            <table class="table site-block-order-table mb-5">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
    <?php
    $subtotal = 0;

    // Calculate subtotal
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId => $product) {
            $totalPrice = $product['price'] * $product['quantity'];
            $subtotal += $totalPrice;
            ?>
            <tr>
                <td><?= htmlspecialchars(ucwords(str_replace(['-', '_'], ' ', $product['name']))); ?>
                    <strong class="mx-2">x</strong> <?php echo htmlspecialchars($product['quantity']); ?>
                </td>
                <td>JD<?php echo number_format($totalPrice, 2); ?></td>
            </tr>
            <?php
        }
    }
    ?>

    <tr>
        <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
        <td class="text-black">JD<?php echo number_format($subtotal, 2); ?></td>
    </tr>

    <?php
    // Calculate discount if applicable
    $discountPercentage = $_SESSION['discount'] ?? 0;
    if ($discountPercentage > 0) {
        // Calculate the actual discount amount based on the percentage
        $discountAmount = ($subtotal * $discountPercentage) / 100;
        echo "<tr>
            <td class='text-black font-weight-bold'><strong>Discount ({$discountPercentage}%)</strong></td>
            <td class='text-black'>- JD" . number_format($discountAmount, 2) . "</td>
          </tr>";
    } else {
        $discountAmount = 0; // No discount
    }

    // Calculate total amount
    $totalAmount = $subtotal - $discountAmount;
    ?>

    <tr>
        <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
        <td class="text-black font-weight-bold">
            <strong>JD<?php echo number_format($totalAmount, 2); ?></strong>
        </td>
    </tr>
</tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require "views/partials/footer.php"; ?>
