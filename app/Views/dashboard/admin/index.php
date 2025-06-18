<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="col-lg-8">
    <div class="card overflow-hidden">
        <div class="card-body pb-0">
            <div class="d-flex align-items-start">
                <div>
                    <h4 class="card-title">Status Terkini</h4>
                    <p class="card-subtitle">Tentang pesanan dari pengguna</p>
                </div>
            </div>
            <div class="mt-4 pb-3 d-flex align-items-center">
                <span class="btn btn-primary rounded-circle round-48 hstack justify-content-center">
                    <i class="ti ti-shopping-cart fs-6"></i>
                </span>
                <div class="ms-3">
                    <h5 class="mb-0 fw-bolder fs-4">Total Pendapatan</h5>
                    <span class="text-muted fs-3">Total rupiah pengguna</span>
                </div>
                <div class="ms-auto">
                    <span class="badge bg-secondary-subtle text-muted">+68%</span>
                </div>
            </div>
            <div class="py-3 d-flex align-items-center">
                <span class="btn btn-warning rounded-circle round-48 hstack justify-content-center">
                    <i class="ti ti-star fs-6"></i>
                </span>
                <div class="ms-3">
                    <h5 class="mb-0 fw-bolder fs-4">Best Seller</h5>
                    <span class="text-muted fs-3">MaterialPro Admin</span>
                </div>
                <div class="ms-auto">
                    <span class="badge bg-secondary-subtle text-muted">+68%</span>
                </div>
            </div>
            <div class="py-3 d-flex align-items-center">
                <span class="btn btn-success rounded-circle round-48 hstack justify-content-center">
                    <i class="ti ti-message-dots fs-6"></i>
                </span>
                <div class="ms-3">
                    <h5 class="mb-0 fw-bolder fs-4">Most Commented</h5>
                    <span class="text-muted fs-3">Ample Admin</span>
                </div>
                <div class="ms-auto">
                    <span class="badge bg-secondary-subtle text-muted">+68%</span>
                </div>
            </div>
            <div class="pt-3 mb-7 d-flex align-items-center">
                <span class="btn btn-secondary rounded-circle round-48 hstack justify-content-center">
                    <i class="ti ti-diamond fs-6"></i>
                </span>
                <div class="ms-3">
                    <h5 class="mb-0 fw-bolder fs-4">Top Budgets</h5>
                    <span class="text-muted fs-3">Sunil Joshi</span>
                </div>
                <div class="ms-auto">
                    <span class="badge bg-secondary-subtle text-muted">+15%</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="card pt-4">
        <img src="<?= base_url('img/profile/user-1.svg') ?>" alt="<?= user()->username ?>" style="width: 81%; margin: auto;">
        <div class="card-body">
            <div class="d-flex gap-2 justify-content-center align-items-center">
                <div>
                    <i class="ti ti-user-check"></i>
                    <span><?= user()->username ?></span>
                </div>
                <div>
                    <i class="ti ti-mail"></i>
                    <span><?= user()->email ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex align-items-center">
                <div>
                    <h4 class="card-title">Daftar Pesanan</h4>
                    <p class="card-subtitle">
                        Semua daftar pesanan dari pengguna
                    </p>
                </div>
            </div>
            <div class="table-responsive mt-4">
                <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                    <thead>
                        <tr>
                            <th scope="col" class="px-0 text-muted">
                                Pemesanan
                            </th>
                            <th scope="col" class="px-0 text-muted">Produk</th>
                            <th scope="col" class="px-0 text-muted">
                                Status
                            </th>
                            <th scope="col" class="px-0 text-muted text-end">
                                Harga
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-0">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('img/profile/user-2.svg') ?>" class="rounded-circle" width="40"
                                        alt="flexy" />
                                    <div class="ms-3">
                                        <h6 class="mb-0 fw-bolder">Sunil Joshi</h6>
                                        <span class="text-muted">Web Designer</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-0">Elite Admin</td>
                            <td class="px-0">
                                <span class="badge bg-info">Low</span>
                            </td>
                            <td class="px-0 text-dark fw-medium text-end">
                                $3.9K
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>