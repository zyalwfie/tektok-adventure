<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="col-12">
    <div class="card">
        <?php
        $search = $_GET['q'] ?? '';
        $filteredProducts = $products;
        if ($search) {
            $filteredProducts = array_filter($products, function ($product) use ($search) {
                return stripos($product['product_name'], $search) !== false;
            });
        }

        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 5;
        $total = count($filteredProducts);
        $totalPages = (int) ceil($total / $perPage);
        $start = ($page - 1) * $perPage;
        $paginatedProducts = array_slice($filteredProducts, $start, $perPage);
        $index = $start + 1;
        ?>
        <div class="card-body">
            <div class="d-md-flex align-items-center justify-content-between">
                <div>
                    <h4 class="card-title">Daftar Produk</h4>
                    <p class="card-subtitle">
                        Semua daftar produk yang bisa dikelola
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <form method="get" class="position-relative">
                        <input class="form-control me-1" type="text" name="q" placeholder="Cari produk" aria-label="Search" value="<?= isset($_GET['q']) ? esc($_GET['q']) : '' ?>" />
                        <button class="search-button position-absolute" type="submit">
                            <i class="ti ti-search"></i>
                        </button>
                    </form>
                    <a href="<?= route_to('admin.products.create') ?>" class="btn btn-secondary">Tambah Produk</a>
                </div>
            </div>
            <div class="table-responsive m-4">
                <table class="table mb-4 text-nowrap varient-table align-middle fs-3">
                    <thead>
                        <tr>
                            <th scope="col" class="px-0 text-muted">
                                Produk
                            </th>
                            <th scope="col" class="px-0 text-muted">
                                Harga
                            </th>
                            <th scope="col" class="px-0 text-muted">
                                Stok
                            </th>
                            <th scope="col" class="px-0 text-muted text-end">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$paginatedProducts) : ?>
                            <tr>
                                <th colspan="4" class="text-center">
                                    Produk tidak ditemukan.
                                </th>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($paginatedProducts as $product) : ?>
                                <tr>
                                    <td class="px-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="<?= base_url('img/product/uploads/') . $product['image'] ?>" style="width: 50px; height: 50px; object-fit: cover;"
                                                alt="<?= $product['product_name'] ?>" />
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-bolder"><?= $product['product_name'] ?></h6>
                                                <span class="text-muted"><?= $product['category_name'] ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-0">Rp<?= number_format($product['price'], '0', ',', '.') ?></td>
                                    <td class="px-0">
                                        <?php
                                        $stock = $product['stock'];
                                        $badgeClass = 'text-info';
                                        if ($stock <= 5) {
                                            $badgeClass = 'text-danger';
                                        } elseif ($stock <= 10) {
                                            $badgeClass = 'text-warning';
                                        }
                                        ?>
                                        <span class="fw-bold <?= $badgeClass ?>">
                                            <?= $stock ?>
                                        </span>
                                    </td>
                                    <td class="px-0 text-dark fw-medium text-end">
                                        <button
                                            id="btn-detail-modal"
                                            type="button"
                                            class="badge bg-info btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal"
                                            data-category_name="<?= $product['category_name'] ?>"
                                            data-is_featured="<?= $product['is_featured'] ?>"
                                            data-image="<?= base_url('img/product/uploads/' . $product['image']) ?>"
                                            data-name="<?= esc($product['product_name']) ?>"
                                            data-description="<?= esc($product['product_description']) ?>"
                                            data-discount="<?= esc($product['discount']) ?>"
                                            data-price="<?= esc($product['price']) ?>"
                                            data-stock="<?= esc($product['stock']) ?>">
                                            Lihat
                                        </button>
                                        <a class="badge bg-warning" href="<?= route_to('admin.products.edit', $product['product_slug']) ?>">Ubah</a>
                                        <button id="deleteButton" type="button" class="badge bg-danger btn" data-bs-toggle="modal" data-bs-target="#confirmModal" data-product_slug="<?= $product['product_slug'] ?>">Hapus</button>
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
                <h1 class="modal-title fs-5" id="detailModalLabel">Detail Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="previewImg" src="<?= base_url('img/product/uploads/default.svg') ?>" alt="Image" class="w-100 img-thumbnail mb-3">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input class="form-control" id="name" type="text" disabled>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="stock" class="form-label">Stok</label>
                        <input class="form-control" id="stock" type="number" disabled>
                    </div>
                    <div class="col">
                        <label for="price" class="form-label">Harga Produk</label>
                        <input class="form-control" id="price" type="text" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="price_discount" class="form-label">Harga Diskon</label>
                        <input type="text" class="form-control" id="discount_price" disabled>
                    </div>
                    <div class="col">
                        <label for="discount" class="form-label">Diskon</label>
                        <input class="form-control" id="discount" type="text" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <input class="form-check-input me-2" id="is_featured" type="radio" disabled>
                        <label for="is_featured" class="form-label">Rekomendasi</label>
                    </div>
                    <div class="col">
                        <label for="category_name" class="form-label">Kategori</label>
                        <input class="form-control" id="category_name" type="text" disabled>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="desciption" class="form-label">Deskripsi</label>
                    <textarea rows="4" class="form-control" id="description" disabled></textarea>
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
                <h1 class="modal-title fs-5" id="confirmModalLabel">Yakin ingin menghapus produk ini?</h1>
            </div>
            <div class="modal-body">
                Tindakan ini akan menghapus produk dari sistem secara permanen dan tidak dapat dibatalkan.
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
            .replace(/\s+/g, '');;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const detailModal = document.getElementById('detailModal');
        const productName = detailModal.querySelector('#name');
        const discount = detailModal.querySelector('#discount');
        const price = detailModal.querySelector('#price');
        const priceAfterDiscount = detailModal.querySelector('#discount_price')
        const stock = detailModal.querySelector('#stock');
        const image = detailModal.querySelector('#previewImg');
        const category = detailModal.querySelector('#category_name')
        const description = detailModal.querySelector('#description');
        const isFeatured = detailModal.querySelector('#is_featured');

        document.querySelectorAll('#btn-detail-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                productName.value = this.dataset.name;
                discount.value = `${this.dataset.discount}%`;

                const formattedPrice = formatRupiah(this.dataset.price)
                price.value = formattedPrice;

                const discountAmount = this.dataset.price * (this.dataset.discount / 100);
                const discountPrice = this.dataset.price - discountAmount

                const formattedDiscountPrice = formatRupiah(discountPrice);
                priceAfterDiscount.value = formattedDiscountPrice;

                stock.value = this.dataset.stock;
                image.src = this.dataset.image;
                category.value = this.dataset.category_name;
                description.value = this.dataset.description;

                if (this.dataset.is_featured == '1') {
                    isFeatured.checked = true;
                } else {
                    isFeatured.checked = false;
                }
            });
        });

        document.querySelectorAll('#deleteButton').forEach(function(deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                const productSlug = this.dataset.product_slug;
                const formModal = document.querySelector('#formModal');
                formModal.onsubmit = function(e) {
                    e.preventDefault();
                    formModal.action = `<?= base_url() ?>dashboard/admin/products/destroy/${productSlug}${window.location.search}`;
                    formModal.submit();
                };
            });
        });
    })
</script>
<?= $this->endSection(); ?>