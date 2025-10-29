
@php
    use App\Models\Theme;

    $theme = Theme::where('is_active', 1)->first();

    // Default logo (main)
    $defaultLogo = $theme && $theme->logo && file_exists(public_path($theme->logo))
        ? asset($theme->logo)
        : asset('assets/images/light-logo.png'); // fallback logo

    // Favicon / minimized logo
    $faviconLogo = $theme && $theme->favicon && file_exists(public_path($theme->favicon))
        ? asset($theme->favicon)
        : asset('assets/images/Favicon.png'); // fallback favicon
@endphp


<!-- START SIDEBAR -->
<aside class="app-sidebar">
    <!-- START BRAND LOGO -->
    <div class="app-sidebar-logo px-6 justify-content-center align-items-center">
        <a href="/dashboard">
           {{-- <img height="35" class="app-sidebar-logo-default" alt="Logo" src="{{ asset('assets/images/light-logo.png') }}">
          <img height="40" class="app-sidebar-logo-minimize" alt="Logo" src="{{ asset('assets/images/Favicon.png') }}"> --}}

           <img height="35" class="app-sidebar-logo-default" alt="Logo" src="{{ $defaultLogo }}">
            <img height="40" class="app-sidebar-logo-minimize" alt="Logo" src="{{ $faviconLogo }}">

        </a>
    </div>
    <!-- END BRAND LOGO -->
    <nav class="app-sidebar-menu nav nav-pills flex-column fs-6" id="sidebarMenu" aria-label="Main navigation">
        <ul class="main-menu" id="all-menu-items" role="menu">
            @include('panels.sidebar_menu', ['menus' => $menus])
        </ul>

    </nav>
</aside>
<!-- END SIDEBAR -->
<div class="horizontal-overlay"></div>


















