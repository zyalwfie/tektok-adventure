<?= $this->extend('layouts/landing/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle; ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<section id="hero" class="hero section">

    <img src="<?= base_url() ?>img/hero-bg-cart.jpg" alt="Two People Sitting on a Bench" data-aos="fade-in" style="filter: brightness(0.8);">

    <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 style="text-shadow: 1px 1px 2px #000000;" class="text-white display-4">Keranjang Belanja</h2>
                <p style="text-shadow: 1px 1px 2px #000000;" class="text-white">Di bawah ini daftar semua produk yang kamu tambah ke keranjang belanja.</p>
                <a href="<?= route_to('landing.shop.index') ?>" class="btn-get-started text-decoration-none">Kembali Belanja</a>
            </div>
        </div>
    </div>

</section>


<div class="untree_co-section before-footer-section">
    <div class="container">
        <div class="row mb-5">
            <div class="site-blocks-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="product-thumbnail">Gambar</th>
                            <th class="product-name">Nama</th>
                            <th class="product-price">Harga</th>
                            <th class="product-quantity">
                                Kuantitas
                            </th>
                            <th class="product-total">Total</th>
                            <th class="product-remove">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carts as $cart) : ?>
                            <tr>
                                <td class="product-thumbnail">
                                    <img
                                        src="<?= base_url('img/product/uploads/' . $cart->image) ?>"
                                        alt="<?= $cart->product_name ?>"
                                        class="img-fluid" />
                                </td>
                                <td class="product-name">
                                    <h2 class="h5 text-black">
                                        <?= $cart->product_name ?>
                                    </h2>
                                </td>
                                <td>Rp<?= number_format($cart->price, '0', '.', ',') ?></td>
                                <td>
                                    <div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px">
                                        <div class="input-group-prepend">
                                            <?= form_open(base_url(route_to('landing.cart.decrease', $cart->cart_id))) ?>
                                            <?= csrf_field() ?>
                                            <button class="btn btn-outline-black decrease" type="submit" <?= $cart->quantity <= 1 ? 'disabled' : '' ?>>
                                                <i class="bi bi-dash-lg"></i>
                                            </button>
                                            <?= form_close(); ?>
                                        </div>
                                        <input type="text" class="form-control text-center quantity-amount" value="<?= $cart->quantity ?>" aria-label="Show quantity amount" aria-describedby="button" readonly />
                                        <div class="input-group-append">
                                            <?= form_open(base_url(route_to('landing.cart.increase', $cart->cart_id))) ?>
                                            <?= csrf_field() ?>
                                            <button
                                                class="btn btn-outline-black increase"
                                                type="submit"
                                                <?= $cart->stock < 1 ? 'disabled' : '' ?>>
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                            <?= form_close() ?>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp<?= number_format($cart->price_at_add, '0', '.', ',') ?></td>
                                <td>
                                    <?= form_open(base_url(route_to('landing.cart.destroy', $cart->cart_id))) ?>
                                    <?= csrf_field() ?>
                                    <button
                                        type="submit"
                                        class="btn btn-black btn-sm">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                    <?= form_close(); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?= form_open(base_url(route_to('landing.cart.payment.create')), ['class' => 'row']) ?>
        <div class="col-12 col-lg-6 mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-black">Rincian Pengiriman</h2>
            <div class="p-3 p-lg-5 border bg-white">

                <div class="form-group mb-3 row">
                    <div class="col">
                        <label for="recipient_name" class="text-black">Nama Penerima <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= session('errors.recipient_name') ? 'is-invalid' : '' ?>" id="recipient_name" name="recipient_name" placeholder="Tulis namamu di sini" value="<?= old('recipient_name') ?>">
                        <?php if (session('errors.recipient_name')) : ?>
                            <div class="invalid-feedback">
                                <?= session('errors.recipient_name') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <label for="recipient_email" class="text-black">Email</label>
                        <input type="text" class="form-control <?= session('errors.recipient_email') ? 'is-invalid' : '' ?>" id="recipient_email" name="recipient_email" placeholder="Tulis emailmu di sini" value="<?= old('recipient_email') ?>">
                        <?php if (session('errors.recipient_email')) : ?>
                            <div class="invalid-feedback">
                                <?= session('errors.recipient_email') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="street_address" class="text-black">Alamat Penerima <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= session('errors.street_address') ? 'is-invalid' : '' ?>" id="street_address" name="street_address" placeholder="Tulis alamatmu di sini" value="<?= old('street_address') ?>">
                    <?php if (session('errors.street_address')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.street_address') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="recipient_phone" class="text-black">No. Telepon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= session('errors.recipient_phone') ? 'is-invalid' : '' ?>" id="recipient_phone" name="recipient_phone" placeholder="Tulis nomor teleponmu di sini" aria-describedby="phoneHelp" value="<?= old('recipient_phone') ?>">
                    <?php if (session('errors.recipient_phone')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.recipient_phone') ?>
                        </div>
                    <?php endif; ?>
                    <div id="phoneHelp" class="form-text">Nomor telepon harus format Indonesia yang valid (contoh: 08123456789, +628123456789, 628123456789).</div>
                </div>

                <div class="form-group">
                    <label for="notes" class="text-black">Catatan</label>
                    <textarea name="notes" id="notes" cols="30" rows="5" name="notes" class="form-control" placeholder="Tulis catatanmu di sini..."><?= old('notes') ?></textarea>
                </div>

            </div>
        </div>

        <input type="hidden" name="total_price" value="<?= $cartsTotalAmount ?>">

        <div class="col-12 col-lg-6">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="h3 mb-3 text-black">Pesananmu</h2>
                    <div class="p-3 p-lg-5 border bg-white mb-3">
                        <table class="table site-block-order-table mb-5">
                            <thead>
                                <th>Produk</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <?php foreach ($carts as $cart) : ?>
                                    <tr>
                                        <input type="hidden" name="product_id[]" value="<?= $cart->product_id ?>">
                                        <input type="hidden" name="quantity[]" value="<?= $cart->quantity ?>">
                                        <td><?= $cart->product_name ?> <strong class="mx-2">x</strong> <?= $cart->quantity ?></td>
                                        <td>Rp<?= number_format($cart->price, '0', '.', ',') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td class="text-black font-weight-bold"><strong>Total Pesanan</strong></td>
                                    <td class="text-black font-weight-bold"><strong>Rp<?= number_format($cartsTotalAmount, '0', '.', ',') ?></strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="border p-3 mb-4">
                            <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Transfer ke nomor rekening di bawah</a></h3>

                            <div class="collapse" id="collapsebank">
                                <div class="pt-4 pb-2">
                                    <div class="d-flex gap-4 align-items-center">
                                        <img src="<?= base_url('img/mandiri.svg') ?>" alt="Bank Mandiri" width="100">
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="d-flex flex-column">
                                                <p class="fs-5 fw-bold m-0" id="mandiriBankAccount">1610012697434</p>
                                                <p class="mb-0">atas nama Lingga Jati</p>
                                            </div>
                                            <button type="button" id="mandiriCopyBtn" onclick="copyToClipboard('mandiriCopyIcon', 'mandiriBankAccount')">
                                                <i class="bi bi-clipboard" id="mandiriCopyIcon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-black btn-lg py-3 btn-block w-100" type="submit">Lanjutkan Pembayaran</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?= form_close() ?>
</div>

<?php if(session()->has('not_in_stock')) : ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>
            <?= session('not_in_stock') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php elseif(session()->has('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i>
            <div>
                <?= session('success') ?>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
<?php endif; ?>

<?= $this->endSection(); ?>

<?= $this->section('head_css'); ?>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap");

    body {
        overflow-x: hidden;
        position: relative;
    }

    body {
        font-family: "Inter", sans-serif;
        font-weight: 400;
        line-height: 28px;
        color: #6a6a6a;
        font-size: 14px;
        background-color: #eff2f1;
    }

    a {
        text-decoration: none;
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
        color: #2f2f2f;
        text-decoration: underline;
    }

    a:hover {
        color: #2f2f2f;
        text-decoration: none;
    }

    a.more {
        font-weight: 600;
    }

    .custom-navbar {
        background: #3b5d50 !important;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .custom-navbar .navbar-brand {
        font-size: 32px;
        font-weight: 600;
    }

    .custom-navbar .navbar-brand>span {
        opacity: .4;
    }

    .custom-navbar .navbar-toggler {
        border-color: transparent;
    }

    .custom-navbar .navbar-toggler:active,
    .custom-navbar .navbar-toggler:focus {
        -webkit-box-shadow: none;
        box-shadow: none;
        outline: none;
    }

    @media (min-width: 992px) {
        .custom-navbar .custom-navbar-nav li {
            margin-left: 15px;
            margin-right: 15px;
        }
    }

    .custom-navbar .custom-navbar-nav li a {
        font-weight: 500;
        color: #ffffff !important;
        opacity: .5;
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
        position: relative;
    }

    @media (min-width: 768px) {
        .custom-navbar .custom-navbar-nav li a:before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 8px;
            right: 8px;
            background: #f9bf29;
            height: 5px;
            opacity: 1;
            visibility: visible;
            width: 0;
            -webkit-transition: .15s all ease-out;
            -o-transition: .15s all ease-out;
            transition: .15s all ease-out;
        }
    }

    .custom-navbar .custom-navbar-nav li a:hover {
        opacity: 1;
    }

    .custom-navbar .custom-navbar-nav li a:hover:before {
        width: calc(100% - 16px);
    }

    .custom-navbar .custom-navbar-nav li.active a {
        opacity: 1;
    }

    .custom-navbar .custom-navbar-nav li.active a:before {
        width: calc(100% - 16px);
    }

    .custom-navbar .custom-navbar-cta {
        margin-left: 0 !important;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
    }

    @media (min-width: 768px) {
        .custom-navbar .custom-navbar-cta {
            margin-left: 40px !important;
        }
    }

    .custom-navbar .custom-navbar-cta li {
        margin-left: 0px;
        margin-right: 0px;
    }

    .custom-navbar .custom-navbar-cta li:first-child {
        margin-right: 20px;
    }

    .hero {
        background: #3b5d50;
        padding: calc(4rem - 30px) 0 0rem 0;
    }

    @media (min-width: 768px) {
        .hero {
            padding: calc(4rem - 30px) 0 4rem 0;
        }
    }

    @media (min-width: 992px) {
        .hero {
            padding: calc(8rem - 30px) 0 8rem 0;
        }
    }

    .hero .intro-excerpt {
        position: relative;
        z-index: 4;
    }

    @media (min-width: 992px) {
        .hero .intro-excerpt {
            max-width: 450px;
        }
    }

    .hero h1 {
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 30px;
    }

    @media (min-width: 1400px) {
        .hero h1 {
            font-size: 54px;
        }
    }

    .hero p {
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 30px;
    }

    .hero .img-wrapper {
        position: relative;
    }

    @media (min-width: 1200px) {
        .hero .img-wrapper:after {
            top: -20px;
            right: -20px;
        }
    }

    .btn {
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 30px;
        color: var(--contrast-color);
        background: var(--accent-color);
        border-color: var(--accent-color);
    }

    .btn:hover {
        color: #ffffff;
        background: var(--default-color);
        border-color: var(--default-color);
    }

    .btn:active,
    .btn:focus {
        outline: none !important;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .btn.btn-primary {
        background: #3b5d50;
        border-color: #3b5d50;
    }

    .btn.btn-primary:hover {
        background: #314d43;
        border-color: #314d43;
    }

    .btn.btn-secondary {
        color: #2f2f2f;
        background: #f9bf29;
        border-color: #f9bf29;
    }

    .btn.btn-secondary:hover {
        background: #f8b810;
        border-color: #f8b810;
    }

    .btn.btn-white-outline {
        background: transparent;
        border-width: 2px;
        border-color: rgba(255, 255, 255, 0.3);
    }

    .btn.btn-white-outline:hover {
        border-color: white;
        color: #ffffff;
    }

    .section-title {
        color: #2f2f2f;
    }

    .product-section {
        padding: 7rem 0;
    }

    .product-section .product-item {
        text-align: center;
        text-decoration: none;
        display: block;
        position: relative;
        padding-bottom: 50px;
        cursor: pointer;
    }

    .product-section .product-item .product-thumbnail {
        margin-bottom: 30px;
        position: relative;
        top: 0;
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
    }

    .product-section .product-item h3 {
        font-weight: 600;
        font-size: 16px;
    }

    .product-section .product-item strong {
        font-weight: 800 !important;
        font-size: 18px !important;
    }

    .product-section .product-item h3,
    .product-section .product-item strong {
        color: #2f2f2f;
        text-decoration: none;
    }

    .product-section .product-item .icon-cross {
        position: absolute;
        width: 35px;
        height: 35px;
        display: inline-block;
        background: #2f2f2f;
        bottom: 15px;
        left: 50%;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        margin-bottom: -17.5px;
        border-radius: 50%;
        opacity: 0;
        visibility: hidden;
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
    }

    .product-section .product-item .icon-cross img {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .product-section .product-item:before {
        bottom: 0;
        left: 0;
        right: 0;
        position: absolute;
        content: "";
        background: #dce5e4;
        height: 0%;
        z-index: -1;
        border-radius: 10px;
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
    }

    .product-section .product-item:hover .product-thumbnail {
        top: -25px;
    }

    .product-section .product-item:hover .icon-cross {
        bottom: 0;
        opacity: 1;
        visibility: visible;
    }

    .product-section .product-item:hover:before {
        height: 70%;
    }

    .why-choose-section {
        padding: 7rem 0;
    }

    .why-choose-section .img-wrap {
        position: relative;
    }

    .why-choose-section .img-wrap:before {
        position: absolute;
        content: "";
        width: 255px;
        height: 217px;
        background-image: url("/img/dots-yellow.svg");
        background-repeat: no-repeat;
        background-size: contain;
        -webkit-transform: translate(-40%, -40%);
        -ms-transform: translate(-40%, -40%);
        transform: translate(-40%, -40%);
        z-index: -1;
    }

    .why-choose-section .img-wrap img {
        border-radius: 20px;
    }

    .feature {
        margin-bottom: 30px;
    }

    .feature .icon {
        display: inline-block;
        position: relative;
        margin-bottom: 20px;
    }

    .feature .icon:before {
        content: "";
        width: 33px;
        height: 33px;
        position: absolute;
        background: rgba(59, 93, 80, 0.2);
        border-radius: 50%;
        right: -8px;
        bottom: 0;
    }

    .feature h3 {
        font-size: 14px;
        color: #2f2f2f;
    }

    .feature p {
        font-size: 14px;
        line-height: 22px;
        color: #6a6a6a;
    }

    .we-help-section {
        padding: 7rem 0;
    }

    .we-help-section .imgs-grid:before {
        position: absolute;
        content: "";
        width: 255px;
        height: 217px;
        background-image: url("/img/dots-green.svg");
        background-size: contain;
        background-repeat: no-repeat;
        -webkit-transform: translate(-40%, -40%);
        -ms-transform: translate(-40%, -40%);
        transform: translate(-40%, -40%);
        z-index: -1;
    }

    .we-help-section .imgs-grid .grid {
        position: relative;
    }

    .we-help-section .imgs-grid .grid img {
        border-radius: 20px;
        max-width: 100%;
    }

    .we-help-section .imgs-grid .grid.grid-1 {
        -ms-grid-column: 1;
        -ms-grid-column-span: 18;
        grid-column: 1 / span 18;
        -ms-grid-row: 1;
        -ms-grid-row-span: 27;
        grid-row: 1 / span 27;
    }

    .we-help-section .imgs-grid .grid.grid-2 {
        -ms-grid-column: 19;
        -ms-grid-column-span: 27;
        grid-column: 19 / span 27;
        -ms-grid-row: 1;
        -ms-grid-row-span: 5;
        grid-row: 1 / span 5;
        padding-left: 20px;
    }

    .we-help-section .imgs-grid .grid.grid-3 {
        -ms-grid-column: 14;
        -ms-grid-column-span: 16;
        grid-column: 14 / span 16;
        -ms-grid-row: 6;
        -ms-grid-row-span: 27;
        grid-row: 6 / span 27;
        padding-top: 20px;
    }

    .custom-list {
        width: 100%;
    }

    .custom-list li {
        display: inline-block;
        width: calc(50% - 20px);
        margin-bottom: 12px;
        line-height: 1.5;
        position: relative;
        padding-left: 20px;
    }

    .custom-list li:before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        border: 2px solid #3b5d50;
        position: absolute;
        left: 0;
        top: 8px;
    }

    .popular-product {
        padding: 0 0 7rem 0;
    }

    .popular-product .product-item-sm h3 {
        font-size: 14px;
        font-weight: 700;
        color: #2f2f2f;
    }

    .popular-product .product-item-sm a {
        text-decoration: none;
        color: #2f2f2f;
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
    }

    .popular-product .product-item-sm a:hover {
        color: rgba(47, 47, 47, 0.5);
    }

    .popular-product .product-item-sm p {
        line-height: 1.4;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .popular-product .product-item-sm .thumbnail {
        margin-right: 10px;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 120px;
        flex: 0 0 120px;
        position: relative;
    }

    .popular-product .product-item-sm .thumbnail:before {
        content: "";
        position: absolute;
        border-radius: 20px;
        background: #dce5e4;
        width: 98px;
        height: 98px;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        z-index: -1;
    }

    .testimonial-section {
        padding: 3rem 0 7rem 0;
    }

    .testimonial-slider-wrap {
        position: relative;
    }

    .testimonial-slider-wrap .tns-inner {
        padding-top: 30px;
    }

    .testimonial-slider-wrap .item .testimonial-block blockquote {
        font-size: 16px;
    }

    @media (min-width: 768px) {
        .testimonial-slider-wrap .item .testimonial-block blockquote {
            line-height: 32px;
            font-size: 18px;
        }
    }

    .testimonial-slider-wrap .item .testimonial-block .author-info .author-pic {
        margin-bottom: 20px;
    }

    .testimonial-slider-wrap .item .testimonial-block .author-info .author-pic img {
        max-width: 80px;
        border-radius: 50%;
    }

    .testimonial-slider-wrap .item .testimonial-block .author-info h3 {
        font-size: 14px;
        font-weight: 700;
        color: #2f2f2f;
        margin-bottom: 0;
    }

    .testimonial-slider-wrap #testimonial-nav {
        position: absolute;
        top: 50%;
        z-index: 99;
        width: 100%;
        display: none;
    }

    @media (min-width: 768px) {
        .testimonial-slider-wrap #testimonial-nav {
            display: block;
        }
    }

    .testimonial-slider-wrap #testimonial-nav>span {
        cursor: pointer;
        position: absolute;
        width: 58px;
        height: 58px;
        line-height: 58px;
        border-radius: 50%;
        background: rgba(59, 93, 80, 0.1);
        color: #2f2f2f;
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
    }

    .testimonial-slider-wrap #testimonial-nav>span:hover {
        background: #3b5d50;
        color: #ffffff;
    }

    .testimonial-slider-wrap #testimonial-nav .prev {
        left: -10px;
    }

    .testimonial-slider-wrap #testimonial-nav .next {
        right: 0;
    }

    .testimonial-slider-wrap .tns-nav {
        position: absolute;
        bottom: -50px;
        left: 50%;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
    }

    .testimonial-slider-wrap .tns-nav button {
        background: none;
        border: none;
        display: inline-block;
        position: relative;
        width: 0 !important;
        height: 7px !important;
        margin: 2px;
    }

    .testimonial-slider-wrap .tns-nav button:active,
    .testimonial-slider-wrap .tns-nav button:focus,
    .testimonial-slider-wrap .tns-nav button:hover {
        outline: none;
        -webkit-box-shadow: none;
        box-shadow: none;
        background: none;
    }

    .testimonial-slider-wrap .tns-nav button:before {
        display: block;
        width: 7px;
        height: 7px;
        left: 0;
        top: 0;
        position: absolute;
        content: "";
        border-radius: 50%;
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
        background-color: #d6d6d6;
    }

    .testimonial-slider-wrap .tns-nav button:hover:before,
    .testimonial-slider-wrap .tns-nav button.tns-nav-active:before {
        background-color: #3b5d50;
    }

    .before-footer-section {
        padding: 7rem 0 12rem 0 !important;
    }

    .blog-section {
        padding: 7rem 0 12rem 0;
    }

    .blog-section .post-entry a {
        text-decoration: none;
    }

    .blog-section .post-entry .post-thumbnail {
        display: block;
        margin-bottom: 20px;
    }

    .blog-section .post-entry .post-thumbnail img {
        border-radius: 20px;
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
    }

    .blog-section .post-entry .post-content-entry {
        padding-left: 15px;
        padding-right: 15px;
    }

    .blog-section .post-entry .post-content-entry h3 {
        font-size: 16px;
        margin-bottom: 0;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .blog-section .post-entry .post-content-entry .meta {
        font-size: 14px;
    }

    .blog-section .post-entry .post-content-entry .meta a {
        font-weight: 600;
    }

    .blog-section .post-entry:hover .post-thumbnail img,
    .blog-section .post-entry:focus .post-thumbnail img {
        opacity: .7;
    }

    .footer-section {
        padding: 80px 0;
        background: #ffffff;
    }

    .footer-section .relative {
        position: relative;
    }

    .footer-section a {
        text-decoration: none;
        color: #2f2f2f;
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
    }

    .footer-section a:hover {
        color: rgba(47, 47, 47, 0.5);
    }

    .footer-section .subscription-form {
        margin-bottom: 40px;
        position: relative;
        z-index: 2;
        margin-top: 100px;
    }

    @media (min-width: 992px) {
        .footer-section .subscription-form {
            margin-top: 0px;
            margin-bottom: 80px;
        }
    }

    .footer-section .subscription-form h3 {
        font-size: 18px;
        font-weight: 500;
        color: #3b5d50;
    }

    .footer-section .subscription-form .form-control {
        height: 50px;
        border-radius: 10px;
        font-family: "Inter", sans-serif;
    }

    .footer-section .subscription-form .form-control:active,
    .footer-section .subscription-form .form-control:focus {
        outline: none;
        -webkit-box-shadow: none;
        box-shadow: none;
        border-color: #3b5d50;
        -webkit-box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.2);
        box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.2);
    }

    .footer-section .subscription-form .form-control::-webkit-input-placeholder {
        font-size: 14px;
    }

    .footer-section .subscription-form .form-control::-moz-placeholder {
        font-size: 14px;
    }

    .footer-section .subscription-form .form-control:-ms-input-placeholder {
        font-size: 14px;
    }

    .footer-section .subscription-form .form-control:-moz-placeholder {
        font-size: 14px;
    }

    .footer-section .subscription-form .btn {
        border-radius: 10px !important;
    }

    .footer-section .sofa-img {
        position: absolute;
        top: -200px;
        z-index: 1;
        right: 0;
    }

    .footer-section .sofa-img img {
        max-width: 380px;
    }

    .footer-section .links-wrap {
        margin-top: 0px;
    }

    @media (min-width: 992px) {
        .footer-section .links-wrap {
            margin-top: 54px;
        }
    }

    .footer-section .links-wrap ul li {
        margin-bottom: 10px;
    }

    .footer-section .footer-logo-wrap .footer-logo {
        font-size: 32px;
        font-weight: 500;
        text-decoration: none;
        color: #3b5d50;
    }

    .footer-section .custom-social li {
        margin: 2px;
        display: inline-block;
    }

    .footer-section .custom-social li a {
        width: 40px;
        height: 40px;
        text-align: center;
        line-height: 40px;
        display: inline-block;
        background: #dce5e4;
        color: #3b5d50;
        border-radius: 50%;
    }

    .footer-section .custom-social li a:hover {
        background: #3b5d50;
        color: #ffffff;
    }

    .footer-section .border-top {
        border-color: #dce5e4;
    }

    .footer-section .border-top.copyright {
        font-size: 14px !important;
    }

    .untree_co-section {
        padding: 7rem 0;
    }

    .form-control {
        border-radius: 10px;
        font-family: "Inter", sans-serif;
    }

    .form-control:active,
    .form-control:focus {
        outline: none;
        -webkit-box-shadow: none;
        box-shadow: none;
        border-color: var(--accent-color) !important;
        box-shadow: 0 0 0 0.25rem rgba(253, 104, 14, .25) !important;
    }

    .form-control::-webkit-input-placeholder {
        font-size: 14px;
    }

    .form-control::-moz-placeholder {
        font-size: 14px;
    }

    .form-control:-ms-input-placeholder {
        font-size: 14px;
    }

    .form-control:-moz-placeholder {
        font-size: 14px;
    }

    .service {
        line-height: 1.5;
    }

    .service .service-icon {
        border-radius: 10px;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50px;
        flex: 0 0 50px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        background: #3b5d50;
        margin-right: 20px;
        color: #ffffff;
    }

    textarea {
        height: auto !important;
    }

    .site-blocks-table {
        overflow: auto;
    }

    .site-blocks-table .product-thumbnail {
        width: 200px;
    }

    .site-blocks-table .btn {
        padding: 2px 10px;
    }

    .site-blocks-table thead th {
        padding: 30px;
        text-align: center;
        border-width: 0px !important;
        vertical-align: middle;
        color: rgba(0, 0, 0, 0.8);
        font-size: 18px;
    }

    .site-blocks-table td {
        padding: 20px;
        text-align: center;
        vertical-align: middle;
        color: rgba(0, 0, 0, 0.8);
    }

    .site-blocks-table tbody tr:first-child td {
        border-top: 1px solid #3b5d50 !important;
    }

    .site-blocks-table .btn {
        background: none !important;
        color: #000000;
        border: none;
        height: auto !important;
    }

    .site-block-order-table th {
        border-top: none !important;
        border-bottom-width: 1px !important;
    }

    .site-block-order-table td,
    .site-block-order-table th {
        color: #000000;
    }

    .couponcode-wrap input {
        border-radius: 10px !important;
    }

    .text-primary {
        color: #3b5d50 !important;
    }

    .thankyou-icon {
        position: relative;
        color: #3b5d50;
    }

    .thankyou-icon:before {
        position: absolute;
        content: "";
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(59, 93, 80, 0.2);
    }

    #mandiriCopyBtn {
        width: 40px;
        height: 40px;
        border: 1px solid var(--accent-color);
        background-color: transparent;
        color: var(--accent-color);
        border-radius: 9999rem;
        transition: .1s linear;
    }

    #mandiriCopyBtn:hover {
        background-color: var(--accent-color);
        color: var(--contrast-color);
    }

    #mandiriCopiedText {
        position: absolute;
        width: max-content;
        right: -8px;
        transform: translateX(100%) translateY(1rem);
        opacity: 0;
        transition: .1s ease-in-out;
    }

    .translate-y-0 {
        transform: translateX(100%) translateY(0) !important;
    }

    .opacity-1 {
        opacity: 1 !important;
    }

    .alert {
        position: fixed;
        right: 2rem;
        top: 8rem;
        z-index: 9999;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<script>
    function copyToClipboard(icon, account) {
        const CopyIcon = document.getElementById(icon);
        const bankAccount = document.getElementById(account);

        const textArea = document.createElement("textarea");
        textArea.value = bankAccount.textContent;
        document.body.appendChild(textArea);
        textArea.select();

        try {
            document.execCommand('copy');
            CopyIcon.classList.remove('bi-clipboard');
            CopyIcon.classList.add('bi-clipboard-check');

            setTimeout(() => {
                CopyIcon.classList.remove('bi-clipboard-check');
                CopyIcon.classList.add('bi-clipboard');
            }, 1500);
        } catch (error) {
            console.error('Fallback failed:', error);
        } finally {
            document.body.removeChild(textArea);
        }
    }
</script>
<?= $this->endSection(); ?>