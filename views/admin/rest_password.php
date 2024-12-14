<!DOCTYPE html>
<html lang="en">
<head>
    <title> Admin Login </title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="/public/images/Logo (2).png">

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="/public/css/portal.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="app app-reset-password p-0">
<div class="row g-0 app-auth-wrapper">
    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5 mt-5">
        <div class="d-flex flex-column align-content-end">
            <div class="app-auth-body mx-auto">
                <div class="app-auth-branding mb-4">
                    <a class="app-logo" href="#">
                        <img class="logo-icon me-2" src="/public/images/Logo (2).png"
                             alt="logo">
                    </a>
                </div>
                <h2 class="auth-heading text-center mb-4">Password Reset</h2>

                <div class="auth-intro mb-4 text-center">Enter your email address below. We'll email you a link to a page where you can easily create a new password.</div>

                <div class="auth-form-container text-left">

                    <form class="auth-form resetpass-form">
                        <div class="email mb-3">
                            <input id="reg-email" name="reg-email" type="email" class="form-control login-email" placeholder="Your Email" required="required">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn app-btn-primary btn-block theme-btn mx-auto">Reset Password</button>
                        </div>
                    </form>
                    <div class="auth-option text-center pt-5"><a class="app-link" href="/admin/login" >Log in</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
        <div class="auth-background-holder"></div>
    </div>
</div>
</body>
</html>

