<?php require "views/partials/header.php"; ?>

<!-- Start Hero Section -->
<div class="hero" style="padding: calc(3rem - 30px) 0 1rem 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-excerptt text-center">
                    <h1 class="hero-title mb-3">
                        Category:<span style="color: #F9BF29;"> <?php echo htmlspecialchars($products[0]['category_name']); ?> </span>
                    </h1>
                    <p class="hero-subtitle" style="max-width: 75%;">
                        <?php echo htmlspecialchars($products[0]['description']); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            <?php foreach ($products as $product) : ?>
                <div class="col-12 col-md-4 col-lg-3 mb-5">
                    <a class="product-item" href="/customers/product_details/<?php echo htmlspecialchars($product['id']); ?>">
                        <img width="261px" height="261px" src="/public/<?php echo htmlspecialchars($product['image_url']); ?>"
                             class="img-fluid product-thumbnail" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                        <h3 class="product-title">
                            <b> <?php echo ucwords(str_replace(['-', '_'], ' ', htmlspecialchars($product['product_name']))); ?> </b>
                        </h3>
                        <strong class="product-price">
                            <sup> JD </sup><?php echo htmlspecialchars($product['price']); ?>
                        </strong>
                        <span class="icon-cross">
                            <img src="/public/images/cross.svg" class="img-fluid">
                        </span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require "views/partials/footer.php"; ?>
