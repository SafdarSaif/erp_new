@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">
        <!-- start page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">E-Commerce</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item">
                            <a href="index.html">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">E-Commerce</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto align-items-center flex-wrap flex-shrink-0">
                <a href="apps-product-create.html" class="btn btn-sm btn-light-primary">
                    Add Product
                </a>
            </div>
        </div>
        <!-- end page title -->
        <div class="e-commerce-dashboard">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card card-h-100 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                                <div class="flex-grow-1">
                                    <div class="hstack gap-3 mb-3">
                                        <div class="bg-warning-subtle text-warning avatar avatar-item rounded-2">
                                            <!-- <i class="ri-money-dollar-circle-line fs-16 fw-medium"></i> -->
                                            <i class="bi bi-house-heart-fill fs-16 fw-medium"></i>
                                        </div>
                                        <h6 class="mb-0 fs-13">Total Sales</h6>
                                    </div>
                                    <h4 class="fw-semibold fs-5 mb-0">
                                        <span data-target="84573" data-duration="5" data-prefix="$">$84573</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <div class="d-flex align-items-end justify-content-end gap-3">
                                        <span class="text-success"><i class="ri-arrow-right-up-line fs-12"></i>10.18%</span>
                                    </div>
                                    <div class="text-muted fs-12">+1.01% this week</div>
                                </div>
                            </div>
                        </div>
                        <div id="totalSalesDashborad"></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-h-100 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                                <div class="flex-grow-1">
                                    <div class="hstack gap-3 mb-3">
                                        <div class="bg-danger-subtle text-danger avatar avatar-item rounded-2">
                                            <i class="ri-money-dollar-circle-line fs-16 fw-medium"></i>
                                        </div>
                                        <h6 class="mb-0 fs-13">Total Orders</h6>
                                    </div>
                                    <h4 class="fw-semibold fs-5 mb-0">
                                        <span data-target="202557" data-duration="5" data-prefix="$">$202557</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <div class="d-flex align-items-end justify-content-end gap-3">
                                        <span class="text-danger"><i class="ri-arrow-right-down-line fs-12"></i>1.01%</span>
                                    </div>
                                    <div class="text-muted fs-12">-0.31% this week</div>
                                </div>
                            </div>
                        </div>
                        <div id="totalOrdersDashborad"></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-h-100 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                                <div class="flex-grow-1">
                                    <div class="hstack gap-3 mb-3">
                                        <div class="bg-success-subtle text-success avatar avatar-item rounded-2">
                                            <i class="ri-money-dollar-circle-line fs-16 fw-medium"></i>
                                        </div>
                                        <h6 class="mb-0 fs-13">Total Earnings</h6>
                                    </div>
                                    <h4 class="fw-semibold fs-5 mb-0">
                                        <span data-target="202557" data-duration="5" data-prefix="$">$202557</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <div class="d-flex align-items-end justify-content-end gap-3">
                                        <span class="text-success"><i class="ri-arrow-right-up-line fs-12"></i>10.10</span>
                                    </div>
                                    <div class="text-muted fs-12">+1.99% this week</div>
                                </div>
                            </div>
                        </div>
                        <div id="totalEarningsDashborad"></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card card-h-100 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                                <div class="flex-grow-1">
                                    <div class="hstack gap-3 mb-3">
                                        <div class="bg-info-subtle text-info avatar avatar-item rounded-2">
                                            <i class="ri-truck-line fs-16 fw-medium"></i>
                                        </div>
                                        <h6 class="mb-0 fs-13">Total Shipments</h6>
                                    </div>
                                    <h4 class="fw-semibold fs-5 mb-0">
                                        <span data-target="17892" data-duration="5" data-prefix="$">$17,892</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <div class="d-flex align-items-end justify-content-end gap-3">
                                        <span class="text-success"><i class="ri-arrow-right-up-line fs-12"></i>5.50%</span>
                                    </div>
                                    <div class="text-muted fs-12">+2.15% this week</div>
                                </div>
                            </div>
                        </div>
                        <div id="totalShipmentsDashboard"></div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-6 h-100">
                    <div class="card mb-0">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">Order Analytics</h5>
                                <p class="mb-0 card-subtitle">Total 248.5k Visits</p>
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-outline-primary btn-sm active">1W</button>
                                <button type="button" class="btn btn-outline-primary btn-sm">1M</button>
                                <button type="button" class="btn btn-outline-primary btn-sm">6M</button>
                                <button type="button" class="btn btn-outline-primary btn-sm">1Y</button>
                            </div>
                        </div>
                        <div class="card-body p-2 pb-0">
                            <div id="orderAnalyticsDashboard" class="apexcharts-container apexcharts-white"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 h-100">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Customer Review Insights</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center justify-content-center p-4 rounded bg-light bg-opacity-30 mb-4">
                                <div class="d-inline-flex position-relative cursor-pointer text-warning fs-3">
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-half-line"></i>
                                </div>
                                <h6 class="py-2 fs-6 fw-semibold text-primary">4.5/5</h6>
                                <p class="text-muted mb-0">Based on 650 customer reviews</p>
                            </div>
                            <div class="text-nowrap d-flex flex-column justify-content-between gap-1">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-flex gap-1 align-items-center text-muted fs-13 flex-shrink-0">5 Star</span>
                                    <div class="progress progress-xs flex-grow-1" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-success w-100"></div>
                                    </div>
                                    <span class="w-30px text-end fw-semibold flex-shrink-0 ms-4">100%</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-flex gap-1 align-items-center text-muted fs-13 flex-shrink-0">4 Star</span>
                                    <div class="progress progress-xs flex-grow-1" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-info" style="width: 80%;"></div>
                                    </div>
                                    <span class="w-30px text-end fw-semibold flex-shrink-0 ms-4">80%</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-flex gap-1 align-items-center text-muted fs-13 flex-shrink-0">3 Star</span>
                                    <div class="progress progress-xs flex-grow-1" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-warning w-75"></div>
                                    </div>
                                    <span class="w-30px text-end fw-semibold flex-shrink-0 ms-4">75%</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-flex gap-1 align-items-center text-muted fs-13 flex-shrink-0">2 Star</span>
                                    <div class="progress progress-xs flex-grow-1" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-danger w-50"></div>
                                    </div>
                                    <span class="w-30px text-end fw-semibold flex-shrink-0 ms-4">50%</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-flex gap-1 align-items-center text-muted fs-13 flex-shrink-0">1 Star</span>
                                    <div class="progress progress-xs flex-grow-1" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-secondary w-25"></div>
                                    </div>
                                    <span class="w-30px text-end fw-semibold flex-shrink-0 ms-4">25%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 h-100">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <h5 class="card-title mb-0">Revenue</h5>
                            <div class="dropdown flex-shrink-0">
                                <a class="text-reset dropdown-toggle" href="#!" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fw-semibold text-uppercase fs-12">Sort by: </span><span class="text-muted">Last Month</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#!">Today</a>
                                    <a class="dropdown-item" href="#!">Last Week</a>
                                    <a class="dropdown-item" href="#!">Last Month</a>
                                    <a class="dropdown-item" href="#!">Current Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="fw-semibold d-flex align-items-center gap-3 mb-4">
                                <span>$16520</span>
                                <span class="badge text-danger bg-danger-subtle p-1"><i class="ri-arrow-right-down-line fs-12"></i>1.5%</span>
                            </h4>
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
                                <span class="fs-12 fw-normal text-muted"><strong class="me-1 text-body">$6,500</strong>More to reach Goal</span>
                                <span class="fw-semibold">75%</span>
                            </div>
                            <div class="progress progress-xs w-100" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-primary w-75"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-0">
                        <div class="card-header">
                            <h5 class="mb-0">New Customer Joined</h5>
                        </div>
                        <div class="card-body">
                            <h4 class="fw-semibold d-flex align-items-center gap-3 mb-4">
                                <span class="text-warning">4.5K</span>
                                <span class="badge text-success bg-success-subtle p-1"><i class="ri-arrow-right-up-line fs-12"></i>4.3%</span>
                            </h4>
                            <div>
                                <div class="avatar-group">
                                    <div class="position-relative" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-white" data-bs-placement="top" data-bs-title="Tooltip on top">
                                        <img class="img-fluid avatar avatar-item" src="assets/images/avatar/avatar-2.jpg" alt="avatar image">
                                    </div>
                                    <img class="img-fluid avatar avatar-item" src="assets/images/avatar/avatar-4.jpg" alt="avatar image">
                                    <img class="img-fluid avatar avatar-item" src="assets/images/avatar/avatar-5.jpg" alt="avatar image">
                                    <img class="img-fluid avatar avatar-item" src="assets/images/avatar/avatar-6.jpg" alt="avatar image">
                                    <img class="img-fluid avatar avatar-item" src="assets/images/avatar/avatar-8.jpg" alt="avatar image">
                                    <div class="avatar-item avatar fw-semibold avatar-title bg-text-primary">5+</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-8 col-xl-9">
                    <div class="card mb-0">
                        <table id="recent-order-table" class="table align-middle w-100 table-nowrap">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th class="px-5"></th>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Order Date</th>
                                    <th>Order Status</th>
                                    <th>Total Amount</th>
                                    <th>Payment Method</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="card mb-0">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <h5 class="card-title mb-0 flex-grow-1">Top Products</h5>
                            <select id="top-product-select" class="form-select flex-shrink-0">
                                <option value="Monthly">Monthly</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Annualy">Annualy</option>
                            </select>
                        </div>
                        <div class="card-body top-product-scroll" data-simplebar="">
                            <ul class="list-group fs-13 fw-medium list-group-flush">
                                <li class="list-group-item hstack gap-2 px-0 pt-0">
                                    <img class="avatar avatar-item overflow-hidden border-0 rounded flex-shrink-0" src="assets/images/product/product-1.jpg" alt="Nike Shoes">
                                    <div class="hstack gap-2 flex-grow-1 overflow-hidden">
                                        <div class="d-flex flex-column flex-grow-1 overflow-hidden">
                                            <a href="#!" class="fs-6 fw-bold text-truncate text-body">Nike Shoes</a>
                                            <span class="text-muted fw-normal text-truncate fs-12">Sold: 1947</span>
                                        </div>
                                        <div class="badge text-success bg-success-subtle p-1">+18.4%</div>
                                    </div>
                                </li>
                                <li class="list-group-item hstack gap-2 px-0">
                                    <img class="avatar avatar-item overflow-hidden border-0 rounded flex-shrink-0" src="assets/images/product/product-2.jpg" alt="Gabrielloe Perfume">
                                    <div class="hstack gap-2 flex-grow-1 overflow-hidden">
                                        <div class="d-flex flex-column flex-grow-1 overflow-hidden">
                                            <a href="#!" class="fs-6 fw-bold text-truncate text-body">Gabrielloe Perfume</a>
                                            <span class="text-muted fw-normal text-truncate fs-12">Sold: 1498</span>
                                        </div>
                                        <span class="badge text-danger bg-danger-subtle p-1">-5.2%</span>
                                    </div>
                                </li>
                                <li class="list-group-item hstack gap-2 px-0">
                                    <img class="avatar avatar-item overflow-hidden border-0 rounded flex-shrink-0" src="assets/images/product/product-3.jpg" alt="Headphone">
                                    <div class="hstack gap-2 flex-grow-1 overflow-hidden">
                                        <div class="d-flex flex-column flex-grow-1 overflow-hidden">
                                            <a href="#!" class="fs-6 fw-bold text-truncate text-body">Headphone</a>
                                            <span class="text-muted fw-normal text-truncate fs-12">Sold: 1176</span>
                                        </div>
                                        <div class="badge text-success bg-success-subtle p-1">+9.7%</div>
                                    </div>
                                </li>
                                <li class="list-group-item hstack gap-2 px-0">
                                    <img class="avatar avatar-item overflow-hidden border-0 rounded flex-shrink-0" src="assets/images/product/product-4.jpg" alt="Cocooil Body Oil">
                                    <div class="hstack gap-2 flex-grow-1 overflow-hidden">
                                        <div class="d-flex flex-column flex-grow-1 overflow-hidden">
                                            <a href="#!" class="fs-6 fw-bold text-truncate text-body">Cocooil Body Oil</a>
                                            <span class="text-muted fw-normal text-truncate fs-12">Sold: 723</span>
                                        </div>
                                        <span class="badge text-danger bg-danger-subtle p-1">-3.4%</span>
                                    </div>
                                </li>
                                <li class="list-group-item hstack gap-2 px-0">
                                    <img class="avatar avatar-item overflow-hidden border-0 rounded flex-shrink-0" src="assets/images/product/product-5.jpg" alt="Earbuds">
                                    <div class="hstack gap-2 flex-grow-1 overflow-hidden">
                                        <div class="d-flex flex-column flex-grow-1 overflow-hidden">
                                            <a href="#!" class="fs-6 fw-bold text-truncate text-body">Earbuds</a>
                                            <span class="text-muted fw-normal text-truncate fs-12">Sold: 554</span>
                                        </div>
                                        <div class="badge text-success bg-success-subtle p-1">+12.6%</div>
                                    </div>
                                </li>
                                <li class="list-group-item hstack gap-2 px-0">
                                    <img class="avatar avatar-item overflow-hidden border-0 rounded flex-shrink-0" src="assets/images/product/product-7.jpg" alt="T-shirt">
                                    <div class="hstack gap-2 flex-grow-1 overflow-hidden">
                                        <div class="d-flex flex-column flex-grow-1 overflow-hidden">
                                            <a href="#!" class="fs-6 fw-bold text-truncate text-body">T-shirt</a>
                                            <span class="text-muted fw-normal text-truncate fs-12">Sold: 347</span>
                                        </div>
                                        <div class="badge text-success bg-success-subtle p-1">+7.8%</div>
                                    </div>
                                </li>
                                <li class="list-group-item hstack gap-2 px-0">
                                    <img class="avatar avatar-item overflow-hidden border-0 rounded flex-shrink-0" src="assets/images/product/product-8.jpg" alt="T-shirt">
                                    <div class="hstack gap-2 flex-grow-1 overflow-hidden">
                                        <div class="d-flex flex-column flex-grow-1 overflow-hidden">
                                            <a href="#!" class="fs-6 fw-bold text-truncate text-body">Specker</a>
                                            <span class="text-muted fw-normal text-truncate fs-12">Sold: 300</span>
                                        </div>
                                        <div class="badge text-success bg-success-subtle p-1">+7.8%</div>
                                    </div>
                                </li>
                                <li class="list-group-item hstack gap-2 px-0">
                                    <img class="avatar avatar-item overflow-hidden border-0 rounded flex-shrink-0" src="assets/images/product/product-1.jpg" alt="Nike Shoes">
                                    <div class="hstack gap-2 flex-grow-1 overflow-hidden">
                                        <div class="d-flex flex-column flex-grow-1 overflow-hidden">
                                            <a href="#!" class="fs-6 fw-bold text-truncate text-body">Nike Shoes</a>
                                            <span class="text-muted fw-normal text-truncate fs-12">Sold: 1947</span>
                                        </div>
                                        <div class="badge text-success bg-success-subtle p-1">+18.4%</div>
                                    </div>
                                </li>
                                <li class="list-group-item hstack gap-2 px-0 pb-0">
                                    <img class="avatar avatar-item overflow-hidden border-0 rounded flex-shrink-0" src="assets/images/product/product-2.jpg" alt="Gabrielloe Perfume">
                                    <div class="hstack gap-2 flex-grow-1 overflow-hidden">
                                        <div class="d-flex flex-column flex-grow-1 overflow-hidden">
                                            <a href="#!" class="fs-6 fw-bold text-truncate text-body">Gabrielloe Perfume</a>
                                            <span class="text-muted fw-normal text-truncate fs-12">Sold: 1498</span>
                                        </div>
                                        <span class="badge text-danger bg-danger-subtle p-1">-5.2%</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- START SWITCHER -->
