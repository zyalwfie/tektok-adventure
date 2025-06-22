<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title">Preview Laporan Penjualan</h4>
                        <p class="card-subtitle">
                            Pratinjau laporan penjualan sebelum diekspor
                        </p>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php if ($startDate && $endDate): ?>
                            <span class="badge bg-info me-2">
                                Periode: <?= date('d M Y', strtotime($startDate)) ?> -
                                <?= date('d M Y', strtotime($endDate)) ?>
                            </span>
                        <?php elseif ($startDate): ?>
                            <span class="badge bg-info me-2">
                                Mulai dari: <?= date('d M Y', strtotime($startDate)) ?>
                            </span>
                        <?php elseif ($endDate): ?>
                            <span class="badge bg-info me-2">
                                Sampai dengan: <?= date('d M Y', strtotime($endDate)) ?>
                            </span>
                        <?php else: ?>
                            <span class="badge bg-info me-2">Semua Periode</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Total Sales Summary -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Penjualan</h5>
                                        <p class="card-text fs-3 fw-bold text-success">
                                            Rp<?= number_format($totalSales, 0, ',', '.') ?>
                                        </p>
                                    </div>
                                    <div>
                                        <form action="<?= route_to('admin.reports.export') ?>" method="get">
                                            <?php if ($startDate): ?>
                                                <input type="hidden" name="start_date" value="<?= $startDate ?>">
                                            <?php endif; ?>
                                            <?php if ($endDate): ?>
                                                <input type="hidden" name="end_date" value="<?= $endDate ?>">
                                            <?php endif; ?>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ti ti-file-text me-1"></i> Ekspor PDF
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Report Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Penerima</th>
                                <th>Email</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Tidak ada data penjualan yang ditemukan.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $index => $order): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                                        <td><?= htmlspecialchars($order['recipient_name']) ?></td>
                                        <td><?= htmlspecialchars($order['recipient_email']) ?></td>
                                        <td>Rp<?= number_format($order['total_price'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge <?php
                                                                if ($order['status'] === 'tertunda') : ?>text-bg-warning 
                                                <?php elseif ($order['status'] === 'berhasil') : ?>text-bg-success 
                                                <?php else: ?>text-bg-danger
                                                <?php endif; ?> text-capitalize">
                                                <?= $order['status'] ?>
                                            </span>
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
<?= $this->endSection(); ?><?= $this->extend('layouts/dashboard/app'); ?>