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
                <a href="<?= base_url() ?>" class="btn-get-started">Kembali</a>
            </div>
        </div>
    </div>

</section>
<?= $this->endSection(); ?>