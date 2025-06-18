<?= $this->extend('layouts/auth/app'); ?>

<?= $this->section('page_title'); ?>
Tektok Adventure | Atur Ulang Sandi
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="col-md-8 col-lg-4">
    <div class="card mb-0">
        <div class="card-body">
            <a href="<?= base_url() ?>" class="text-nowrap logo-img text-center d-block py-3 w-100 mb-3">
                <img src="<?= base_url('img/header-logo-light.png') ?>" alt="Tektok Adventure Logo" width="250">
            </a>
            <?= view('Myth\Auth\Views\_message_block') ?>
            <p><?= lang('Auth.enterCodeEmailPassword') ?></p>
            <?= form_open(url_to('reset-password')) ?>
            <?= csrf_field() ?>

            <div class="form-group">
                <label class="form-label" for="token">Token</label>
                <input type="text" class="form-control <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>"
                    name="token" placeholder="Masukkan tokenmu" value="<?= old('token', $token ?? '') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.token') ?>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Surel</label>
                <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                    name="email" aria-describedby="emailHelp" placeholder="Tulis surelmu di sini" value="<?= old('email') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.email') ?>
                </div>
            </div>

            <br>

            <div class="form-group">
                <label class="form-label" for="password">Sandi Baru</label>
                <input type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="***"
                    name="password">
                <div class="invalid-feedback">
                    <?= session('errors.password') ?>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="pass_confirm">Konfirmasi Sandi Baru</label>
                <input type="password" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                    name="pass_confirm">
                <div class="invalid-feedback">
                    <?= session('errors.pass_confirm') ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-3 rounded-2">Atur Ulang</button>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>