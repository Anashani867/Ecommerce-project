<?php require "views/partials/header.php"; ?>
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Modern Interior <span>Design Studio</span></h1>
                        <p class="mb-4">Transforming your vision into stunning, personalized spaces. Let’s create your
                            dream environment together!</p>
                        <p>
                            <a href="/customers/shop" class="btn btn-secondary me-2">Start Shopping</a>

                            <?php if (isset($_SESSION['user'])): ?>
                                <!-- Show 'Explore More' if the user is logged in -->
                                <a href="/customers/shop" class="btn btn-white-outline">Explore More</a>
                            <?php else: ?>
                                <!-- Show 'Join Now' if the user is not logged in -->
                                <a href="/customers/login_and_register" class="btn btn-white-outline">Join Now</a>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="hero-img-wrap">
                        <img src="/public/images/couch.png" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <!-- Start Category Slider Section -->
    <div class="product-section untree_co-section" id="category">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <h2 class="section-title mb-3">Crafted with Excellent Materials</h2>
                    <p class="mb-4">Discover our premium collection, where quality meets style. Each piece is crafted
                        for durability and comfort, perfect for any occasion.</p>
                </div>
            </div>

            <!-- Slider -->
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

                <!-- Carousel Controls -->
                <div id="testimonial-nav">
                    <span class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="prev" style="margin-left: -40px; margin-top: 90px;" >
                        <span class="fa fa-chevron-left" style="color: #0c4128"></span>
                    </span>
                    <span class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="next" style="margin-right: -40px; margin-top: 90px;">
                        <span class="fa fa-chevron-right" style="color: #0c4128"></span>
                    </span>
                </div>

                <div class="carousel-inner">
                    <div class="col-lg-11 mx-auto">
                        <?php
                        // Chunk products to display multiple items per slide
                        $chunkedProducts = array_chunk($products, 4); // Adjust '4' based on the number of items per slide
                        foreach ($chunkedProducts as $index => $productChunk) : ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <div class="row justify-content-center g-4">
                                    <?php foreach ($productChunk as $product) : ?>
                                        <div class="col-lg-3 col-md-4 mb-4">
                                            <div class="team-member text-center category-card">
                                                <a class="category-item"
                                                   href="/customers/category/<?php echo $product['category_id']; ?>">
                                                    <img width="261px" height="261px"
                                                         src="/public/<?php echo $product['category_image_url']; ?>"
                                                         class="img-fluid"
                                                         alt="<?php echo $product['category_name']; ?>">
                                                    <h3 class="category-title" style="color: #0c4128;">
                                                        <?php echo ucwords(str_replace(['-', '_', '&'], ' ', $product['category_name'])); ?>
                                                    </h3>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Category Slider Section -->

    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section" style="margin-top: -90px;">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">Why Choose Us</h2>
                    <p>At Nest & Buy, we are dedicated to providing premium-quality furniture with exceptional
                        service.
                        Our mission is to make your shopping experience as seamless and enjoyable as possible,
                        from
                        browsing to delivery.</p>

                    <div class="row my-5">
                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/public/images/truck.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>Fast &amp; Free Shipping</h3>
                                <p>We offer fast, reliable, and free shipping on all orders, ensuring your
                                    furniture
                                    arrives quickly and hassle-free.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/public/images/bag.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>Easy to Shop</h3>
                                <p>Our user-friendly website makes it easy to browse, select, and purchase the
                                    perfect
                                    pieces for your home.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/public/images/support.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>24/7 Support</h3>
                                <p>Our dedicated support team is available around the clock to answer any
                                    questions
                                    and
                                    provide assistance whenever you need it.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="/public/images/return.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>Hassle-Free Returns</h3>
                                <p>Not satisfied with your purchase? No problem! We offer easy returns to ensure
                                    you're
                                    completely happy with your order.</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="img-wrap" style="margin-top: -20px;">
                        <img src="/public/images/why-choose-us-img.jpg" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->

    <!-- awesome_shop start -->
    <section class="our_offer why-choose-section" style="margin-bottom: 70px;">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-4 col-md-4">
                    <div class="offer_img">
                        <img src="/public/images/offer_img.png" alt="" style="max-width:400px;">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="offer_text ">
                        <h2>Get <b style="color: black;">60% OFF</b> with <b style="color: black;">FURNI10</b> or <b style="color: black;">FREESHIP</b> — grab it before it's gone! 😱</h2>
                        <div class="date_countdown">
                            <div id="timer">
                                <div class="label">Days</div>
                                <div id="days" class="date"></div>
                                <div class="label">Hours</div>
                                <div id="hours" class="date"></div>
                                <div class="label">Minutes</div>
                                <div id="minutes" class="date"></div>
                                <div class="label">Seconds</div>
                                <div id="seconds" class="date"></div>
                            </div>
                        </div>
                        <div class="input-group">
                            <!-- <input type="text" class="form-control" placeholder="Enter email address"
                                aria-label="Recipient's username" aria-describedby="basic-addon2"> -->
                            <div class="input-group-append">
                                <a href="/customers/shop" class="btn btn-secondary me-2"
                                   id="basic-addon2">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- awesome_shop end -->


    <!-- Start We Help Section -->
    <div class="we-help-section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-7 mb-5 mb-lg-0">
                    <div class="imgs-grid">
                        <div class="grid grid-1"><img src="/public/images/img-grid-1.jpg" alt="Untree.co"></div>
                        <div class="grid grid-2"><img src="/public/images/img-grid-2.jpg" alt="Untree.co"></div>
                        <div class="grid grid-3"><img src="/public/images/img-grid-3.jpg" alt="Untree.co"></div>
                    </div>
                </div>
                <div class="col-lg-5 ps-lg-5">
                    <h2 class="section-title mb-4">We Help You Create Modern Interior Designs</h2>
                    <p>Transform your spaces with our expert design services. Our team combines creativity and
                        functionality to craft interiors that reflect your style and enhance your lifestyle.</p>

                    <ul class="list-unstyled custom-list my-4">
                        <li>Tailored design solutions for every room.</li>
                        <li style=" margin-left: 30px;">Expert guidance on material selection.</li>
                        <li>3D visualizations for your peace of mind.</li>
                        <li style=" margin-left: 30px;">Lighting design that enhances ambiance.</li>
                        <li>Seamless project management from start to finish.</li>
                        <li style=" margin-left: 30px;">Sustainable design options for eco-friendly living.</li>
                        <li>Customized furniture design to fit your space.</li>
                        <li style=" margin-left: 30px;">Space planning for maximum functionality.</li>
                        <li>Color consultation to create the perfect mood.</li>
                        <li style=" margin-left: 30px;">Renovation and remodeling services.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End We Help Section -->


    <!-- Start Popular Product -->
    <div class="popular-product product-section" id="bserseller">
        <div class="container">
            <h2 class="section-title mb-5">Best Sellers</h2>
            <div id="popularProductSlider" class="carousel slide testimonial-slider-wrap text-center"
                 data-bs-ride="carousel" data-bs-interval="3000">

                <!-- Carousel Controls -->
                <div id="testimonial-nav" style="margin-top: -80px;">
                    <span class="carousel-control-prev" type="button" data-bs-target="#popularProductSlider"
                          data-bs-slide="prev"><span class="fa fa-chevron-left"></span>
                    </span>
                    <span class="carousel-control-next" type="button" data-bs-target="#popularProductSlider"
                          data-bs-slide="next">
                        <span class="fa fa-chevron-right"></span></span>
                </div>

                <div class="carousel-inner">
                    <div class="col-lg-10 mx-auto">
                        <?php
                        $chunks = array_chunk($products, 4); // Split products array into chunks of 4
                        $isFirst = true; // Track the first item to set it as 'active'
                        foreach ($chunks as $chunk) : ?>
                            <div class="carousel-item <?php echo $isFirst ? 'active' : ''; ?>">
                                <div class="row">
                                    <?php foreach ($chunk as $product) : ?>
                                        <div class="col-12 col-md-4 col-lg-3 mb-5">
                                            <a class="product-item"
                                               href="/customers/product_details/<?php echo $product['product_id']; ?>">
                                                <img width="261px" height="261px"
                                                     src="/public/<?php echo $product['product_images']; ?>"
                                                     class="img-fluid product-thumbnail"
                                                     alt="<?php echo $product['product_name']; ?>">
                                                <h3 class="product-title">
                                                    <?php echo ucwords(str_replace(['-', '_'], ' ', $product['product_name'])); ?>
                                                </h3>
                                                <strong class="product-price"><sup>
                                                        JD </sup> <?php echo $product['price']; ?></strong>
                                                <span class="icon-cross">
                                            <img src="/public/images/cross.svg" class="img-fluid">
                                        </span>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php $isFirst = false; // Set to false after the first item ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Popular Product -->

    <!-- Start Testimonial Slider -->
    <div class="testimonial-section" id="testimonial">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                    <h2 class="section-title">Testimonials</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="testimonial-slider-wrap text-center">
                        <div class="testimonial-slider">

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Working with this team transformed my vision into
                                                    reality!
                                                    Their attention to detail and creative insights made the
                                                    entire
                                                    process enjoyable.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="/public/images/person-1.png" alt="Maria Jones"
                                                         class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Maria Jones</h3>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;The level of professionalism and commitment was
                                                    outstanding. I
                                                    highly recommend them for any interior design
                                                    project!&rdquo;
                                                </p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="/public/images/person_2.jpg" alt="John Smith"
                                                         class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">John Smith</h3>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;They took the time to understand my needs and
                                                    delivered
                                                    beyond
                                                    my expectations. Truly remarkable work!&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="/public/images/person_4.jpg" alt="Sarah Lee"
                                                         class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Sarah Lee</h3>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonial Slider -->

<?php require "views/partials/footer.php"; ?>