<!-- START SMALL SCREEN SIDEBAR -->
{{-- <div class="offcanvas offcanvas-md offcanvas-start small-screen-sidebar" data-bs-scroll="true" tabindex="-1"
    id="smallScreenSidebar" aria-labelledby="smallScreenSidebarLabel">
    <div class="offcanvas-header hstack border-bottom">
        <!-- START BRAND LOGO -->
        <div class="app-sidebar-logo">
            <a href="index.html">
                <img height="35" class="app-sidebar-logo-default h-25px" alt="Logo" src="assets/images/light-logo.png">
                <img height="40" class="app-sidebar-logo-minimize" alt="Logo" src="assets/images/Favicon.png">
            </a>
        </div>
        <button type="button" class="btn-close bg-transparent" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
    <div class="offcanvas-body p-0">
        <!-- START SIDEBAR -->
        <aside class="app-sidebar">
            <!-- END BRAND LOGO -->
            <nav class="app-sidebar-menu nav nav-pills flex-column fs-6" aria-label="Main navigation">
                <ul class="main-menu" id="all-menu-items" role="menu">
                    <li class="menu-title" role="presentation" data-lang="hr-title-main">Main</li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-home-2-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-dashboards">Dashboards</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="index.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-dashboards-ecommerce">E-Commerce</a>
                            </li>
                            <li class="slide">
                                <a href="dashboard-project-management.html" data-lang="hr-dashboards-project-management"
                                    class="side-menu__item" role="menuitem">Project Management</a>
                            </li>
                            <li class="slide">
                                <a href="dashboard-online-course.html" data-lang="hr-dashboards-online-course"
                                    class="side-menu__item" role="menuitem">Online course</a>
                            </li>
                            <li class="slide">
                                <a href="dashboard-social-media.html" data-lang="hr-dashboards-social-media"
                                    class="side-menu__item" role="menuitem">Social Media</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-layout-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-layout">Layout</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="demo-layout-horizontal.html" target="_blank" class="side-menu__item"
                                    role="menuitem" data-lang="hr-layout-horizontal">Horizontal</a>
                            </li>
                            <li class="slide">
                                <a href="demo-layout-two-column.html" target="_blank" class="side-menu__item"
                                    role="menuitem" data-lang="hr-layout-two-column">Two Column</a>
                            </li>
                            <li class="slide">
                                <a href="demo-layout-semibox.html" target="_blank" class="side-menu__item"
                                    role="menuitem" data-lang="hr-layout-semibox">Semibox</a>
                            </li>
                            <li class="slide">
                                <a href="demo-layout-compact.html" target="_blank" class="side-menu__item"
                                    role="menuitem" data-lang="hr-layout-compact">Compact</a>
                            </li>
                            <li class="slide">
                                <a href="demo-layout-small-icon.html" target="_blank" class="side-menu__item"
                                    role="menuitem" data-lang="hr-layout-small-icon">Small Icon</a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title" role="presentation" data-lang="hr-title-applications">Applications</li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-gallery-view-2"></i></span>
                            <span class="side-menu__label" data-lang="hr-apps">Apps</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="apps-calendar.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-apps-calendar">Calendar</a>
                            </li>
                            <li class="slide">
                                <a href="apps-tasks-kanban.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-apps-kanban">Kanban</a>
                            </li>
                            <li class="slide">
                                <a href="apps-file-manager.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-apps-file-manager">File Manager</a>
                            </li>
                            <li class="slide">
                                <a href="apps-todo.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-apps-to-do">To Do</a>
                            </li>
                            <li class="slide">
                                <a href="apps-chat.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-apps-chat">Chat</a>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-apps-email">Email</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="apps-email-list.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apps-email-inbox">Inbox</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-email-view.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apps-email-view-reply">View & Reply</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-ecommerce">E-Commerce</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="apps-products.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-ecom-products">Products</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-products-list.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-ecom-product-list">Product List</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-product-details.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-ecom-product-details">Product Details</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-product-create.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-ecom-add-product">Add Product</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-product-cart.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-ecom-cart">Cart</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-product-checkout.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-ecom-checkout">Checkout</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-product-category-list.html" class="side-menu__item"
                                            role="menuitem" data-lang="hr-ecom-categories">Categories</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-product-order-list.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-ecom-orders">Orders</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-product-order-details.html" class="side-menu__item"
                                            role="menuitem" data-lang="hr-ecom-order-details">Order Details</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-projects">Projects</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="apps-projects-list.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-projects-list">List</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-projects-overview.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-projects-overview">Overview</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-projects-create.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-projects-create-project">Create Project</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-online-courses">Online Courses</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="apps-course-overview.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-courses-overview">Overview</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-course-details.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-courses-details">Course Details</a>
                                    </li>
                                    <li class="slide">
                                        <a href="#!" class="side-menu__item" role="menuitem">
                                            <span class="side-menu__label" data-lang="hr-teacher">Teacher</span>
                                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                        </a>
                                        <ul class="slide-menu" role="menu">
                                            <li class="slide">
                                                <a href="apps-course-teacher-list.html" class="side-menu__item"
                                                    role="menuitem" data-lang="hr-teacher-list">List</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apps-course-teacher-details.html" class="side-menu__item"
                                                    role="menuitem" data-lang="hr-teacher-details">Details</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apps-course-teacher-add.html" class="side-menu__item"
                                                    role="menuitem" data-lang="hr-teacher-add">Add</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide">
                                        <a href="#!" class="side-menu__item" role="menuitem">
                                            <span class="side-menu__label" data-lang="hr-student">Student</span>
                                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                        </a>
                                        <ul class="slide-menu" role="menu">
                                            <li class="slide">
                                                <a href="apps-course-student-list.html" class="side-menu__item"
                                                    role="menuitem" data-lang="hr-student-list">List</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apps-course-student-details.html" class="side-menu__item"
                                                    role="menuitem" data-lang="hr-student-details">Details</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apps-course-student-add.html" class="side-menu__item"
                                                    role="menuitem" data-lang="hr-student-add">Add</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-social">Social Media</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="apps-social-feeds.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-social-feeds">Feeds</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-social-friends.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-social-friends">Friends</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-social-events.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-social-events">Events</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-social-activity.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-social-activity">Activity</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-social-watch-video.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-social-watch-video">Watch Videos</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-invoices">Invoices</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="apps-invoices-list.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-invoices-list">List</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-invoices-details.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-invoices-details">Details</a>
                                    </li>
                                    <li class="slide">
                                        <a href="apps-create-invoices.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-create-invoices">Create invoice</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title" role="presentation" data-lang="hr-title-pages">Pages</li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-file-text-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-pages">Pages</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="pages-starter.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-pages-start">Start</a>
                            </li>
                            <li class="slide">
                                <a href="pages-timeline.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-pages-timeline">Timeline</a>
                            </li>
                            <li class="slide">
                                <a href="pages-faqs.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-pages-faqs">FAQs</a>
                            </li>
                            <li class="slide">
                                <a href="pages-pricing.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-pages-pricing">Pricing</a>
                            </li>
                            <li class="slide">
                                <a href="pages-gallery.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-pages-gallery">Gallery</a>
                            </li>
                            <li class="slide">
                                <a href="pages-search-result.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-pages-search-result">Search Results</a>
                            </li>
                            <li class="slide">
                                <a href="pages-privacy-policy.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-pages-privacy-policy">Privacy Policy</a>
                            </li>
                            <li class="slide">
                                <a href="pages-terms-conditions.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-pages-terms-conditions">Terms & Conditions</a>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-blog">Blog</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="pages-blog-list.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-blog-list">Blog List</a>
                                    </li>
                                    <li class="slide">
                                        <a href="pages-blog-details.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-blog-details">Blog Details</a>
                                    </li>
                                    <li class="slide">
                                        <a href="pages-blog-create.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-create-blog">Create Blog</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-user-profile">User Profile</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="pages-profile-overview.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-profile-overview">Overview</a>
                                    </li>
                                    <li class="slide">
                                        <a href="pages-profile-project.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-profile-project">Project</a>
                                    </li>
                                    <li class="slide">
                                        <a href="pages-profile-documents.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-profile-documents">Documents</a>
                                    </li>
                                    <li class="slide">
                                        <a href="pages-profile-connections.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-profile-connections">Connections</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-account-settings">Account
                                        Settings</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="pages-profile-edit-overview.html" class="side-menu__item"
                                            role="menuitem" data-lang="hr-profile-setting-overview">Overview</a>
                                    </li>
                                    <li class="slide">
                                        <a href="pages-profile-edit-security.html" class="side-menu__item"
                                            role="menuitem" data-lang="hr-profile-setting-security">Security</a>
                                    </li>
                                    <li class="slide">
                                        <a href="pages-profile-edit-billing-plans.html" class="side-menu__item"
                                            role="menuitem" data-lang="hr-profile-setting-billing">Billing & Plans</a>
                                    </li>
                                    <li class="slide">
                                        <a href="pages-profile-edit-notifications.html" class="side-menu__item"
                                            role="menuitem"
                                            data-lang="hr-profile-setting-notifications">Notifications</a>
                                    </li>
                                    <li class="slide">
                                        <a href="pages-profile-edit-connections.html" class="side-menu__item"
                                            role="menuitem" data-lang="hr-profile-setting-connections">Connections</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-authentication">Authentication</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="auth-lockscreen.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-auth-lock-screen">Lock Screen</a>
                                    </li>
                                    <li class="slide">
                                        <a href="auth-coming-soon.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-auth-coming-soon">Coming Soon</a>
                                    </li>
                                    <li class="slide">
                                        <a href="auth-create-password.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-auth-create-password">Create Password</a>
                                    </li>
                                    <li class="slide">
                                        <a href="auth-reset-password.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-auth-reset-password">Reset Password</a>
                                    </li>
                                    <li class="slide">
                                        <a href="auth-signup.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-auth-sign-up">Sign Up</a>
                                    </li>
                                    <li class="slide">
                                        <a href="auth-signin.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-auth-sign-in">Sign in</a>
                                    </li>
                                    <li class="slide">
                                        <a href="auth-two-step-verify.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-auth-two-step-verification">Two Step Verification</a>
                                    </li>
                                    <li class="slide">
                                        <a href="under-maintenance.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-auth-maintenance">Under Maintenance</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-error-pages">Error Pages</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="auth-401.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-error-401">401</a>
                                    </li>
                                    <li class="slide">
                                        <a href="auth-404.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-error-404">404</a>
                                    </li>
                                    <li class="slide">
                                        <a href="auth-500.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-error-500">500</a>
                                    </li>
                                    <li class="slide">
                                        <a href="auth-offine.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-error-offline">offline page</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-pantone-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-base-ui">Base UI</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="ui-alert.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-alert">Alert</a>
                            </li>
                            <li class="slide">
                                <a href="ui-badges.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-badge">Badge</a>
                            </li>
                            <li class="slide">
                                <a href="ui-breadcrumbs.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-breadcrumb">Breadcrumb</a>
                            </li>
                            <li class="slide">
                                <a href="ui-buttons.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-button">Buttons</a>
                            </li>
                            <li class="slide">
                                <a href="ui-button-group.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-button-group">Button Group</a>
                            </li>
                            <li class="slide">
                                <a href="ui-card.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-card">Cards</a>
                            </li>
                            <li class="slide">
                                <a href="ui-carousel.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-carousel">Carousel</a>
                            </li>
                            <li class="slide">
                                <a href="ui-cookie.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-cookie">Cookie</a>
                            </li>
                            <li class="slide">
                                <a href="ui-dropdowns.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-dropdown">Dropdown</a>
                            </li>
                            <li class="slide">
                                <a href="ui-images-figures.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-image-figure">Images & Figures</a>
                            </li>
                            <li class="slide">
                                <a href="ui-links.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-link">Links</a>
                            </li>
                            <li class="slide">
                                <a href="ui-list.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-list">List Group</a>
                            </li>
                            <li class="slide">
                                <a href="ui-modal.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-modal">Modal</a>
                            </li>
                            <li class="slide">
                                <a href="ui-tabs.html" class="side-menu__item" role="menuitem" data-lang="hr-ui-tab">Nav
                                    & Tabs</a>
                            </li>
                            <li class="slide">
                                <a href="ui-offcanvas.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-offcanvas">Off Canvas</a>
                            </li>
                            <li class="slide">
                                <a href="ui-pagination.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-pagination">Pagination</a>
                            </li>
                            <li class="slide">
                                <a href="ui-placeholders.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-placeholder">Placeholders</a>
                            </li>
                            <li class="slide">
                                <a href="ui-popover.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-popover">Popovers</a>
                            </li>
                            <li class="slide">
                                <a href="ui-progress.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-progress">Progress</a>
                            </li>
                            <li class="slide">
                                <a href="ui-spinner.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-spinner">Spinners</a>
                            </li>
                            <li class="slide">
                                <a href="ui-scrollspy.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-scrollspy">Scroll Spy</a>
                            </li>
                            <li class="slide">
                                <a href="ui-separator.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-separator">Separator</a>
                            </li>
                            <li class="slide">
                                <a href="ui-toast.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-toast">Toasts</a>
                            </li>
                            <li class="slide">
                                <a href="ui-tooltips.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-tooltip">Tooltips</a>
                            </li>
                            <li class="slide">
                                <a href="ui-typography.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-typography">Typography</a>
                            </li>
                            <li class="slide">
                                <a href="ui-utilities.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-utility">Utilities</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-inbox-unarchive-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-advanced-ui">Advanced UI</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="ui-accordions.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-accordion">Accordians</a>
                            </li>
                            <li class="slide">
                                <a href="ui-avatars.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-avatar">Avatar</a>
                            </li>
                            <li class="slide">
                                <a href="ui-block.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-block">Block</a>
                            </li>
                            <li class="slide">
                                <a href="ui-countup.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-countup">Count Up</a>
                            </li>
                            <li class="slide">
                                <a href="ui-draggable-cards.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-draggable-card">Draggable Cards</a>
                            </li>
                            <li class="slide">
                                <a href="ui-media-player.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-media-player">Media Player</a>
                            </li>
                            <li class="slide">
                                <a href="ui-ratings.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-rating">Rating</a>
                            </li>
                            <li class="slide">
                                <a href="ui-sortable-js.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-sortablejs">Sortable JS</a>
                            </li>
                            <li class="slide">
                                <a href="ui-sweetalert2.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-sweetalert2">Sweet Alert</a>
                            </li>
                            <li class="slide">
                                <a href="ui-advance-swiper.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-swiper">Swiper JS</a>
                            </li>
                            <li class="slide">
                                <a href="ui-tour.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-tour">Tour</a>
                            </li>
                            <li class="slide">
                                <a href="ui-treeview.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-ui-treeview">Tree View</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-input-field"></i></span>
                            <span class="side-menu__label" data-lang="hr-forms">Forms</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-form-elements">Form Elements</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="ui-form-elements.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-form-input">Input</a>
                                    </li>
                                    <li class="slide">
                                        <a href="ui-form-checkboxs-radios.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-form-checkbox-radio">Checkbox & Radios</a>
                                    </li>
                                    <li class="slide">
                                        <a href="ui-form-input-group.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-form-input-group">Inout Group</a>
                                    </li>
                                    <li class="slide">
                                        <a href="ui-form-select.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-form-select">Form Select</a>
                                    </li>
                                    <li class="slide">
                                        <a href="ui-form-range.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-form-range">Range Slider</a>
                                    </li>
                                    <li class="slide">
                                        <a href="ui-form-input-masks.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-form-input-masks">Input Masks</a>
                                    </li>
                                    <li class="slide">
                                        <a href="ui-form-file-uploads.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-form-file-upload">File Uploads</a>
                                    </li>
                                    <li class="slide">
                                        <a href="ui-date-picker.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-form-date-time-picker">Date,Time Picker</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="ui-floating-labels.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-form-floating-label">Floating Label</a>
                            </li>
                            <li class="slide">
                                <a href="ui-form-layout.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-form-layout">Form Layout</a>
                            </li>
                            <li class="slide">
                                <a href="ui-form-editor.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-form-editor">Editor</a>
                            </li>
                            <li class="slide">
                                <a href="ui-form-validation.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-form-validation">Form Validation</a>
                            </li>
                            <li class="slide">
                                <a href="ui-form-wizards.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-form-wizard">Form Wizards</a>
                            </li>
                            <li class="slide">
                                <a href="ui-form-advanced.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-form-advanced">Form Advanced</a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title" role="presentation" data-lang="hr-title-tables">Other</li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-table-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-tables">Tables</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="ui-tables-basic.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-basic-table">Basic Tables</a>
                            </li>
                            <li class="slide">
                                <a href="ui-tables-listjs.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-listjs-table">List JS Table</a>
                            </li>
                            <li class="slide">
                                <a href="ui-tables-gridjs.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-gridjs-table">Grid JS Table</a>
                            </li>
                            <li class="slide">
                                <a href="ui-tables-datatables.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-datatables">Datatables</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-pie-chart-2-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-charts">Charts</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-apexcharts">Apexcharts</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="chart-apex-line.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-line">Line</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-area.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-area">Area</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-column.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-column">Column</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-bar.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-bar">Bar</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-mixed.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-mixed">Mixed</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-range-area.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-range-area">Range Charts</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-timeline.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-timeline">Timeline</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-funnel.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-funnel">Funnel</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-candlestick.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-candlestick">Candlestick</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-boxplot.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-boxplot">Boxplot</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-pie.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-pie">Pie</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-radar.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-radar">Radar</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-polar.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-polar">Polar</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-radialbar.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-radialbar">Radialbar</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-bubble.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-bubble">Bubble</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-scatter.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-scatter">Scatter</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-heatmap.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-heatmap">Heatmap</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-treemap.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-treemap">Treemap</a>
                                    </li>
                                    <li class="slide">
                                        <a href="charts-apex-slope.html" class="side-menu__item" role="menuitem"
                                            data-lang="hr-apex-slope">Slope</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="chart-js-chart.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-chartjs">Chartjs</a>
                            </li>
                            <li class="slide">
                                <a href="charts-echarts.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-echarts">Echarts</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-map-2-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-maps">Maps</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="google-maps.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-google-maps">Google Maps</a>
                            </li>
                            <li class="slide">
                                <a href="leaflet-maps.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-leaflet-maps">Leaflet Maps</a>
                            </li>
                            <li class="slide">
                                <a href="vector-maps.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-vector-maps">Vector Maps</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-terminal-box-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-icons">Icons</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="icons-remix.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-remix">Remix Icons</a>
                            </li>
                            <li class="slide">
                                <a href="icons-bootstrap-icons.html" class="side-menu__item" role="menuitem"
                                    data-lang="hr-bootstrap-icons">Bootstrap Icons</a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title" role="presentation" data-lang="hr-title-other">Other</li>
                    <li class="slide">
                        <a href="#!" class="side-menu__item" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-organization-chart"></i></span>
                            <span class="side-menu__label" data-lang="hr-menu-levels">Menu levels</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu" role="menu">
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem" data-lang="hr-level-2-1">Level
                                    2.1</a>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-level-2-2">Level 2.2</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="#!" class="side-menu__item" role="menuitem"
                                            data-lang="hr-level-3-1">Level 3.1</a>
                                    </li>
                                    <li class="slide">
                                        <a href="#!" class="side-menu__item" role="menuitem"
                                            data-lang="hr-level-3-2">Level 3.2</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="#!" class="side-menu__item" role="menuitem">
                                    <span class="side-menu__label" data-lang="hr-level-2-3">Level 2.3</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu" role="menu">
                                    <li class="slide">
                                        <a href="#!" class="side-menu__item" role="menuitem"
                                            data-lang="hr-level-3-3">Level 3.3</a>
                                    </li>
                                    <li class="slide">
                                        <a href="#!" class="side-menu__item" role="menuitem"
                                            data-lang="hr-level-3-4">Level 3.4</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>
    </div>
</div> --}}
<!-- START PRELOADER -->
{{-- <div class="align-items-center justify-content-center" id="preloader">
    <div class="spinner-border text-primary avatar-sm" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div> --}}
<!-- END PRELOADER -->
