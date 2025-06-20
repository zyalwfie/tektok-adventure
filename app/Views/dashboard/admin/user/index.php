<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="col-12">
    <div class="card">
        <?php
        $search = $_GET['q'] ?? '';
        $filterUsers = $users;
        if ($search) {
            $filterUsers = array_filter($users, function ($user) use ($search) {
                return stripos($user['full_name'], $search) !== false;
            });
        }

        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 5;
        $total = count($filterUsers);
        $totalPages = (int) ceil($total / $perPage);
        $start = ($page - 1) * $perPage;
        $paginatedUsers = array_slice($filterUsers, $start, $perPage);
        $index = $start + 1;
        ?>
        <div class="card-body">
            <div class="d-md-flex align-items-center justify-content-between">
                <div>
                    <h4 class="card-title">Daftar Pengguna</h4>
                    <p class="card-subtitle">
                        Semua daftar pengguna yang sudah daftar di Tektok Adventure
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <form method="get" class="position-relative">
                        <input class="form-control me-1" type="text" name="q" placeholder="Cari pengguna" aria-label="Search" value="<?= isset($_GET['q']) ? esc($_GET['q']) : '' ?>" />
                        <button class="search-button position-absolute" type="submit">
                            <i class="ti ti-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="table-responsive m-4">
                <table class="table mb-4 text-nowrap varient-table align-middle fs-3">
                    <thead>
                        <tr>
                            <th scope="col" class="px-0 text-muted">
                                Nama Lengkap
                            </th>
                            <th scope="col" class="px-0 text-muted text-end">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$paginatedUsers) : ?>
                            <tr>
                                <th colspan="4" class="text-center">
                                    Pengguna tidak ditemukan.
                                </th>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($paginatedUsers as $user) : ?>
                                <tr>
                                    <td class="px-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="<?= base_url('img/profile/') . $user['avatar'] ?>" style="width: 50px; height: 50px; object-fit: cover;"
                                                alt="<?= $user['username'] ?>" />
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-bolder"><?= $user['full_name'] ?? $user['username'] ?></h6>
                                                <span class="text-muted"><?= $user['email'] ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-0 text-dark fw-medium text-end">
                                        <button
                                            id="btn-detail-modal"
                                            type="button"
                                            class="badge bg-info btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal"
                                            data-avatar="<?= base_url('img/profile/' . $user['avatar']) ?>"
                                            data-full_name="<?= $user['full_name'] ? $user['full_name'] : 'Belum ada nama lengkap' ?>"
                                            data-username="<?= esc($user['username']) ?>"
                                            data-email="<?= esc($user['email']) ?>">
                                            Lihat
                                        </button>
                                        <button id="deleteButton" type="button" class="badge bg-danger btn" data-bs-toggle="modal" data-bs-target="#confirmModal" data-username="<?= $user['username'] ?>">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <?php if (session()->has('success')) : ?>
                            <div class="alert alert-success alert-dismissible fade show px-3 py-1" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-fw fa-check me-2"></i>
                                    <div class="flex-grow-1">
                                        <?= session('success') ?>
                                    </div>
                                    <button type="button" class="btn text-success" data-bs-dismiss="alert" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: currentColor;">
                                            <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <?php elseif (session()->has('failed')) : ?>
                            <div class="alert alert-warning alert-dismissible fade show px-3 py-1" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-fw fa-times me-2"></i>
                                    <div class="flex-grow-1">
                                        <?= session('failed') ?>
                                    </div>
                                    <button type="button" class="btn text-warning" data-bs-dismiss="alert" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: currentColor;">
                                            <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </tfoot>
                </table>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
                            <a class="page-link" href="?q=<?= urlencode($search) ?>&page=<?= $page - 1 ?>"><i class="ti ti-chevron-left"></i></a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                                <a class="page-link" href="?q=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
                            <a class="page-link" href="?q=<?= urlencode($search) ?>&page=<?= $page + 1 ?>"><i class="ti ti-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Detail modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailModalLabel">Detail Pengguna</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="avatar" alt="Avatar Pengguna" class="w-100 mb-3">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input class="form-control" id="name" type="text" disabled>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Nama Pengguna</label>
                    <input class="form-control" id="username" type="text" disabled>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Surel</label>
                    <input class="form-control" id="email" type="text" disabled>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirm modal -->
<div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="confirmModalLabel">Yakin ingin menghapus pengguna ini?</h1>
            </div>
            <div class="modal-body">
                Tindakan ini akan menghapus pengguna dari sistem secara permanen dan tidak dapat dibatalkan.
                Pastikan Anda benar-benar yakin sebelum melanjutkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="formModal" method="post">
                    <button type="submit" class="btn btn-danger">Ya, hapus sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('head_css'); ?>
<style>
    button[type=submit]:hover {
        color: white;
    }

    .badge.bg-info:hover {
        color: white;
    }

    .badge.bg-warning:hover {
        color: white;
    }

    .badge.bg-danger:hover {
        color: white;
    }

    .search-button {
        border: none;
        background-color: transparent;
        color: var(--bs-blue);
        right: .75rem;
        top: 50%;
        transform: translateY(-50%);
        transition: .3s ease-in-out;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<script>
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            })
            .format(number)
            .replace(/\s+/g, '');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const detailModal = document.getElementById('detailModal');
        const fullName = detailModal.querySelector('#name');
        const username = detailModal.querySelector('#username');
        const email = detailModal.querySelector('#email');
        const avatar = detailModal.querySelector('#avatar');

        document.querySelectorAll('#btn-detail-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                fullName.value = this.dataset.full_name;
                username.value = this.dataset.username;
                email.value = this.dataset.email;
                avatar.src = this.dataset.avatar;
            });
        });
    })

    document.querySelectorAll('#deleteButton').forEach(function(deleteBtn) {
        deleteBtn.addEventListener('click', function() {
            const username = this.dataset.username;
            const formModal = document.querySelector('#formModal');
            formModal.onsubmit = function(e) {
                e.preventDefault();
                formModal.action = `<?= base_url() ?>dashboard/admin/users/destroy/${username}${window.location.search}`;
                formModal.submit();
            };
        });
    });
</script>
<?= $this->endSection(); ?>