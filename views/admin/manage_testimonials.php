<?php require "views/partials/admin_header.php"; ?>
<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between shadow-sm p-3 bg-light rounded">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0 text-success fw-bold" style="font-size: 2rem;">
                        <i class="fas fa-comments me-3"></i>Testimonials
                    </h1>
                </div>
            </div>

            <div class="row">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card border-0 shadow-lg" style="background: #f8f9fa; border-radius: 15px;">
                            <div class="card-body text-center">
                                <?php
                                $imageSrc = !empty($testimonial['image_url']) ? htmlspecialchars($testimonial['image_url']) : '/public/images/mousa.PNG';
                                ?>
                                <img src="<?= $imageSrc; ?>" class="img-fluid rounded-circle" style="width: 70px; height: 70px; border: 2px solid #28a745;">
                                <h5 class="card-title text-success fw-bold"><?= htmlspecialchars($testimonial['user_name']); ?></h5>
                                <p class="card-text text-muted" style="font-style: italic;"><?= htmlspecialchars($testimonial['testimonial_text']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
