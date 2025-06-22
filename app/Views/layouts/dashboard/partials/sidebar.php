<!-- Sidebar Start -->
<aside class="left-sidebar">
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="./index.html" class="text-nowrap logo-img">
            <img src="<?= base_url('img/header-logo-light.png') ?>" alt="Tektok Adventure Logo" width="160" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-6"></i>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            <li class="nav-small-cap">
                <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                <span class="hide-menu">Beranda</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= route_to('landing.index') ?>" aria-expanded="false">
                    <i class="ti ti-home"></i>
                    <span class="hide-menu">Kembali</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link <?= (uri_string() === 'dashboard/user' || uri_string() === 'dashboard/admin') ? 'active' : '' ?>" href="<?= in_groups('admin') ? route_to('admin.index') : route_to('user.index') ?>" aria-expanded="false">
                    <i class="ti ti-layout"></i>
                    <span class="hide-menu">Dasbor</span>
                </a>
            </li>

            <li>
                <span class="sidebar-divider lg"></span>
            </li>
            <li class="nav-small-cap">
                <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                <span class="hide-menu">Manajemen</span>
            </li>
            <?php if (in_groups('admin')) : ?>
                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between <?= (url_is('dashboard/admin/reports*')) ? 'active' : '' ?>"
                        href="<?= route_to('admin.reports.index') ?>"
                        aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-report"></i>
                            </span>
                            <span class="hide-menu">Laporan</span>
                        </div>

                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between <?= (url_is('dashboard/admin/users*')) ? 'active' : '' ?>"
                        href="<?= route_to('admin.users.index') ?>"
                        aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-users"></i>
                            </span>
                            <span class="hide-menu">Pengguna</span>
                        </div>

                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between <?= url_is('dashboard/admin/products*') ? 'active' : '' ?>"
                        href="<?= route_to('admin.products.index') ?>" aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-briefcase"></i>
                            </span>
                            <span class="hide-menu">Produk</span>
                        </div>

                    </a>
                </li>
            <?php endif; ?>

            <li class="sidebar-item">
                <a class="sidebar-link justify-content-between <?= (url_is('dashboard/admin/orders*') || url_is('dashboard/user/orders*')) ? 'active' : '' ?>"
                    href="<?= in_groups('admin') ? route_to('admin.orders.index') : route_to('user.orders.index') ?>" aria-expanded="false">
                    <div class="d-flex align-items-center gap-3">
                        <span class="d-flex">
                            <i class="ti ti-shopping-cart"></i>
                        </span>
                        <span class="hide-menu">Pesanan</span>
                    </div>

                </a>
            </li>

            <li>
                <span class="sidebar-divider lg"></span>
            </li>
            <li class="nav-small-cap">
                <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                <span class="hide-menu">Pengaturan</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link justify-content-between <?= (uri_string() === 'dashboard/user/profile' || uri_string() === 'dashboard/admin/profile') ? 'active' : '' ?>" href="<?= in_groups('admin') ? route_to('admin.profile.index') : route_to('user.profile.index') ?>" aria-expanded="false">
                    <div class="d-flex align-items-center gap-3">
                        <span class="d-flex">
                            <i class="ti ti-user"></i>
                        </span>
                        <span class="hide-menu">Profil Saya</span>
                    </div>

                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link justify-content-between <?= (uri_string() === 'dashboard/user/profile/edit' || uri_string() === 'dashboard/admin/profile/edit') ? 'active' : '' ?>"
                    href="<?= in_groups('admin') ? route_to('admin.profile.edit') : route_to('user.profile.edit') ?>"
                    aria-expanded="false">
                    <div class="d-flex align-items-center gap-3">
                        <span class="d-flex">
                            <i class="ti ti-pencil"></i>
                        </span>
                        <span class="hide-menu">Ubah Profil</span>
                    </div>

                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link justify-content-between"
                    href="<?= url_to('logout') ?>" aria-expanded="false">
                    <div class="d-flex align-items-center gap-3">
                        <span class="d-flex">
                            <i class="ti ti-transfer-out"></i>
                        </span>
                        <span class="hide-menu">Keluar</span>
                    </div>

                </a>
            </li>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</aside>
<!-- Sidebar End -->