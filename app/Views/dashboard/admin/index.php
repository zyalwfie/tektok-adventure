<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row">
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
                        <i class="ti ti-moneybag"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bolder fs-4">Total Pendapatan</h5>
                        <span class="text-muted fs-3">Total rupiah pengguna</span>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-info-subtle text-muted">Rp<?= number_format($totalEarning, '0', ',', '.') ?></span>
                    </div>
                </div>
                <div class="py-3 d-flex align-items-center">
                    <span class="btn btn-warning rounded-circle round-48 hstack justify-content-center">
                        <i class="ti ti-clock-hour-12"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bolder fs-4">Total Pesanan yang Tertunda</h5>
                        <span class="text-muted fs-3">Status pesanan yang masih tertunda</span>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-warning-subtle text-muted"><?= $pendingOrdersCount ?></span>
                    </div>
                </div>
                <div class="py-3 d-flex align-items-center">
                    <span class="btn btn-success rounded-circle round-48 hstack justify-content-center">
                        <i class="ti ti-checks fs-6"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bolder fs-4">Total Pesanan yang Berhasil</h5>
                        <span class="text-muted fs-3">Status pesanan yang sudah berhasil</span>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-success-subtle text-muted"><?= $completedOrdersCount ?></span>
                    </div>
                </div>
                <div class="pt-3 mb-7 d-flex align-items-center">
                    <span class="btn btn-secondary rounded-circle round-48 hstack justify-content-center">
                        <i class="ti ti-users fs-6"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bolder fs-4">Jumlah Pengguna</h5>
                        <span class="text-muted fs-3">Pengguna yang sudah daftar di Tektok Adventure</span>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-info-subtle text-muted"><?= $usersAmount ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card pt-4">
            <img src="<?= base_url('img/profile/' . user()->avatar) ?>" alt="<?= user()->username ?>" style="width: 81%; margin: auto;">
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
                                    Pemesan
                                </th>
                                <th scope="col" class="px-0 text-muted">
                                    Status
                                </th>
                                <th scope="col" class="px-0 text-muted text-end">
                                    Total Pembayaran
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$orders) : ?>
                                <tr>
                                    <td colspan="4">Belum ada pesanan yang dibuat</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($orders as $order) : ?>
                                    <tr>
                                        <td class="px-0">
                                            <div class="d-flex align-items-center">
                                                <img src="<?= base_url('img/profile/') . $order->avatar ?>" class="rounded-circle" width="40"
                                                    alt="flexy" />
                                                <div class="ms-3">
                                                    <h6 class="mb-0 fw-bolder"><?= $order->recipient_name ?></h6>
                                                    <span class="text-muted"><?= $order->recipient_phone ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-0">
                                            <span
                                                <?php if ($order->order_status === 'berhasil') : ?>
                                                class="badge bg-success"
                                                <?php elseif ($order->order_status === 'tertunda') : ?>
                                                class="badge bg-warning"
                                                <?php else : ?>
                                                class="badge bg-danger"
                                                <?php endif; ?>><?= $order->order_status ?></span>
                                        </td>
                                        <td class="px-0 text-dark fw-medium text-end">
                                            Rp<?= number_format($order->total_price, '0', '.', ',') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>