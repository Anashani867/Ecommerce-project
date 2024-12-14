<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/public/images/Logo (2).png">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0-alpha1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/loginstyle.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container" id="container">
    <div class="form-container sign-in-container">
        <form id="loginForm" action="/customers/login_and_register" method="POST" onsubmit="return validateLoginForm()">
            <h1>Password Reset</h1>
            <input type="hidden" name="form_type" value="signin">
            <input type="email" id="loginEmail" name="email" placeholder="Email" class="mb-5"/>
            <button type="submit" style="margin-top: 20px;">Reset Password</button>
            <a href="/customers/login_and_register">Sign In</a>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your email address below. We'll email you a link to a page where you can easily create a new password.</p>
            </div>
        </div>
    </div>
</div>

<script src="/public/js/main.js"></script>
</body>
</html>
