<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="/public/images/Logo (2).png">
    <!-- FontAwesome JS-->
    <script defer src="/public/plugins/fontawesome/js/all.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="/public/css/tiny-slider.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="/public/css/tiny-slider.css" rel="stylesheet">
    <link href="/public/css/admin.css" rel="stylesheet">
    <link href="/public/css/admin.css" rel="stylesheet">
    <link href="/public/css/not.css" rel="stylesheet">
</head>

<body class="app">
<header class="app-header fixed-top">
    <div class="app-header-inner">
        <div class="container-fluid py-2">
            <div class="app-header-content">
                <div class="row justify-content-between align-items-center">

                    <div class="col-auto">
                        <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                                 role="img">
                                <title>Menu</title>
                                <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                      stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                            </svg>
                        </a>
                    </div><!--//col-->
                    <div class="search-mobile-trigger d-sm-none col">
                        <i class="search-mobile-trigger-icon fa-solid fa-magnifying-glass"></i>
                    </div><!--//col-->
                    <div class="app-utilities col-auto">
                        <div class="app-utility-item app-user-dropdown dropdown">
                            <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#"
                               role="button" aria-expanded="false">
                                <img src="/public/images/user-profile.png" alt="user profile"></a>
                            <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                <li><a class="dropdown-item" href="/admin/logout">Log Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="app-sidepanel" class="app-sidepanel">
        <div id="sidepanel-drop" class="sidepanel-drop"></div>
        <div class="sidepanel-inner d-flex flex-column">
            <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>

            <a class="app-logo" href="/admin/dashboard">
                <img style="width: 45px; height: auto;" src="/public/images/Logo (2).png"
                     alt="Logo">
                <span class="ms-2" style="font-size: 20px; font-style: italic;">Admin Dashboard</span>
            </a>

            <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                    <li class="nav-item">
                        <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                        <a class="nav-link active" href="/admin/dashboard">
								<span class="nav-icon">
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door"
                                         fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd"
                                              d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z"/>
										<path fill-rule="evenodd"
                                              d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
									</svg>
								</span>
                            <span class="nav-link-text">Dashboard</span>
                        </a><!--//nav-link-->
                    </li><!--//nav-item-->
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'super admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/super_manage_admin">
								<span class="nav-icon">
								<i class="fa-solid fa-user-tie"></i>
								</span>
                                <span class="nav-link-text">Manage Admins</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                        <a class="nav-link" href="/admin/manage_customers">
							<span class="nav-icon">
							<i class="fas fa-users"></i>

									</span>
                            <span class="nav-link-text"> Manage Customers</span>
                        </a><!--//nav-link-->
                    </li><!--//nav-item-->

                    <li class="nav-item">
                        <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                        <a class="nav-link ac" href="/admin/manage_category">
								<span class="nav-icon">
								<i class="fas fa-receipt"></i>
								</span>

                            <span class="nav-link-text"> Manage Category</span>
                        </a><!--//nav-link-->
                    </li><!--//nav-item-->

                    <li class="nav-item">
                        <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                        <a class="nav-link" href="/admin/manage_products">
								<span class="nav-icon">
								<!-- <i class="fas fa-boxes"></i> -->
								<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-columns-gap"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd"
                                              d="M6 1H1v3h5V1zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12h-5v3h5v-3zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8H1v7h5V8zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6h-5v7h5V1zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z"/>
									</svg>
								</span>
                            <span class="nav-link-text"> Manage Products</span>
                        </a><!--//nav-link-->
                    </li><!--//nav-item-->


                    <li class="nav-item">
                        <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                        <a class="nav-link" href="/admin/manage_orders">
								<span class="nav-icon">
                                    <i class="bi bi-box-seam me-2"></i>
								</span>

                            <span class="nav-link-text"> Manage Orders</span>
                        </a><!--//nav-link-->
                    </li><!--//nav-item-->
                    <li class="nav-item">
                        <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                        <a class="nav-link" href="/admin/Review">
                            <span class="nav-icon">
                                <i class="fas fa-star"></i> <!-- Change this icon to an appropriate one for reviews -->
                            </span>
                            <span class="nav-link-text"> Manage Reviews</span>
                        </a><!--//nav-link-->
                    </li><!--//nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/Coupon">
                            <span class="nav-icon">
                                <i class="fas fa-tags"></i> <!-- Icon for Coupons -->
                            </span>
                            <span class="nav-link-text"> Manage Coupons</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                        <a class="nav-link" href="/admin/messages">
							<span class="nav-icon">
							<i class="fas fa-comments"></i> 

									</span>
                            <span class="nav-link-text">Messages</span>
                        </a><!--//nav-link-->
                    </li><!--//nav-item-->
                </ul>
            </nav>
            <div class="app-sidepanel-footer">
                <nav class="app-nav app-nav-footer">
                    <ul class="app-menu footer-menu list-unstyled">
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link" href="/admin/account_settings">
									<span class="nav-icon">
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear"
                                             fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd"
                                                  d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
											<path fill-rule="evenodd"
                                                  d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
										</svg>
									</span>
                                <span class="nav-link-text">Settings</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->

                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link"
                               href="/admin/logout">
									<span class="nav-icon">
                                        <i class="fa-solid fa-right-from-bracket" style="font-size: 18px;"></i>
									</span>
                                <span class="nav-link-text">Logout</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->
                    </ul><!--//footer-menu-->
                </nav>
            </div>
        </div><!--//sidepanel-inner-->
    </div>
</header>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get the current path
        const currentPath = window.location.pathname;

        // Select all nav-links
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            // Check if the href attribute matches the current path
            if (link.getAttribute('href') === currentPath) {
                // Remove 'active' from any previously active link
                document.querySelectorAll('.nav-link.active').forEach(activeLink => {
                    activeLink.classList.remove('active');
                });

                // Add 'active' class to the current link
                link.classList.add('active');
            }
        });
    });
</script>
