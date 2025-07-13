<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= route_to('user.profile.index') ?>">Profil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ganti Sandi</li>
            </ol>
        </nav>

        <h5 class="card-title fw-semibold mb-4">Ganti Sandi</h5>

        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>
                <?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (session()->has('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-x me-2"></i>
                <?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="<?= route_to('user.profile.update.password') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Sandi Saat Ini <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password"
                                class="form-control <?= session('errors.current_password') ? 'is-invalid' : '' ?>"
                                id="current_password"
                                name="current_password"
                                placeholder="Masukkan sandi saat ini"
                                required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                <i class="ti ti-eye"></i>
                            </button>
                            <?php if (session('errors.current_password')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.current_password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Sandi Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password"
                                class="form-control <?= session('errors.new_password') ? 'is-invalid' : '' ?>"
                                id="new_password"
                                name="new_password"
                                placeholder="Masukkan sandi baru"
                                required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                <i class="ti ti-eye"></i>
                            </button>
                            <?php if (session('errors.new_password')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.new_password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted">Minimal 8 karakter, kombinasi huruf besar, huruf kecil, dan angka</small>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Sandi Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password"
                                class="form-control <?= session('errors.confirm_password') ? 'is-invalid' : '' ?>"
                                id="confirm_password"
                                name="confirm_password"
                                placeholder="Konfirmasi sandi baru"
                                required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                <i class="ti ti-eye"></i>
                            </button>
                            <?php if (session('errors.confirm_password')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.confirm_password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="ti ti-info-circle me-2"></i>
                        <div>
                            Setelah mengganti sandi, Anda akan diminta untuk login kembali dengan sandi baru.
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="<?= route_to('admin.profile.index') ?>" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.nextElementSibling;
        const icon = button.querySelector('i');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('ti-eye');
            icon.classList.add('ti-eye-off');
        } else {
            field.type = 'password';
            icon.classList.remove('ti-eye-off');
            icon.classList.add('ti-eye');
        }
    }
</script>
<?= $this->endSection(); ?>