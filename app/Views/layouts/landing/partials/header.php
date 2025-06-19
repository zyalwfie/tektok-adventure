<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

        <a href="index.html" class="logo d-flex align-items-center">
            <img src="<?= base_url() ?>img/header-logo-dark.png" alt="Tektok Adventure Logo" width="250">
        </a>

        <div class="d-flex gap-3 align-items-center">
            <nav id="navmenu" class="navmenu">
                <?php if (uri_string() === 'shop') : ?>
                    <ul>
                        <li><a href="<?= base_url('#hero') ?>">Beranda</a></li>
                        <li><a href="<?= base_url('#about') ?>">Tentang</a></li>
                        <li><a href="<?= base_url('#why-us') ?>">Kenapa Kami</a></li>
                        <li><a href="<?= base_url('#services') ?>">Layanan</a></li>
                        <li><a href="<?= base_url('#products') ?>">Produk</a></li>
                        <li><a href="<?= route_to('landing.shop') ?>" class="active">Belanja</a></li>
                        <li><a href="<?= base_url('#contact') ?>">Kontak</a></li>
                        <?php if (logged_in() && in_groups('user')) : ?>
                            <li><a href="<?= route_to('user.index') ?>">Dasbor</a></li>
                            <li><a href="<?= route_to('logout') ?>">Keluar</a></li>
                        <?php elseif (logged_in() && in_groups('admin')) : ?>
                            <li><a href="<?= route_to('admin.index') ?>">Dasbor</a></li>
                            <li><a href="<?= route_to('logout') ?>">Keluar</a></li>
                        <?php endif; ?>
                    </ul>
                <?php else : ?>
                    <ul>
                        <li><a href="#hero">Beranda</a></li>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#why-us">Kenapa Kami</a></li>
                        <li><a href="#services">Layanan</a></li>
                        <li><a href="#products">Produk</a></li>
                        <li><a href="<?= route_to('landing.shop') ?>">Belanja</a></li>
                        <li><a href="#contact">Kontak</a></li>
                        <?php if (logged_in() && in_groups('user')) : ?>
                            <li><a href="<?= route_to('user.index') ?>">Dasbor</a></li>
                            <li><a href="<?= route_to('logout') ?>">Keluar</a></li>
                        <?php elseif (logged_in() && in_groups('admin')) : ?>
                            <li><a href="<?= route_to('admin.index') ?>">Dasbor</a></li>
                            <li><a href="<?= route_to('logout') ?>">Keluar</a></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <?php if (!logged_in()) : ?>
                <a href="<?= url_to('login') ?>" class="header-login-button">
                    Masuk
                </a>
            <?php else : ?>
                <?php if (in_groups('admin')) : ?>
                    <a href="<?= url_to('admin.index') ?>" class="header-login-button">
                        Dasbor
                    </a>
                <?php elseif (in_groups('user')) : ?>
                    <a href="<?= route_to('landing.cart') ?>" class="header-cart-button">
                        <i class="bi-cart-fill me-1"></i>
                        <span
                            class="badge text-white ms-1 rounded-pill">0</span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>


    </div>
</header>