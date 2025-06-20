<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<form action="<?= route_to('user.profile.update') ?>" class="row" method="post">
    <?= csrf_field() ?>
    <div class="col-lg-4">
        <div class="card pt-4">
            <img id="imgPreview" src="<?= base_url('img/profile/') . user()->avatar ?>" alt="<?= user()->username ?>" style="width: 81%; margin: auto;">
            <div class="card-body">
                <div class="row row-cols-4 justify-content-center align-items-center gy-3">
                    <?php for ($i = 1; $i <= 8; $i++) : ?>
                        <div class="col input-container">
                            <input class="radio-input" type="radio" name="avatar" value="<?= "user-$i.svg" ?>" id="<?= "avatar-$i" ?>" <?= user()->avatar === "user-$i.svg" ? 'checked' : '' ?>>
                            <label for="<?= "avatar-$i" ?>" class="avatar-label">
                                <img src="<?= base_url('img/profile/') . "user-$i.svg" ?>" alt="Profile <?= $i ?>" style="width: 100%; object-fit: cover;">
                            </label>
                        </div>
                    <?php endfor ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <h5 class="card-title fw-semibold mb-4">Detail Profil</h5>
        <div class="card">
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="full_name" class="form-label">Name Lengkap</label>
                    <input
                        type="text"
                        class="form-control <?= session('errors.full_name') ? 'is-invalid' : '' ?>" name="full_name" value="<?= user()->full_name ?>" name="full_name"
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
                    <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" name="username" value="<?= user()->username ?>" required>
                    <div class="invalid-feedback">
                        <?= session('errors.username') ?>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="full_name" class="form-label">Surel</label>
                    <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" value="<?= user()->email ?>" required>
                    <div class="invalid-feedback">
                        <?= session('errors.username') ?>
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center justify-content-end">
                    <a href="<?= route_to('admin.index.profile') ?>" class="btn btn-outline-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>

<?= $this->section('head_css'); ?>
<style>
    .input-container {
        position: relative;
    }

    .avatar-label {
        padding: .25rem;
        border: 2px solid transparent;
        border-radius: 9999rem;
        transition: .2s ease-in-out;
        cursor: pointer;
    }

    .radio-input {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50% -50%);
        opacity: 0;
    }

    input[type="radio"]:checked+label.avatar-label {
        border-color: var(--bs-blue);
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<script>
    const imgPreview = document.querySelector('#imgPreview');
    const inputRadios = document.querySelectorAll('input[type="radio"');

    inputRadios.forEach(radio => {
        radio.addEventListener('click', () => {
            imgPreview.src = `/img/profile/${radio.value}`
        })
    });
</script>
<?= $this->endSection(); ?>