<!DOCTYPE html>
<html lang="en">
<head>
    <title> Admin Login </title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="/public/images/Logo (2).png">

    <!-- FontAwesome JS-->
    <script defer src="assets/plugins/fontawesome/js/all.min.js"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="/public/css/portal.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body class="app app-login p-0">
<div class="row g-0 app-auth-wrapper">
    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5 mt-4">
        <div class="d-flex flex-column align-content-end">
            <div class="app-auth-body mx-auto">
                <div class="app-auth-branding mb-4">
                    <a class="app-logo" href="#">
                        <img class="logo-icon me-2" src="/public/images/Logo (2).png"
                             alt="logo">
                    </a>
                </div>
                <h2 class="auth-heading text-center mb-5">Log in</h2>
                <div class="auth-form-container text-start form-container sign-in-container">
                    <form class="auth-form login-form" id="loginForm" action="/admin/login" method="POST" >

                        <input type="hidden" name="form_type" value="signin">
                        <div class="email mb-3">
                            <label class="sr-only" for="signin-email">Email</label>
                            <input id="loginEmail" name="email" type="email" class="form-control signin-email"
                                   placeholder="Email address" required="required">
                        </div>

                        <div class="password mb-3">
                            <label class="sr-only" for="signin-password">Password</label>
                            <input id="loginPassword" name="password" type="password"
                                   class="form-control signin-password" placeholder="Password" required="required">

                            <div class="extra mt-3 row justify-content-between">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="RememberPassword">
                                        <label class="form-check-label" for="RememberPassword">
                                            Remember me
                                        </label>
                                    </div>
                                </div><!--//col-6-->
                                <div class="col-6">
                                    <div class="forgot-password text-end">
                                        <a href="/admin/rest_password">Forgot password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
        <div class="auth-background-holder"> </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle Sign In Form Submission
        document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('/admin/login', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.loginSuccess) {
                        window.location.href = '/admin/dashboard';
                    } else {
                        showAlert('error', 'Invalid credentials. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'An error occurred. Please try again later.');
                });
        });
    });

    // Show SweetAlert function
    function showAlert(type, message) {
        if (type === 'error') {
            return Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error',
                confirmButtonColor: '#3b5d50'
            });
        } else if (type === 'success') {
            return Swal.fire({
                title: 'Success!',
                text: message,
                icon: 'success',
                confirmButtonColor: '#3b5d50'
            });
        }
    }

</script>
</body>
</html>