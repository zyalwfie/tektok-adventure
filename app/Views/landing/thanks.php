<?= $this->extend('layouts/landing/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle; ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<section id="hero" class="hero section">

    <img src="<?= base_url() ?>img/bg-hero-payment.jpg" alt="Two People Sitting on a Bench" data-aos="fade-in" style="filter: brightness(0.8);">

    <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 style="text-shadow: 1px 1px 2px #000000;" class="text-white display-4">Terima Kasih</h2>
                <p style="text-shadow: 1px 1px 2px #000000;" class="text-white">Pesanan kamu sedang diproses, mohon dicek kembali bukti pembayaran</p>
                <div class="d-flex gap-2 align-items-center justify-content-center">
                    <a href="<?= base_url() ?>" class="btn-get-started">Beranda</a>
                    <a href="<?= route_to('user.orders.index') ?>" class="btn-get-started">Cek Pesanan</a>
                </div>
            </div>
        </div>
    </div>

</section>
<?= $this->endSection(); ?>

<?= $this->section('head_css'); ?>
<style>
    .alert {
        position: fixed;
        right: 2rem;
        top: 8rem;
        z-index: 9999;
    }

    .payment-section {
        margin-inline: 1rem;
        margin-block: 5rem;
    }

    .upload-btn {
        background-color: var(--accent-color);
        color: var(--contrast-color);
    }

    .upload-btn:hover {
        background-color: var(--heading-color);
        color: var(--contrast-color);
    }
</style>
<?= $this->endSection(); ?>