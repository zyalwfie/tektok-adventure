<?= $this->extend('layouts/auth/app'); ?>

<?= $this->section('page_title'); ?>
Tektok Adventure | Lupa Sandi
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="col-md-8 col-lg-4">
    <div class="card mb-0">
        <div class="card-body">
            <a href="<?= base_url() ?>" class="text-nowrap logo-img text-center d-block py-3 w-100 mb-3">
                <img src="<?= base_url('img/header-logo-light.png') ?>" alt="Tektok Adventure Logo" width="250">
            </a>
            <?= view('Myth\Auth\Views\_message_block') ?>
            <?= form_open(url_to('forgot')) ?>
            <?= csrf_field() ?>
            <div class="form-group mb-3">
                <label for="email">Surel</label>
                <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                    name="email" aria-describedby="emailHelp" placeholder="Tulis surelmu">
                <div class="invalid-feedback">
                    <?= session('errors.email') ?>
                </div>
            </div>

            <div class="d-flex gap-2 align-items-center">
                <a href="<?= url_to('login') ?>" class="btn btn-secondary w-100 py-8 fs-4 rounded-2">Kembali</a>
                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 rounded-2">Kirim Instruksi</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>