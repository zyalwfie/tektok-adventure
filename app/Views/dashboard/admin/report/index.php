<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center justify-content-between mb-5">
                    <div>
                        <h4 class="card-title">Laporan Penjualan</h4>
                        <p class="card-subtitle">
                            Laporan detail penjualan yang bisa diurutkan berdasarkan rentang waktu
                        </p>
                    </div>
                </div>

                <?php
                $startDate = $_GET['start_date'] ?? null;
                $endDate = $_GET['end_date'] ?? null;

                $filteredOrders = array_filter($orders, function ($order) use ($startDate, $endDate) {
                    $orderDate = strtotime($order['created_at']);

                    if (!$startDate && !$endDate) return true;

                    if ($startDate && !$endDate) {
                        return $orderDate >= strtotime($startDate);
                    }

                    if (!$startDate && $endDate) {
                        return $orderDate <= strtotime($endDate);
                    }

                    return $orderDate >= strtotime($startDate) && $orderDate <= strtotime($endDate);
                });

                $totalSales = array_reduce($filteredOrders, function ($carry, $order) {
                    return $carry + $order['total_price'];
                }, 0);

                $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
                $perPage = 10;
                $total = count($filteredOrders);
                $totalPages = (int) ceil($total / $perPage);
                $start = ($page - 1) * $perPage;
                $paginatedOrders = array_slice($filteredOrders, $start, $perPage);
                ?>

                <div class="row g-3 align-items-center">
                    <form method="get" class="mb-4 row">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= htmlspecialchars($startDate ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= htmlspecialchars($endDate ?? '') ?>">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Urutkan</button>
                            <a href="<?= route_to('admin.reports.index') ?>" class="btn btn-outline-secondary me-2">Bersihkan</a>
                            <?php if ($filteredOrders) : ?>
                                <a href="<?= route_to('admin.reports.preview') . '?' . http_build_query([
                                                'start_date' => $startDate,
                                                'end_date' => $endDate
                                            ]) ?>" class="btn btn-success">
                                    <i class="ti ti-file-text"></i> Pratinjau
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <!-- Total Sales Summary -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Total Penjualan</h5>
                                    <p class="card-text fs-3 fw-bold text-success">
                                        Rp<?= number_format($totalSales, 0, '.', ',') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Report Table -->
                    <div class="table-responsive">
                        <table class="table mb-4 text-nowrap varient-table align-middle fs-3">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-0 text-muted">Tanggal</th>
                                    <th scope="col" class="px-0 text-muted">Nama Penerima</th>
                                    <th scope="col" class="px-0 text-muted">Total Harga</th>
                                    <th scope="col" class="px-0 text-muted">Status</th>
                                    <th scope="col" class="px-0 text-muted text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!$paginatedOrders) : ?>
                                    <tr>
                                        <th colspan="5" class="text-center">
                                            Tidak ada laporan penjualan ditemukan.
                                        </th>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($paginatedOrders as $order) : ?>
                                        <tr>
                                            <td class="px-0">
                                                <?= date('d M Y', strtotime($order['created_at'])) ?>
                                            </td>
                                            <td class="px-0">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h6 class="mb-0 fw-bolder"><?= $order['recipient_name'] ?></h6>
                                                        <span class="text-muted"><?= $order['recipient_email'] ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-0">Rp<?= number_format($order['total_price'], '0', '.', ',') ?></td>
                                            <td class="px-0">
                                                <span class="badge <?php
                                                                    if ($order['status'] === 'tertunda') : ?>text-bg-warning 
                                                <?php elseif ($order['status'] === 'berhasil') : ?>text-bg-success 
                                                <?php else: ?>text-bg-danger
                                                <?php endif; ?> text-capitalize"><?= $order['status'] ?></span>
                                            </td>
                                            <td class="px-0 text-dark fw-medium text-end">
                                                <a href="<?= route_to('admin.orders.show', $order['id']) ?>" class="text-info">Lihat</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>"><i class="ti ti-chevron-left"></i></a>
                                </li>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>"><i class="ti ti-chevron-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->endSection(); ?>

    <?= $this->section('foot_js'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            if (startDateInput && endDateInput) {
                startDateInput.addEventListener('change', function() {
                    endDateInput.min = this.value;
                });

                endDateInput.addEventListener('change', function() {
                    startDateInput.max = this.value;
                });
            }
        });
    </script>
    <?= $this->endSection(); ?>