<div class="switcher">
    <button type="button" class="switcher-icon btn btn-dark" data-bs-toggle="offcanvas" data-bs-target="#switcher">
        <i class="bi-sliders fs-6 me-2"></i> Customize
    </button>

    <!-- OFFCANVAS -->
    <div class="offcanvas offcanvas-end" id="switcher" tabindex="-1" aria-labelledby="switcherLabel">
        <div class="offcanvas-header border-bottom hstack">
            <h1 class="offcanvas-title fs-5 flex-grow-1" id="switcherLabel">Preview Settings</h1>
            <button type="button" class="close btn btn-text-primary icon-btn-sm flex-shrink-0" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ri-close-large-line fw-semibold"></i>
            </button>
        </div>
        <div class="offcanvas-body">

            <!-- MAIN_LAYOUT -->
            <div class="d-none d-lg-block">
                <h6 class="mb-2 fs-5">Theme Layouts</h6>
                <p class="text-muted">Defines the admin panel's layout style, allowing you to choose from different design options.</p>
                <div class="row g-4 mb-5">
                    <div class="col-12 col-sm-4">
                        <!-- VERTICAL -->
                        <input class="form-check-input d-none" data-attribute="data-main-layout" name="layoutsModes" value="vertical" type="radio" id="verticalLayouts">
                        <label for="verticalLayouts" class="switcher-card w-100">
                            <span class="border d-block rounded h-100px overflow-hidden">
                                <span class="d-flex h-100">
                                    <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                        <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                        <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                            <span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            </span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                    </span>
                                    <span class="d-flex flex-column flex-grow-1">
                                        <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                            <span class="d-flex align-items-center gap-1">
                                                <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                                <span class="w-8px h-8px bg-success rounded-pill"></span>
                                                <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                            </span>
                                            <span class="w-8px h-8px bg-light rounded-pill"></span>
                                        </span>
                                        <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                            <span class="p-2">
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            </span>
                                            <span class="w-100 bg-light h-6px ms-1"></span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Vertical</span>
                        </label>
                    </div>
                    <div class="col-12 col-sm-4">
                        <!-- HORIZONTAL -->
                        <input class="form-check-input d-none" data-attribute="data-main-layout" name="layoutsModes" value="horizontal" type="radio" id="horizontalLayouts">
                        <label for="horizontalLayouts" class="switcher-card w-100">
                            <span class="border d-block rounded h-100px overflow-hidden">
                                <span class="d-flex h-100">
                                    <span class="d-flex flex-column flex-grow-1">
                                        <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                            <span class="d-flex align-items-center gap-1">
                                                <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                                <span class="w-8px h-8px bg-success rounded-pill"></span>
                                                <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                            </span>
                                            <span class="w-8px h-8px bg-light rounded-pill"></span>
                                        </span>
                                        <span class="d-flex h-16px flex-shrink-0 border-end">
                                            <span class="w-20px h-16px bg-light d-block"></span>
                                            <span class="w-100 bg-primary-subtle d-flex justify-content-between p-1">
                                                <span class="d-flex gap-2">
                                                    <span class="w-20px h-6px bg-light rounded d-block mb-1"></span>
                                                    <span class="w-20px h-6px bg-light rounded d-block mb-1"></span>
                                                </span>
                                                <span class="w-20px h-6px bg-light rounded d-block mb-1"></span>
                                            </span>
                                        </span>
                                        <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                            <span class="p-2">
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            </span>
                                            <span class="w-100 bg-light h-6px"></span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Horizontal</span>
                        </label>
                    </div>
                    <div class="col-12 col-sm-4">
                        <!-- 2 COLUMN -->
                        <input class="form-check-input d-none" data-attribute="data-main-layout" name="layoutsModes" value="two-column" type="radio" id="2ColumnLayouts">
                        <label for="2ColumnLayouts" class="switcher-card w-100">
                            <span class="border d-block rounded h-100px overflow-hidden">
                                <span class="d-flex h-100">
                                    <span class="w-16px d-flex flex-column h-100 flex-shrink-0 border-end">
                                        <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                        <span class="h-100 bg-light d-flex flex-column justify-content-between p-1">
                                            <span>
                                                <span class="h-6px bg-primary-subtle rounded d-block mb-1"></span>
                                                <span class="h-6px bg-primary-subtle rounded d-block mb-1"></span>
                                            </span>
                                            <span class="h-6px bg-primary-subtle rounded d-block mb-1"></span>
                                        </span>
                                    </span>
                                    <span class="w-30px ms-1 d-flex flex-column h-100 flex-shrink-0 border-end">
                                        <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                        <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                            <span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            </span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                    </span>
                                    <span class="d-flex flex-column flex-grow-1">
                                        <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                            <span class="d-flex align-items-center gap-1">
                                                <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                                <span class="w-8px h-8px bg-success rounded-pill"></span>
                                                <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                            </span>
                                            <span class="w-8px h-8px bg-light rounded-pill"></span>
                                        </span>
                                        <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                            <span class="p-2">
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            </span>
                                            <span class="w-100 bg-light h-6px ms-1"></span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Two Column</span>
                        </label>
                    </div>
                    <div class="col-12 col-sm-4">
                        <!-- SEMI BOXED -->
                        <input class="form-check-input d-none" data-attribute="data-main-layout" name="layoutsModes" value="semi-boxed" type="radio" id="semiBoxLayouts">
                        <label for="semiBoxLayouts" class="switcher-card w-100">
                            <span class="border d-block rounded h-100px overflow-hidden p-2">
                                <span class="d-flex h-100 rounded">
                                    <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                        <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                        <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                            <span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            </span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                    </span>
                                    <span class="d-flex flex-column flex-grow-1">
                                        <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                            <span class="d-flex align-items-center gap-1">
                                                <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                                <span class="w-8px h-8px bg-success rounded-pill"></span>
                                                <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                            </span>
                                            <span class="w-8px h-8px bg-light rounded-pill"></span>
                                        </span>
                                        <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                            <span class="p-2">
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            </span>
                                            <span class="w-100 bg-light h-6px ms-1"></span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Semi Box</span>
                        </label>
                    </div>
                    <div class="col-12 col-sm-4">
                        <!-- COMPACT -->
                        <input class="form-check-input d-none" data-attribute="data-main-layout" name="layoutsModes" value="compact" type="radio" id="compactSidebar">
                        <label for="compactSidebar" class="switcher-card w-100">
                            <span class="border d-block rounded h-100px overflow-hidden">
                                <span class="d-flex h-100">
                                    <span class="w-20px d-flex flex-column h-100 flex-shrink-0 border-end">
                                        <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                        <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                            <span>
                                                <span class="h-8px bg-light rounded d-block mb-1"></span>
                                                <span class="h-8px bg-light rounded d-block mb-1"></span>
                                            </span>
                                            <span class="h-8px bg-light rounded d-block mb-1"></span>
                                        </span>
                                    </span>
                                    <span class="d-flex flex-column flex-grow-1">
                                        <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                            <span class="d-flex align-items-center gap-1">
                                                <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                                <span class="w-8px h-8px bg-success rounded-pill"></span>
                                                <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                            </span>
                                            <span class="w-8px h-8px bg-light rounded-pill"></span>
                                        </span>
                                        <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                            <span class="p-2">
                                                <span class="w-25 bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-50 bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-100 bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-75 bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-25 bg-light rounded-1 h-6px mb-1"></span>
                                            </span>
                                            <span class="w-100 bg-light h-6px ms-1"></span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Compact</span>
                        </label>
                    </div>
                    <div class="col-12 col-sm-4">
                        <!-- SMALL ICON -->
                        <input class="form-check-input d-none" data-attribute="data-main-layout" name="layoutsModes" value="small-icon" type="radio" id="smallIconSidebar">
                        <label for="smallIconSidebar" class="switcher-card w-100">
                            <span class="border d-block rounded h-100px overflow-hidden">
                                <span class="d-flex h-100">
                                    <span class="w-14px d-flex flex-column h-100 flex-shrink-0 border-end">
                                        <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                        <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                            <span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            </span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                    </span>
                                    <span class="d-flex flex-column flex-grow-1">
                                        <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                            <span class="d-flex align-items-center gap-1">
                                                <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                                <span class="w-8px h-8px bg-success rounded-pill"></span>
                                                <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                            </span>
                                            <span class="w-8px h-8px bg-light rounded-pill"></span>
                                        </span>
                                        <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                            <span class="p-2">
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            </span>
                                            <span class="w-100 bg-light h-6px ms-1"></span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Small Icon View</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- THEME -->
            <h6 class="mb-2 fs-5">Color Mode</h6>
            <p class="text-muted">Choose if app's appearance should be light or dark, or follow your computer's settings.</p>
            <div class="list-group flex-row gap-3 mb-3 template-customizer mb-5">
                <!-- LIGHT -->
                <label for="lightTheme" class="list-group-item p-2 form-check rounded m-0 hstack gap-3 w-max">
                    <span class="form-check-label hstack gap-2">
                        <i class="ri-sun-line"></i>
                        <span class="fw-semibold fs-12">Light Theme</span>
                    </span>
                    <input id="lightTheme" type="radio" data-attribute="data-bs-theme" class="form-check-input" name="layoutsModes" value="light">
                </label>
                <!-- DARK -->
                <label for="darkTheme" class="list-group-item p-2 form-check rounded m-0 hstack gap-3 w-max">
                    <span class="form-check-label hstack gap-2">
                        <i class="ri-moon-clear-line"></i>
                        <span class="fw-semibold fs-12">Dark Theme</span>
                    </span>
                    <input id="darkTheme" type="radio" data-attribute="data-bs-theme" class="form-check-input" name="layoutsModes" value="dark">
                </label>
                <!-- AUTO -->
                <label for="autoTheme" class="list-group-item p-2 form-check rounded m-0 hstack gap-3 w-max">
                    <span class="form-check-label hstack gap-2">
                        <i class="ri-computer-line"></i>
                        <span class="fw-semibold fs-12">Auto Theme</span>
                    </span>
                    <input id="autoTheme" type="radio" data-attribute="data-bs-theme" class="form-check-input cursor-pointer ms-auto" name="layoutsModes" value="auto">
                </label>
            </div>

            <!-- RTL MODE -->
            <h6 class="mb-2 fs-5">RTL Mode</h6>
            <p class="text-muted">Toggle between LTR and RTL layouts to support different language directions.</p>

            <div class="row g-4 mb-5">
                <div class="col-4">
                    <!-- LTR MODE -->
                    <input class="form-check-input d-none" data-attribute="dir" name="directionModes" value="ltr" type="radio" id="ltrLayouts">
                    <label for="ltrLayouts" class="switcher-card w-100">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                    <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                        <span class="w-8px h-8px bg-light rounded-pill"></span>
                                    </span>
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2">
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px ms-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">LTR Direction</span>
                    </label>
                </div>
                <div class="col-4">
                    <!-- RTL MODE -->
                    <input class="form-check-input d-none" data-attribute="dir" name="directionModes" value="rtl" type="radio" id="rtlLayouts">
                    <label for="rtlLayouts" class="switcher-card w-100">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                        <span class="w-8px h-8px bg-light rounded-pill"></span>
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                    </span>
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2 vstack align-items-end">
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px me-1"></span>
                                    </span>
                                </span>
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                    <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">RTL Direction</span>
                    </label>
                </div>
            </div>

            <!-- THEME_COLOR -->
            <h6 class="mb-2 fs-5">Preset Themes</h6>
            <p class="text-muted">Choose a preset theme from out theme library.</p>
            <div class="list-group flex-row flex-wrap gap-2 mb-5 template-customizer">

                <!-- PRIMARY -->
                <label for="primary-variant-01" class="list-group-item form-check p-1 rounded-3 m-0" data-theme-color="primary">
                    <span class="form-check-label hstack avatar avatar-item theme-bg-primary rounded-3 border-0">
                        <i class="ri-palette-line"></i>
                    </span>
                    <input id="primary-variant-01" type="radio" data-attribute="data-theme-color" class="form-check-input d-none" name="data-theme-color" value="primary" checked="">
                </label>

                <!-- SECONDARY -->
                <label for="primary-variant-02" class="list-group-item form-check p-1 rounded-3 m-0" data-theme-color="secondary">
                    <span class="form-check-label hstack avatar avatar-item theme-bg-secondary rounded-3 border-0">
                        <i class="ri-palette-line"></i>
                    </span>
                    <input id="primary-variant-02" type="radio" data-attribute="data-theme-color" class="form-check-input d-none" name="data-theme-color" value="secondary">
                </label>

                <!-- SUCCESS -->
                <label for="primary-variant-03" class="list-group-item form-check p-1 rounded-3 m-0" data-theme-color="success">
                    <span class="form-check-label hstack avatar avatar-item theme-bg-success rounded-3 border-0">
                        <i class="ri-palette-line"></i>
                    </span>
                    <input id="primary-variant-03" type="radio" data-attribute="data-theme-color" class="form-check-input d-none" name="data-theme-color" value="success">
                </label>

                <!-- INFO -->
                <label for="primary-variant-04" class="list-group-item form-check p-1 rounded-3 m-0" data-theme-color="info">
                    <span class="form-check-label hstack avatar avatar-item theme-bg-info rounded-3 border-0">
                        <i class="ri-palette-line"></i>
                    </span>
                    <input id="primary-variant-04" type="radio" data-attribute="data-theme-color" class="form-check-input d-none" name="data-theme-color" value="info">
                </label>

                <!-- WARNING -->
                <label for="primary-variant-05" class="list-group-item form-check p-1 rounded-3 m-0" data-theme-color="warning">
                    <span class="form-check-label hstack avatar avatar-item theme-bg-warning rounded-3 border-0">
                        <i class="ri-palette-line"></i>
                    </span>
                    <input id="primary-variant-05" type="radio" data-attribute="data-theme-color" class="form-check-input d-none" name="data-theme-color" value="warning">
                </label>

                <!-- DANGER -->
                <label for="primary-variant-06" class="list-group-item form-check p-1 rounded-3 m-0" data-theme-color="danger">
                    <span class="form-check-label hstack avatar avatar-item theme-bg-danger rounded-3 border-0">
                        <i class="ri-palette-line"></i>
                    </span>
                    <input id="primary-variant-06" type="radio" data-attribute="data-theme-color" class="form-check-input d-none" name="data-theme-color" value="danger">
                </label>

                <!-- BLUE -->
                <label for="primary-variant-09" class="list-group-item form-check p-1 rounded-3 m-0" data-theme-color="blue">
                    <span class="form-check-label hstack avatar avatar-item theme-bg-blue rounded-3 border-0">
                        <i class="ri-palette-line"></i>
                    </span>
                    <input id="primary-variant-09" type="radio" data-attribute="data-theme-color" class="form-check-input d-none" name="data-theme-color" value="blue">
                </label>

                <!-- PURPLE -->
                <label for="primary-variant-11" class="list-group-item form-check p-1 rounded-3 m-0" data-theme-color="purple">
                    <span class="form-check-label hstack avatar avatar-item theme-bg-purple rounded-3 border-0">
                        <i class="ri-palette-line"></i>
                    </span>
                    <input id="primary-variant-11" type="radio" data-attribute="data-theme-color" class="form-check-input d-none" name="data-theme-color" value="purple">
                </label>

                <!-- PINK -->
                <label for="primary-variant-12" class="list-group-item form-check p-1 rounded-3 m-0" data-theme-color="pink">
                    <span class="form-check-label hstack avatar avatar-item theme-bg-pink rounded-3 border-0">
                        <i class="ri-palette-line"></i>
                    </span>
                    <input id="primary-variant-12" type="radio" data-attribute="data-theme-color" class="form-check-input d-none" name="data-theme-color" value="pink">
                </label>

                <!-- ORANGE -->
                <label for="primary-variant-13" class="list-group-item form-check p-1 rounded-3 m-0" data-theme-color="orange">
                    <span class="form-check-label hstack avatar avatar-item theme-bg-orange rounded-3 border-0">
                        <i class="ri-palette-line"></i>
                    </span>
                    <input id="primary-variant-13" type="radio" data-attribute="data-theme-color" class="form-check-input d-none" name="data-theme-color" value="orange">
                </label>

                <!-- TEAL -->
                <label for="primary-variant-16" class="list-group-item form-check p-1 rounded-3 m-0" data-theme-color="teal">
                    <span class="form-check-label hstack avatar avatar-item theme-bg-teal rounded-3 border-0">
                        <i class="ri-palette-line"></i>
                    </span>
                    <input id="primary-variant-16" type="radio" data-attribute="data-theme-color" class="form-check-input d-none" name="data-theme-color" value="teal">
                </label>

            </div>

            <!-- SIDEBAR -->
            <h6 class="mb-2 fs-5">Sidebar Colors</h6>
            <p class="text-muted text-sm">Sets the sidebar color scheme. Options include light, dark, or gradient styles.</p>
            <div class="row g-4 mb-5">

                <div class="col-4">
                    <!-- LIGHT SIDEBAR -->
                    <input class="form-check-input d-none" data-attribute="data-sidebar" name="sidebar-color" value="light-sidebar" type="radio" id="sidebar-color-light" checked="">
                    <label for="sidebar-color-light" class="switcher-card w-100 active" data-sidebar="light-sidebar">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-20px bg-white border-bottom d-block"></span>
                                    <span class="h-100 bg-white d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                        <span class="w-8px h-8px bg-light rounded-pill"></span>
                                    </span>
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2">
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px ms-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Light</span>
                    </label>
                </div>

                <div class="col-4">
                    <!-- DARK SIDEBAR -->
                    <input class="form-check-input d-none" data-attribute="data-sidebar" name="sidebar-color" value="dark-sidebar" type="radio" id="sidebar-color-dark">
                    <label for="sidebar-color-dark" class="switcher-card w-100" data-sidebar="dark-sidebar">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-20px bg-dark border-bottom d-block"></span>
                                    <span class="h-100 bg-dark d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                        <span class="w-8px h-8px bg-light rounded-pill"></span>
                                    </span>
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2">
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px ms-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Dark</span>
                    </label>
                </div>

                <div class="col-4">
                    <!-- GRADIENT SIDEBAR -->
                    <input class="form-check-input d-none" data-attribute="data-sidebar" name="sidebar-color" value="gradient-sidebar" type="radio" id="sidebar-color-gradient">
                    <label for="sidebar-color-gradient" class="switcher-card w-100" data-sidebar="gradient-sidebar">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                    <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                        <span class="w-8px h-8px bg-light rounded-pill"></span>
                                    </span>
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2">
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px ms-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Gradient</span>
                    </label>
                </div>

            </div>

            <!-- NAV_POSITION -->
            <h6 class="mb-2 fs-5">Navbar Positions Options</h6>
            <p class="text-muted">Sets the navbar position: sticky, static, or hidden.</p>

            <div class="row g-4 mb-5">
                <div class="col-4">
                    <!-- STICKY -->
                    <input class="form-check-input d-none" data-attribute="data-nav-position" name="navbarPositionsOption" value="sticky" type="radio" id="navbarPositionsSticky">
                    <label for="navbarPositionsSticky" class="switcher-card w-100 active" data-nav-position="sticky">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                    <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                        <span class="w-8px h-8px bg-light rounded-pill"></span>
                                    </span>
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2">
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px ms-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Sticky</span>
                    </label>
                </div>
                <div class="col-4">
                    <!-- STATIC -->
                    <input class="form-check-input d-none" data-attribute="data-nav-position" name="navbarPositionsOption" value="static" type="radio" id="navbarPositionsStatic">
                    <label for="navbarPositionsStatic" class="switcher-card w-100" data-nav-position="static">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                    <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                        <span class="w-8px h-8px bg-light rounded-pill"></span>
                                    </span>
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2">
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px ms-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Static</span>
                    </label>
                </div>
                <div class="col-4 nav-hidden">
                    <!-- HIDDEN -->
                    <input class="form-check-input d-none" data-attribute="data-nav-position" name="navbarPositionsOption" value="hidden" type="radio" id="navbarPositionsHidden">
                    <label for="navbarPositionsHidden" class="switcher-card w-100" data-nav-position="hidden">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                    <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2">
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px ms-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Hidden</span>
                    </label>
                </div>
            </div>

            <!-- NAV_TYPE -->
            <h6 class="mb-2 fs-5">Navbar Type Options</h6>
            <p class="text-muted">Sets the navbar style: default, dark, transparent, or glass.</p>

            <div class="row g-4 mb-5">
                <div class="col-4">
                    <!-- DEFAULT -->
                    <input class="form-check-input d-none" data-attribute="data-nav-type" name="navbarTypeOption" value="default" type="radio" id="data-nav-default" checked="">
                    <label for="data-nav-default" class="switcher-card w-100 active" data-nav-type="default">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                    <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                        <span class="w-8px h-8px bg-light rounded-pill"></span>
                                    </span>
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2">
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px ms-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Default</span>
                    </label>
                </div>
                <div class="col-4">
                    <!-- DARK -->
                    <input class="form-check-input d-none" data-attribute="data-nav-type" name="navbarTypeOption" value="dark" type="radio" id="data-nav-dark">
                    <label for="data-nav-dark" class="switcher-card w-100" data-nav-type="dark">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                    <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between bg-dark">
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                        <span class="w-8px h-8px bg-light rounded-pill"></span>
                                    </span>
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2">
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px ms-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Dark</span>
                    </label>
                </div>
                <div class="col-4">
                    <!-- GLASS -->
                    <input class="form-check-input d-none" data-attribute="data-nav-type" name="navbarTypeOption" value="glass" type="radio" id="data-nav-glass">
                    <label for="data-nav-glass" class="switcher-card w-100" data-nav-type="glass">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                    <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="px-2 h-20px bg-light border-bottom d-flex align-items-center gap-3 justify-content-between">
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                        <span class="w-12px h-12px bg-secondary-subtle rounded-pill"></span>
                                    </span>
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2">
                                            <span class="w-25 d-block rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px ms-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Glass</span>
                    </label>
                </div>
            </div>

            <!-- FONT  -->
            <h6 class="mb-2 fs-5">Font Options</h6>
            <p class="text-muted">Sets the fonts for headings and body text.</p>
            <div class="row g-4 mb-5">
                <div class="col-12 col-sm-6">
                    <!-- FONT_BODY -->
                    <label class="form-label text-muted fw-semibold fs-12 d-block" for="body-font-choice">Body Font</label>
                    <select class="form-select" id="body-font-choice" data-attribute="data-font-body">
                        <option value="Inter">Inter</option>
                        <option value="Poppins">Poppins</option>
                        <option value="Roboto">Roboto</option>
                        <option value="Open Sans">Open Sans</option>
                        <option value="Lato">Lato</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6">
                    <!-- FONT_HEADING -->
                    <label class="form-label text-muted fw-semibold fs-12 d-block" for="heading-font-choice">Heading Font</label>
                    <select class="form-select" id="heading-font-choice" data-attribute="data-font-heading">
                        <option value="Inter">Inter</option>
                        <option value="Poppins">Poppins</option>
                        <option value="Roboto">Roboto</option>
                        <option value="Open Sans">Open Sans</option>
                        <option value="Lato">Lato</option>
                    </select>
                </div>
            </div>

            <!-- FONT_SIZE -->
            <h6 class="mb-2 fs-5">Font Size Options</h6>
            <p class="text-muted">Sets the font size: sm, md, or lg.</p>

            <div class="list-group flex-row gap-3 mb-3 template-customizer mb-5">
                <!-- SM -->
                <label class="list-group-item form-check rounded mb-0">
                    <span class="d-flex flex-fill my-1">
                        <span class="form-check-label d-flex">
                            <span class="fw-semibold">SM</span>
                        </span>
                        <input type="radio" data-attribute="data-font-size" class="form-check-input cursor-pointer ms-auto" name="font-size-options" value="sm">
                    </span>
                </label>
                <!-- MD -->
                <label class="list-group-item form-check rounded mb-0">
                    <span class="d-flex flex-fill my-1">
                        <span class="form-check-label d-flex">
                            <span class="fw-semibold">MD</span>
                        </span>
                        <input type="radio" data-attribute="data-font-size" class="form-check-input cursor-pointer ms-auto" name="font-size-options" value="md">
                    </span>
                </label>
                <!-- LG -->
                <label class="list-group-item form-check rounded mb-0">
                    <span class="d-flex flex-fill my-1">
                        <span class="form-check-label d-flex">
                            <span class="fw-semibold">LG</span>
                        </span>
                        <input type="radio" data-attribute="data-font-size" class="form-check-input cursor-pointer ms-auto" name="font-size-options" value="lg">
                    </span>
                </label>
            </div>

            <!-- LAYOUT_ROUNDED -->
            <h6 class="mb-2 fs-5">Rounded Options</h6>
            <p class="text-muted">Sets the border radius size: xs, sm, md, lg, or xl.</p>

            <div class="list-group flex-row flex-wrap flex-sm-nowrap gap-3 mb-3 template-customizer mb-5">
                <!-- XS -->
                <label class="list-group-item form-check rounded mb-0">
                    <span class="d-flex flex-fill my-1">
                        <span class="form-check-label d-flex">
                            <span class="fw-semibold">XS</span>
                        </span>
                        <input type="radio" data-attribute="data-layout-rounded" class="form-check-input cursor-pointer ms-auto" name="rounded-options" value="xs">
                    </span>
                </label>
                <!-- SM -->
                <label class="list-group-item form-check rounded mb-0">
                    <span class="d-flex flex-fill my-1">
                        <span class="form-check-label d-flex">
                            <span class="fw-semibold">SM</span>
                        </span>
                        <input type="radio" data-attribute="data-layout-rounded" class="form-check-input cursor-pointer ms-auto" name="rounded-options" value="sm">
                    </span>
                </label>
                <!-- MD -->
                <label class="list-group-item form-check rounded mb-0">
                    <span class="d-flex flex-fill my-1">
                        <span class="form-check-label d-flex">
                            <span class="fw-semibold">MD</span>
                        </span>
                        <input type="radio" data-attribute="data-layout-rounded" class="form-check-input cursor-pointer ms-auto" name="rounded-options" value="md">
                    </span>
                </label>
                <!-- LG -->
                <label class="list-group-item form-check rounded mb-0">
                    <span class="d-flex flex-fill my-1">
                        <span class="form-check-label d-flex">
                            <span class="fw-semibold">LG</span>
                        </span>
                        <input type="radio" data-attribute="data-layout-rounded" class="form-check-input cursor-pointer ms-auto" name="rounded-options" value="lg">
                    </span>
                </label>
                <!-- XL -->
                <label class="list-group-item form-check rounded mb-0">
                    <span class="d-flex flex-fill my-1">
                        <span class="form-check-label d-flex">
                            <span class="fw-semibold">XL</span>
                        </span>
                        <input type="radio" data-attribute="data-layout-rounded" class="form-check-input cursor-pointer ms-auto" name="rounded-options" value="xl">
                    </span>
                </label>
            </div>

            <!-- LAYOUT_CONTAINER -->
            <div class="two-column-hidden">
                <h6 class="mb-2 fs-5">Container Options</h6>
                <p class="text-muted">Defines the container style: fluid (full-width) or boxed (fixed width).</p>
                <div class="row g-4 mb-5">
                    <div class="col-4">
                        <!-- FLUID -->
                        <input class="form-check-input d-none" data-attribute="data-layout-container" name="layoutsContainer" value="fluid" type="radio" id="fluidLayouts" checked="">
                        <label for="fluidLayouts" class="switcher-card w-100 active" data-layout-container="fluid">
                            <span class="border d-block rounded h-100px overflow-hidden">
                                <span class="d-flex h-100">
                                    <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                        <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                        <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                            <span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            </span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                    </span>
                                    <span class="d-flex flex-column flex-grow-1">
                                        <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                            <span class="d-flex align-items-center gap-1">
                                                <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                                <span class="w-8px h-8px bg-success rounded-pill"></span>
                                                <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                            </span>
                                            <span class="w-8px h-8px bg-light rounded-pill"></span>
                                        </span>
                                        <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                            <span class="p-2">
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            </span>
                                            <span class="w-100 bg-light h-6px ms-1"></span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Default</span>
                        </label>
                    </div>
                    <div class="col-4">
                        <!-- BOXED -->
                        <input class="form-check-input d-none" data-attribute="data-layout-container" name="layoutsContainer" value="boxed" type="radio" id="boxedLayouts">
                        <label for="boxedLayouts" class="switcher-card w-100" data-layout-container="boxed">
                            <span class="border d-block rounded h-100px overflow-hidden bg-secondary-subtle">
                                <span class="d-flex h-100 mx-3 bg-white">
                                    <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                        <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                        <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                            <span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                                <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            </span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                    </span>
                                    <span class="d-flex flex-column flex-grow-1">
                                        <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                            <span class="d-flex align-items-center gap-1">
                                                <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                                <span class="w-8px h-8px bg-success rounded-pill"></span>
                                                <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                            </span>
                                            <span class="w-8px h-8px bg-light rounded-pill"></span>
                                        </span>
                                        <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                            <span class="p-2">
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                                <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            </span>
                                            <span class="w-100 bg-light h-6px ms-1"></span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                            <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Boxed</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- PAGE_LOADER -->
            <h6 class="mb-2 fs-5">Loader Options</h6>
            <p class="text-muted">Sets the page loader visibility: hidden or visible.</p>
            <div class="row g-4">
                <div class="col-4">
                    <!-- VISIBLE -->
                    <input class="form-check-input d-none" data-attribute="data-page-loader" name="page-loader" value="visible" type="radio" id="page-loader-visible">
                    <label for="page-loader-visible" class="switcher-card w-100" data-page-loader="visible">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                    <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1 h-100">
                                    <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                        <span class="w-8px h-8px bg-light rounded-pill"></span>
                                    </span>
                                    <span class="h-100 d-flex flex-column justify-content-center align-items-center gap-3">
                                        <span id="status" class="d-flex align-items-center justify-content-center">
                                            <span class="spinner-border text-primary avatar-xxs m-auto" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Loader</span>
                    </label>
                </div>
                <div class="col-4">
                    <!-- HIDDEN -->
                    <input class="form-check-input d-none" data-attribute="data-page-loader" name="page-loader" value="hidden" type="radio" id="page-loader-hidden">
                    <label for="page-loader-hidden" class="switcher-card w-100" data-page-loader="hidden">
                        <span class="border d-block rounded h-100px overflow-hidden">
                            <span class="d-flex h-100">
                                <span class="w-30px d-flex flex-column h-100 flex-shrink-0 border-end">
                                    <span class="h-16px flex-shrink-0 bg-light d-block"></span>
                                    <span class="h-100 flex-grow-1 bg-primary-subtle d-flex flex-column justify-content-between p-1">
                                        <span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                            <span class="h-6px bg-light rounded d-block mb-1"></span>
                                        </span>
                                        <span class="h-6px bg-light rounded d-block mb-1"></span>
                                    </span>
                                </span>
                                <span class="d-flex flex-column flex-grow-1">
                                    <span class="px-2 flex-shrink-0 h-16px border-bottom d-flex align-items-center gap-3 justify-content-between">
                                        <span class="d-flex align-items-center gap-1">
                                            <span class="w-8px h-8px bg-danger rounded-pill"></span>
                                            <span class="w-8px h-8px bg-success rounded-pill"></span>
                                            <span class="w-8px h-8px bg-warning rounded-pill"></span>
                                        </span>
                                        <span class="w-8px h-8px bg-light rounded-pill"></span>
                                    </span>
                                    <span class="h-100 flex-grow-1 d-flex flex-column justify-content-between gap-1">
                                        <span class="p-2">
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-50 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-100 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-75 d-block bg-light rounded-1 h-6px mb-1"></span>
                                            <span class="w-25 d-block bg-light rounded-1 h-6px mb-1"></span>
                                        </span>
                                        <span class="w-100 bg-light h-6px ms-1"></span>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <span class="d-block shadow-none fs-12 fw-semibold text-center pt-2">Disable</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="offcanvas-header border-top hstack gap-3 justify-content-center">
            <button type="button" id="resetSettings" class="btn btn-dark">Reset Layouts</button>
            <button type="button" class="btn btn-danger">Buy Now</button>
        </div>
    </div>
</div>
<!-- END SWITCHER -->



@endsection
