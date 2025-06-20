<?= $this->extend('layouts/landing/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle; ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Hero section -->
<section id="hero" class="hero section">

    <img src="<?= base_url() ?>img/hero-bg-shop.jpg" alt="Snow Camping" data-aos="fade-in" style="filter: brightness(0.8);">

    <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 style="text-shadow: 1px 1px 2px #000000;" class="text-white display-4"><?= $product['name'] ?></h2>
                <p style="text-shadow: 1px 1px 2px #000000;" class="text-white">Lihat di bawah untuk detail produk yang kamu pilih</p>
                <a href="<?= route_to('landing.shop.index') ?>" class="btn-get-started">Kembali</a>
            </div>
        </div>
    </div>
</section>

<!-- Product section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?= base_url('img/product/uploads/') . $product['image'] ?>" alt="<?= $product['image'] ?>" /></div>
            <div class="col-md-6">
                <div class="small mb-1">Detail Produk</div>
                <h1 class="display-5 fw-bolder"><?= $product['name'] ?></h1>
                <div class="fs-5 mb-3">
                    <?php if ($product['discount']) : ?>
                        <?php $discountPrice = $product['discount'] / 100 * $product['price'] ?>
                        <span class="text-decoration-line-through">Rp<?= number_format($product['price'], '0', '.', ',') ?></span>
                        <span>Rp<?= number_format($discountPrice, '0', '.', ',') ?></span>
                    <?php else : ?>
                        <span>Rp<?= number_format($product['price'], '0', '.', ',') ?></span>
                    <?php endif; ?>
                    <span>/</span>
                    <small>Sisa stok <?= $product['stock'] ?></small>
                </div>
                <p class="lead">
                    <?= $product['description'] ?>
                </p>
                <?php if (session()->has('not_in_stock')) : ?>
                    <div class="alert alert-danger d-flex align-items-center gap-2 alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-diamond"></i>
                        <div>
                            <?= session('not_in_stock') ?>
                        </div>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php elseif (session()->has('wrong_type_of')) : ?>
                        <div class="alert alert-danger d-flex align-items-center gap-2 alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-diamond"></i>
                            <div>
                                <?= session('wrong_type_of') ?>
                            </div>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php endif; ?>
                <?php if (logged_in()) : ?>
                    <form action="<?= route_to('landing.cart.add') ?>" method="post" class="d-flex">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input class="form-control text-center me-3 <?= session()->has('not_in_stock') ? 'is-invalid' : ''  ?>" id="inputQuantity" type="num" value="<?= old('quantity', 1) ?>" style="max-width: 4.75rem" name="quantity" />
                        <button class="btn cart-btn flex-shrink-0" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Tambah
                        </button>
                    </form>
                    <div class="invalid-feedback">
                        <?= session('not_in_stock') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Related items section-->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Produk terkait</h2>
        <div class="row g-4 justify-content-center">
            <?php foreach ($relatedProducts as $product) : ?>
                <div class="product-item col-6 col-md-3">
                    <div class="card h-100">
                        <?php if ($product['discount']) : ?>
                            <!-- Sale badge-->
                            <div
                                class="badge position-absolute"
                                style="top: 0.5rem; right: 0.5rem">
                                Promo
                            </div>
                        <?php endif; ?>
                        <!-- Product image-->
                        <img
                            class="card-img-top"
                            src="<?= base_url('img/product/uploads/') . $product['image'] ?>"
                            alt="<?= $product['name'] ?>" />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"><?= $product['name'] ?></h5>
                                <?php if ($product['discount']) : ?>
                                    <!-- Product real price -->
                                    <small class="text-decoration-line-through me-1">Rp<?= number_format($product['price'], '0', '.', ',') ?></small>
                                    <!-- Product discount price -->
                                    <?php $discountPrice = $product['discount'] / 100 * $product['price'] ?>
                                    <span>Rp<?= number_format($discountPrice, '0', '.', ',') ?></span>
                                <?php else : ?>
                                    <!-- Product price -->
                                    <span>Rp<?= number_format($product['price'], '0', '.', ',') ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div
                            class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="d-flex flex-column flex-md-row gap-2 align-items-center justify-content-center">
                                <a
                                    class="btn cart-btn mt-auto"
                                    href="<?= route_to('landing.shop.show', $product['slug']) ?>">
                                    Lihat detail
                                </a>
                                <?php if (logged_in()) : ?>
                                    <?= form_open(route_to('landing.shop.add')) ?>
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn cart-btn">
                                        <i class="bi bi-cart-plus-fill"></i>
                                    </button>
                                    <?= form_close() ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('head_css'); ?>
<style>
    .product-item .card {
        transition: .3s ease-in-out;
    }

    .product-item .card:hover {
        border-color: var(--accent-color);
    }

    .cart-btn {
        border: 1px solid var(--accent-color);
        transition: ease-in-out .3s;
        color: var(--accent-color);
    }

    .cart-btn:hover {
        color: var(--contrast-color) !important;
        background-color: var(--accent-color) !important;
    }

    .product-item .badge {
        background-color: var(--accent-color);
        color: var(--contrast-color);
    }

    .form-control:active,
    .form-control:focus {
        outline: none;
        -webkit-box-shadow: none;
        box-shadow: none;
        border-color: var(--accent-color) !important;
        box-shadow: 0 0 0 0.25rem rgba(253, 104, 14, .25) !important;
    }
</style>
<?= $this->endSection(); ?>