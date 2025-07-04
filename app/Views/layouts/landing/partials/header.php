<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

        <a href="<?= base_url() ?>" class="logo d-flex align-items-center">
            <img src="<?= base_url() ?>img/header-logo-dark.png" alt="Tektok Adventure Logo" width="250">
        </a>

        <div class="d-flex gap-3 align-items-center">
            <nav id="navmenu" class="navmenu">
                <?php if (url_is('shop*') || url_is('cart*')) : ?>
                    <ul>
                        <li><a href="<?= base_url('#hero') ?>" class="text-decoration-none">Beranda</a></li>
                        <li><a href="<?= base_url('#about') ?>" class="text-decoration-none">Tentang</a></li>
                        <li><a href="<?= base_url('#why-us') ?>" class="text-decoration-none">Kenapa Kami</a></li>
                        <li><a href="<?= base_url('#services') ?>" class="text-decoration-none">Layanan</a></li>
                        <li><a href="<?= base_url('#products') ?>" class="text-decoration-none">Produk</a></li>
                        <li><a href="<?= route_to('landing.shop') ?>" class="active text-decoration-none">Belanja</a></li>
                        <li><a href="<?= base_url('#contact') ?>" class="text-decoration-none">Kontak</a></li>
                        <?php if (logged_in() && in_groups('user')) : ?>
                            <li><a href="<?= route_to('user.index') ?>" class="text-decoration-none">Dasbor</a></li>
                            <li><a href="<?= route_to('logout') ?>" class="text-decoration-none">Keluar</a></li>
                        <?php elseif (logged_in() && in_groups('admin')) : ?>
                            <li><a href="<?= route_to('admin.index') ?>" class="text-decoration-none">Dasbor</a></li>
                            <li><a href="<?= route_to('logout') ?>" class="text-decoration-none">Keluar</a></li>
                        <?php endif; ?>
                    </ul>
                <?php else : ?>
                    <ul>
                        <li><a href="#hero" id="nav-beranda" class="text-decoration-none">Beranda</a></li>
                        <li><a href="#about" class="text-decoration-none">Tentang</a></li>
                        <li><a href="#why-us" class="text-decoration-none">Kenapa Kami</a></li>
                        <li><a href="#services" class="text-decoration-none">Layanan</a></li>
                        <li><a href="#products" class="text-decoration-none">Produk</a></li>
                        <li><a href="<?= route_to('landing.shop.index') ?>" class="text-decoration-none">Belanja</a></li>
                        <li><a href="#contact" class="text-decoration-none">Kontak</a></li>
                        <?php if (logged_in() && in_groups('user')) : ?>
                            <li><a href="<?= route_to('user.index') ?>" class="text-decoration-none">Dasbor</a></li>
                            <li><a href="<?= route_to('logout') ?>" class="text-decoration-none">Keluar</a></li>
                        <?php elseif (logged_in() && in_groups('admin')) : ?>
                            <li><a href="<?= route_to('admin.index') ?>" class="text-decoration-none">Dasbor</a></li>
                            <li><a href="<?= route_to('logout') ?>" class="text-decoration-none">Keluar</a></li>
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
                    <?php if ($cartsTotalCount) : ?>
                        <a href="<?= route_to('landing.cart.index') ?>" class="header-cart-button text-decoration-none">
                            <i class="bi-cart-fill me-1"></i>
                            <span
                                class="badge text-white ms-1 rounded-pill"><?= $cartsTotalCount ?></span>
                        </a>
                    <?php else : ?>
                        <a href="<?= route_to('landing.cart.index') ?>" class="header-cart-button text-decoration-none">
                            <i class="bi-cart-fill me-1"></i>
                            <span
                                class="badge text-white ms-1 rounded-pill">0</span>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    </div>
</header>