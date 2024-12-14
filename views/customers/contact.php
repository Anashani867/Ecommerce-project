<?php require "views/partials/header.php"; ?>

<!-- Start Hero Section -->
<div class="hero" style="padding: calc(3rem - 10px) 0 1rem 0;">
    <div class="container">
        <div class="row ">
            <div class="intro-excerptt text-center">
                <h1 class="hero-title mb-3">Contact</h1>
                <p class="hero-subtitle">We would love to hear from you.</p>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->


<!-- Start Contact Form -->
<div class="untree_co-section">
    <div class="container">
        <div class="block">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8 pb-4">

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="service no-shadow align-items-center link horizontal d-flex active"
                                 data-aos="fade-left" data-aos-delay="0">
                                <div class="service-icon color-1 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path
                                                d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    </svg>
                                </div>
                                <div class="service-contents">
                                    <p>Amman , Jordan</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="service no-shadow align-items-center link horizontal d-flex active"
                                 data-aos="fade-left" data-aos-delay="0">
                                <div class="service-icon color-1 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                        <path
                                                d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                                    </svg>
                                </div>
                                <div class="service-contents">
                                    <p>info@nestbay.com</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="service no-shadow align-items-center link horizontal d-flex active"
                                 data-aos="fade-left" data-aos-delay="0">
                                <div class="service-icon color-1 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                              d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                    </svg>
                                </div>
                                <div class="service-contents">
                                    <p>+962 772681225</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display error message if not logged in -->
                    <?php if (isset($_GET['error']) && $_GET['error'] === 'not_logged_in'): ?>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Not Logged In',
                                text: 'You need to log in to send a message.',
                                confirmButtonColor: '#3B5D50',
                                confirmButtonText: 'OK'
                            });
                        </script>
                    <?php endif; ?>

                    <!-- Form with Validation -->
                    <form action="/customers/contact" method="POST" onsubmit="return validateForm()">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="text-black" for="first_name"></label>
                                    <input type="text" class="form-control" id="fname" name="first_name"
                                           placeholder="First name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="text-black" for="last_name"></label>
                                    <input type="text" class="form-control" id="lname" name="last_name"
                                           placeholder="Last name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-black" for="email"></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address"
                            >
                        </div>

                        <div class="form-group mb-5">
                            <label class="text-black" for="message"></label>
                            <textarea class="form-control" id="message" name="message" placeholder="Message" cols="30"
                                      rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function validateForm() {
        const message = document.getElementById("message").value.trim();
        if (message === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Empty Message',
                text: 'Message field cannot be empty.',
                confirmButtonColor: '#3B5D50',
                confirmButtonText: 'OK'
            });
            return false;
        }
        return true;
    }
</script>

<?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Message Sent!',
            text: 'Your message has been successfully sent.',
            confirmButtonColor: '#3B5D50',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/customers/contact';
            }
        });
    </script>
<?php endif; ?>

<?php require "views/partials/footer.php"; ?>

<style>
    .input-group-text, .form-control, .form-select {
        height: 50px;
    }
</style>

