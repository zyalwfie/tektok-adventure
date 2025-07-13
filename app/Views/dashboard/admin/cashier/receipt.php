<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>
                <?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="mb-2">TEKTOK ADVENTURE</h3>
                    <p class="text-muted mb-1">Pringgabaya, Lombok Timur</p>
                    <p class="text-muted">Telp: +62 851-3903-8087</p>
                </div>

                <hr class="my-3">

                <div class="d-flex justify-content-between mb-2">
                    <span>No. Order:</span>
                    <strong>#<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Tanggal:</span>
                    <span><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Kasir:</span>
                    <span><?= user()->username ?></span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Pelanggan:</span>
                    <span><?= $order['recipient_name'] ?></span>
                </div>

                <?php if ($order['recipient_phone']) : ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span>No. Telp:</span>
                        <span><?= $order['recipient_phone'] ?></span>
                    </div>
                <?php endif; ?>

                <hr class="my-3">

                <table class="table table-sm">
                    <tbody>
                        <?php
                        $subtotal = 0;
                        $totalDiscount = 0;
                        foreach ($orderItems as $item) :
                            $itemTotal = $item->price * $item->quantity;
                            $discount = $item->discount > 0 ? ($item->discount / 100) * $itemTotal : 0;
                            $finalPrice = $itemTotal - $discount;
                            $subtotal += $itemTotal;
                            $totalDiscount += $discount;
                        ?>
                            <tr>
                                <td colspan="2" class="fw-bold border-0"><?= $item->name ?></td>
                            </tr>
                            <tr>
                                <td class="border-0 ps-3"><?= $item->quantity ?> x Rp<?= number_format($item->price, 0, ',', '.') ?></td>
                                <td class="text-end border-0">Rp<?= number_format($itemTotal, 0, ',', '.') ?></td>
                            </tr>
                            <?php if ($discount > 0) : ?>
                                <tr>
                                    <td class="border-0 ps-3 text-danger">Diskon <?= $item->discount ?>%</td>
                                    <td class="text-end border-0 text-danger">-Rp<?= number_format($discount, 0, ',', '.') ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <hr class="my-3">

                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>Rp<?= number_format($subtotal, 0, ',', '.') ?></span>
                </div>

                <?php if ($totalDiscount > 0) : ?>
                    <div class="d-flex justify-content-between mb-2 text-danger">
                        <span>Total Diskon:</span>
                        <span>-Rp<?= number_format($totalDiscount, 0, ',', '.') ?></span>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between mb-3">
                    <h5>TOTAL:</h5>
                    <h5 class="text-primary">Rp<?= number_format($order['total_price'], 0, ',', '.') ?></h5>
                </div>

                <hr class="my-3">

                <div class="text-center">
                    <p class="text-muted mb-1">Terima kasih atas kunjungan Anda</p>
                    <p class="text-muted small">Barang yang sudah dibeli tidak dapat dikembalikan</p>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="<?= route_to('admin.cashier.index') ?>" class="btn btn-secondary flex-fill">
                        <i class="ti ti-arrow-left me-2"></i>Transaksi Baru
                    </a>
                    <a href="<?= route_to('admin.cashier.receipt.pdf', $order['id']) ?>" target="_blank" class="btn btn-primary flex-fill">
                        <i class="ti ti-printer me-2"></i>Cetak Struk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>