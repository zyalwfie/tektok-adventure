<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-4">
        <h5 class="card-title fw-semibold mb-3">Avatar</h5>
        <div class="card py-4">
            <img id="imgPreview" src="<?= base_url('img/profile/') . user()->avatar ?>" alt="<?= user()->username ?>" style="width: 81%; margin: auto;">
        </div>
    </div>
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title fw-semibold">Detail Profil</h5>
            <?php if (session()->has('success')) : ?>
                <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                    <i class="ti ti-checks"></i>
                    <?= session('success') ?>
                </div>
            <?php elseif (session()->has('failed')) : ?>
                <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                    <i class="ti ti-x"></i>
                    <?= session('failed') ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="full_name" class="form-label">Name Lengkap</label>
                    <input
                        type="text"
                        class="form-control" disabled name="full_name" value="<?= user()->full_name ?>" name="full_name"
                        <?php if (user()->full_name) : ?>
                        value="<?= user()->full_name ?>"
                        <?php else : ?>
                        placeholder="Belum ada nama lengkap"
                        <?php endif; ?>>
                    <div class="invalid-feedback">
                        <?= session('errors.full_name') ?>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="full_name" class="form-label">Name Pengguna</label>
                    <input type="text" class="form-control" disabled name="username" value="<?= user()->username ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.username') ?>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="full_name" class="form-label">Surel</label>
                    <input type="email" class="form-control" disabled name="email" value="<?= user()->email ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.username') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>