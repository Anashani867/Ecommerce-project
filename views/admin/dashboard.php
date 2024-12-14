<?php require "views/partials/admin_header.php"; ?>
<div class="app-sidepanel-footer">

</div><!--//app-sidepanel-footer-->

</div><!--//sidepanel-inner-->
</div><!--//app-sidepanel-->
</header><!--//app-header-->


<div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between shadow-sm p-3 bg-light rounded">

                <h1 class="app-page-title text-success"><svg width="1em" height="1em" viewBox="0 0 16 16"
                        class="bi bi-house-door me-3 mt-0 mb-2 " fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z">
                        </path>
                        <path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"></path>
                    </svg>Dashboard</h1>
            </div>


        </div><!--//app-card-->

        <div class="row g-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100 hover-animation">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Total Sales</h4>
                        <div class="stats-figure d-flex align-items-center justify-content-center">
                            <img src="https://www.svgrepo.com/show/233959/money.svg" alt="Money Icon" width="30"
                                height="40" class="me-2">
                            <span class="fw-bold fs-4 text-center"><?= htmlspecialchars($orderTotal) ?> JD </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-center stats-meta text-success">
                            <span class="fw-bold fs-4 text-center"></span>
                        </div>
                    </div>
                    <a class="app-card-link-mask" href="#"></a>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100 hover-animation">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">coupons used</h4>
                        <div class="stats-figure d-flex align-items-center justify-content-center">
                            <img src="https://www.svgrepo.com/show/99650/voucher.svg" alt="Money Icon" width="30"
                                height="40" class="me-2">
                            <span class="fw-bold fs-4 text-center"><?= htmlspecialchars($couponCount); ?> </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-center stats-meta text-success">
                            <span class="fw-bold fs-4 text-center"></span>
                        </div>
                    </div>
                    <a class="app-card-link-mask" href="#"></a>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100 hover-animation">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Total Customers</h4>
                        <div class="stats-figure d-flex align-items-center justify-content-center">
                            <img src="https://www.svgrepo.com/show/499764/user.svg" alt="Planning Managing Agenda Icon"
                                width="30" height="40" class="me-2">
                            <span class="fw-bold fs-4 text-center"><?= htmlspecialchars($userCount); ?></span>
                        </div>
                        <div class="d-flex align-items-center justify-content-center stats-meta text-success">
                            <span class="fw-bold fs-4 text-center"></span>
                        </div>
                    </div>
                    <a class="app-card-link-mask" href="#"></a>
                </div>
            </div>


            <div class="col-6 col-lg-3">
                <div class="app-card app-card-stat shadow-sm h-100 hover-animation">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Total Orders</h4>
                        <div class="stats-figure d-flex align-items-center justify-content-center">
                            <img src="https://www.svgrepo.com/show/289576/invoice-bill.svg" alt="Invoice Bill Icon"
                                width="30" height="40" class="me-2">
                            <span class="fw-bold fs-4 text-center"><?= htmlspecialchars($orderCount); ?></span>
                        </div>
                        <div class="d-flex align-items-center justify-content-center stats-meta text-success">
                            <span class="fw-bold fs-4 text-center"></span>
                        </div>
                    </div>
                    <a class="app-card-link-mask" href="#"></a>
                </div>
            </div>
        </div>


        <!-- new -->

        <div class="col-12 mt-4 mb-4">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3 border-0">
                    <h4 class="app-card-title">Sales Over Time</h4> <!-- Title for the chart -->
                </div>
                <div class="app-card-body p-3">
                    <!-- Scrollable container for the chart -->
                    <div style="overflow-x: auto;">
                        <canvas id="chart-line" width="1200" height="400"></canvas>
                        <!-- Set a fixed width for the chart -->
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            var labels = <?php echo $labels; ?>;
            var dataValues = <?php echo $values; ?>;

            var ctx = document.getElementById('chart-line').getContext('2d');


            labels = labels.slice(-5);
            dataValues = dataValues.slice(-5);

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales Amount',
                        data: dataValues,
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Sales Over Time',
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date',
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Sales Amount ($)',
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        <!-- Calendar Section -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

        <style>
            .calendar-container {
                max-width: 100%;
                height: auto;
                overflow: hidden;
                margin-bottom: 30px;
            }

            .fc-toolbar-title {
                color: #74BE8B;
                font-weight: bold;
            }

            .fc-button,
            .fc-button-primary {
                background-color: #74BE8B !important;
                border-color: #74BE8B !important;
                color: white !important;
            }

            .fc-button:hover,
            .fc-button-primary:hover {
                background-color: #74BE8B !important;
                border-color: #74BE8B !important;
            }

            .chart-container {
                overflow-x: auto;
                max-width: 100%;
                margin-bottom: 20px;
            }


            .fc-scroller.fc-scroller-liquid-absolute {
                overflow-y: auto;
            }


            .fc-scroller.fc-scroller-liquid-absolute::-webkit-scrollbar {
                width: 12px;
            }

            .fc-scroller.fc-scroller-liquid-absolute::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            .fc-scroller.fc-scroller-liquid-absolute::-webkit-scrollbar-thumb {
                background: #74BE8B;
                border-radius: 10px;
            }

            .fc-scroller.fc-scroller-liquid-absolute::-webkit-scrollbar-thumb:hover {
                background: #74BE8B;
            }


            .fc-scroller.fc-scroller-liquid-absolute {
                scrollbar-width: thin;
                scrollbar-color: #74BE8B #f1f1f1;
            }
        </style>


        <div class="row align-items-stretch">
            <!-- Calendar Section -->
            <div class="col-lg-6 mb-4 d-flex h-100">
                <div class="calendar-container flex-fill"
                    style="min-height: 400px; background-color: #ffffff; border: 1px solid #74BE8B; border-radius: 8px; padding: 10px;">
                    <div id="calendar"></div>
                </div>
            </div>
            <!-- Most Selling Products Section -->
            <div class="col-lg-6 mb-4 d-flex h-100">
                <div class="table-responsive flex-fill"
                    style="min-height: 400px; border: 1px solid #74BE8B; border-radius: 8px; background-color: #ffffff; padding: 10px;">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <i class="bi bi-bar-chart-fill" style="font-size: 1.5rem; color: #74BE8B;"></i>
                        <h5 class="ms-2 my-auto" style="color: #555;">Most Selling Products</h5>
                    </div>

                    <table class="table top-selling-table">
                        <thead>
                            <tr style="background-color: #74BE8B; color: #ffffff;">
                                <th>Product Name</th>
                                <th class="text-end">Total Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mostSellingProducts as $product): ?>
                                <tr>
                                    <td class="text-dark">
                                        <?php echo ucwords(str_replace(['-', '_'], ' ', htmlspecialchars($product['product_name']))); ?>
                                    </td>
                                    <td class="text-success text-end">
                                        <?php echo htmlspecialchars($product['total_sold']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Most Selling Products Section -->



        <style>
            .table-responsive {
                max-height: 415px;
                overflow-y: auto;
                border: 1px solid #74BE8B;
                border-radius: 8px;
                background-color: #ffffff;
                padding: 10px;
            }

            .table thead th {
                color: #ffffff;
                background-color: #74BE8B;
                font-weight: bold;
                padding: 12px;
                border: none;
            }

            .table tbody tr td {
                color: #28a745;
                padding: 10px;
                border-top: 1px solid #e9ecef;
            }

            .table-responsive::-webkit-scrollbar {
                width: 8px;
            }

            .table-responsive::-webkit-scrollbar-thumb {
                background-color: #74BE8B;
                border-radius: 4px;
            }

            .table-responsive::-webkit-scrollbar-track {
                background: #e9ecef;

            }
        </style>


        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth'
                });
                calendar.render();
            });
        </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales Amount',
                        data: dataValues,
                        backgroundColor: 'rgba(40, 167, 69, 0.2)', // Light green background
                        borderColor: 'rgba(40, 167, 69, 1)', // Dark green border
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false, // Remove the legend
                        },
                        title: {
                            display: true,
                            text: 'Sales Over Time', // You can keep this if you want to retain the title
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date',
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Sales Amount ($)',
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <style>
            .chart-container {
                position: relative;
                height: 400px;
                width: 100%;
            }

            .app-card-chart {
                border-radius: 10px;
                overflow: hidden;
                background-color: #fff;
            }

            .app-card-header {
                background-color: #f8f9fa;
                border-bottom: 1px solid #dee2e6;
            }

            .app-card-title {
                font-size: 1.25rem;
                font-weight: bold;
                color: #495057;
            }
        </style>