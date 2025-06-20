<?= $this->extend('layouts/landing/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle; ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<section id="hero" class="hero section">

    <img src="<?= base_url() ?>img/hero-bg.jpg" alt="Two People Sitting on a Bench" data-aos="fade-in" style="filter: brightness(0.8);">

    <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 style="text-shadow: 1px 1px 2px #000000;" class="text-white display-4">Petualanganmu di mulai bersama kami</h2>
                <p style="text-shadow: 1px 1px 2px #000000;" class="text-white">Toko peralatan camping berkualitas untuk segala kebutuhan outdoor Anda.</p>
                <a href="#about" class="btn-get-started">Mulai Jelajahi</a>
            </div>
        </div>
    </div>

</section>

<section id="about" class="about section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Tentang Kami</h2>
        <p>Lebih dari sekadar toko peralatan camping, kami adalah partner petualangan Anda</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <div class="col-lg-6">
                <img src="<?= base_url() ?>img/tentang-kami.jpg" class="img-fluid" alt="Tim Tektok Adventure">
            </div>
            <div class="col-lg-6 content">
                <h3>Kenapa Memilih Tektok Adventure?</h3>
                <p class="fst-italic">
                    Sejak 2025, kami berkomitmen menyediakan peralatan camping berkualitas dengan harga terjangkau,
                    karena kami percaya petualangan outdoor adalah hak semua orang.
                </p>
                <ul>
                    <li><i class="bi bi-check2-all"></i> <span><strong>Gear Teruji:</strong> Setiap produk dipilih berdasarkan ketahanan dan fungsionalitas di lapangan.</span></li>
                    <li><i class="bi bi-check2-all"></i> <span><strong>Edukasi Gratis:</strong> Kami menyediakan panduan camping dan tips outdoor untuk pemula.</span></li>
                    <li><i class="bi bi-check2-all"></i> <span><strong>Komunitas:</strong> Bergabunglah dengan grup eksklusif untuk berbagi cerita dan rekomendasi lokasi camping.</span></li>
                </ul>
                <p>
                    Didirikan oleh tim pecinta alam, Tektok Adventure lahir dari pengalaman langsung menggunakan berbagai gear camping.
                    Kami tahu apa yang dibutuhkan saat tenda harus bertahan di hujan deras atau kompor portabel yang efisien.
                    Itulah mengapa kami hanya menjual produk yang kami percaya.
                </p>
            </div>
        </div>
    </div>

</section>

<section id="why-us" class="why-us section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Kenapa Memilih Kami?</h2>
        <p>Alasan mengapa Tektok Adventure menjadi partner camping terpercaya Anda</p>
    </div><!-- End Section Title -->

    <div class="container">
        <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">

            <div class="col-md-4">
                <div class="card">
                    <div class="img">
                        <img src="<?= base_url() ?>img/kualitas-teruji.jpg" alt="Gear Camping Berkualitas" class="img-fluid">
                        <div class="icon"><i class="bi bi-shield-check"></i></div>
                    </div>
                    <h2 class="title"><a href="#" class="stretched-link">Kualitas Teruji</a></h2>
                    <p>
                        Setiap produk kami melalui proses seleksi ketat. Kami hanya menyediakan peralatan yang telah teruji ketahanannya di berbagai kondisi alam, dari hutan hingga pegunungan.
                    </p>
                </div>
            </div><!-- End Card Item -->

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card">
                    <div class="img">
                        <img src="<?= base_url() ?>img/tim-ahli-outdoor.jpg" alt="Tim Berpengalaman" class="img-fluid">
                        <div class="icon"><i class="bi bi-people-fill"></i></div>
                    </div>
                    <h2 class="title"><a href="#" class="stretched-link">Tim Ahli Outdoor</a></h2>
                    <p>
                        Didukung oleh tim yang berpengalaman dalam berbagai ekspedisi. Kami memberikan rekomendasi produk berdasarkan pengalaman nyata di lapangan, bukan hanya teori.
                    </p>
                </div>
            </div><!-- End Card Item -->

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card">
                    <div class="img">
                        <img src="<?= base_url() ?>img/dukungan-360.jpg" alt="Layanan Pelanggan" class="img-fluid">
                        <div class="icon"><i class="bi bi-headset"></i></div>
                    </div>
                    <h2 class="title"><a href="#" class="stretched-link">Dukungan 360°</a></h2>
                    <p>
                        Dari konsultasi produk sebelum pembelian hingga panduan perawatan setelahnya. Kami juga menyediakan komunitas untuk berbagi tips camping dan rekomendasi lokasi.
                    </p>
                </div>
            </div><!-- End Card Item -->

        </div>
    </div>
</section>

<section id="services" class="services section light-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Layanan Kami</h2>
        <p>Solusi lengkap untuk segala kebutuhan petualangan outdoor Anda</p>
    </div><!-- End Section Title -->

    <div class="container">
        <div class="row gy-4">

            <!-- Layanan 1 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Rental Peralatan</h3>
                    </a>
                    <p>Sewa peralatan camping berkualitas untuk kebutuhan short trip. Tersedia paket harian/mingguan dengan harga terjangkau.</p>
                </div>
            </div><!-- End Service Item -->

            <!-- Layanan 2 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Konsultasi Gear</h3>
                    </a>
                    <p>Konsultasi gratis dengan ahli kami untuk memilih peralatan sesuai kebutuhan trip, budget, dan lokasi tujuan Anda.</p>
                </div>
            </div><!-- End Service Item -->

            <!-- Layanan 3 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-tools"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Perbaikan & Perawatan</h3>
                    </a>
                    <p>Layanan servis dan perawatan peralatan camping (tenda, sleeping bag, kompor) untuk memperpanjang usia produk.</p>
                </div>
            </div><!-- End Service Item -->

            <!-- Layanan 4 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-map-fill"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Rekomendasi Lokasi</h3>
                    </a>
                    <p>Panduan lengkap spot camping terbaik di Indonesia, termasuk fasilitas, jalur pendakian, dan tips khusus.</p>
                </div>
            </div><!-- End Service Item -->

            <!-- Layanan 5 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Trip Bersama</h3>
                    </a>
                    <p>Ikuti trip eksklusif komunitas Tektok Adventure dengan guide profesional dan perlengkapan lengkap.</p>
                </div>
            </div><!-- End Service Item -->

            <!-- Layanan 6 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="service-item position-relative">
                    <div class="icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <a href="#" class="stretched-link">
                        <h3>Trade-In Gear</h3>
                    </a>
                    <p>Tukar tambah peralatan lama Anda dengan produk baru kami. Dapatkan nilai terbaik untuk gear bekas berkualitas.</p>
                </div>
            </div><!-- End Service Item -->

        </div>
    </div>
</section>

<section id="products" class="products section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Produk Kami</h2>
        <p>Beragam pilihan ekspedisi untuk pengalaman petualangan tak terlupakan. Lihat lebih banyak <a href="<?= route_to('landing.shop') ?>" class="text-decoration-underline">di sini</a></p>
    </div>
    <!-- End Section Title -->

    <div class="container">
        <div class="row g-4 row-cols-2 row-cols-md-3 justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <?php foreach ($products as $product) : ?>
                <div class="product-item">
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
                                    <?= form_open(route_to('landing.cart.add')) ?>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
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

<section id="contact" class="contact section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Hubungi Kami</h2>
        <p>Hubungi tim kami. Kami siap membantu dengan pertanyaan atau permintaan apa pun yang Anda miliki.</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">

            <div class="col-lg-4">
                <div class="info-item d-flex flex-column justify-content-center align-items-center">
                    <i class="bi bi-geo-alt"></i>
                    <h3>Alamat</h3>
                    <p>Pringgabaya, Lombok Timur, NTB 83654</p>
                </div>
            </div><!-- End Info Item -->

            <div class="col-lg-4">
                <div class="info-item d-flex flex-column justify-content-center align-items-center info-item-borders">
                    <i class="bi bi-telephone"></i>
                    <h3>Telepon</h3>
                    <p>+62 851-3903-8087</p>
                </div>
            </div><!-- End Info Item -->

            <div class="col-lg-4">
                <div class="info-item d-flex flex-column justify-content-center align-items-center">
                    <i class="bi bi-envelope"></i>
                    <h3>Surel</h3>
                    <p>tektokadventure@gmail.com</p>
                </div>
            </div><!-- End Info Item -->

        </div>

        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="300">
            <div class="row gy-4">

                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Tulis namamu di sini" required="">
                </div>

                <div class="col-md-6 ">
                    <input type="email" class="form-control" name="email" placeholder="Tulis surelmu di sini" required="">
                </div>

                <div class="col-md-12">
                    <input type="text" class="form-control" name="subject" placeholder="Tentang apa pesanmu" required="">
                </div>

                <div class="col-md-12">
                    <textarea class="form-control" name="message" rows="6" placeholder="Tulis pesanmu di sini" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                    <div class="loading">Memuat</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Pesan Anda telah terkirim. Terima kasih!</div>

                    <button type="submit">Kirim Pesan</button>
                </div>

            </div>
        </form><!-- End Contact Form -->

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

    .product-item .cart-btn {
        border: 1px solid var(--accent-color);
        transition: ease-in-out .3s;
        color: var(--accent-color);
    }

    .product-item .cart-btn:hover {
        color: var(--contrast-color) !important;
        background-color: var(--accent-color) !important;
    }

    .product-item .badge {
        background-color: var(--accent-color);
        color: var(--contrast-color);
    }
</style>
<?= $this->endSection(); ?>