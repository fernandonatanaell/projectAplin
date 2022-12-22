<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="../templates/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Welcome Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            Controls
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?content=Users"
                                class="nav-link <?php if($_REQUEST['content'] == 'Users') echo 'active' ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?content=Products"
                                class="nav-link <?php if($_REQUEST['content'] == 'Products') echo 'active' ?>">
                                <i class="nav-icon fas fa-mobile-alt"></i>
                                <p>
                                    Products
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?content=Discounts"
                                class="nav-link <?php if($_REQUEST['content'] == 'Discounts') echo 'active' ?>">
                                <i class="nav-icon fas fa-percent"></i>
                                <p>
                                    Discounts
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Reports
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?content=Overview"
                                class="nav-link <?php if($_REQUEST['content'] == 'Overview') echo 'active' ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Overview
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?content=Product"
                                class="nav-link <?php if($_REQUEST['content'] == 'Product') echo 'active' ?>">
                                <i class="nav-icon fas fa-trophy"></i>
                                <p>
                                    Product
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?content=Category"
                                class="nav-link <?php if($_REQUEST['content'] == 'Category') echo 'active' ?>">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>
                                    Category
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?content=Brand"
                                class="nav-link <?php if($_REQUEST['content'] == 'Brand') echo 'active' ?>">
                                <i class="nav-icon fas fa-mobile"></i>
                                <p>
                                    Brand
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?content=User"
                                class="nav-link <?php if($_REQUEST['content'] == 'User') echo 'active' ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    User
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item bg-danger">
                    <a href="./controllers/logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>