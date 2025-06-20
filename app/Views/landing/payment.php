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
                <h2 style="text-shadow: 1px 1px 2px #000000;" class="text-white display-4">Pembayaran</h2>
                <p style="text-shadow: 1px 1px 2px #000000;" class="text-white">Silahkan unggah bukti pembayaranmu di bawah</p>
            </div>
        </div>
    </div>

</section>

<div class="payment-section">
    <?= form_open_multipart(base_url(route_to('landing.cart.payment.upload'))) ?>
    <div class="row justify-content-center">
        <div class="col-md-6 mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-black">Bukti Pembayaran</h2>
            <div class="p-3 p-lg-5 border bg-white">
                <div class="mb-4">
                    <div id="previewImg" class="mb-3"></div>
                    <label for="proof_of_payment" class="form-label">File Bukti Pembayaran</label>
                    <input class="form-control <?= session('errors.proof_of_payment') ? 'is-invalid' : '' ?>" type="file" id="proof_of_payment" name="proof_of_payment" accept="image/*,application/pdf" onchange="previewProof(event)">
                    <?php if (session('errors.proof_of_payment')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.proof_of_payment') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="order_id" value="<?= $order_id ?>">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="<?= base_url(route_to('landing.cart.payment.done')) ?>" class="btn btn-secondary">Lakukan Nanti</a>
                    <button type="submit" class="btn upload-btn">Unggah Bukti</button>
                </div>
            </div>
        </div>
    </div>
    <?= form_close() ?>
</div>

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

<?= $this->section('foot_js'); ?>
<script>
    function previewProof(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('previewImg');
        previewContainer.innerHTML = '';
        if (!file) return;
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = '100%';
            img.style.maxHeight = '300px';
            img.className = 'img-fluid border rounded';
            previewContainer.appendChild(img);
        } else {
            previewContainer.innerHTML = '<span class="text-danger">File tidak didukung.</span>';
        }
    }
</script>
<?= $this->endSection(); ?>