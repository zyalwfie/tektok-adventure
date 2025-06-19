<?= $this->extend('layouts/landing/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle; ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<section id="hero" class="hero section">

    <img src="<?= base_url() ?>img/hero-bg-shop.jpg" alt="Snow Camping" data-aos="fade-in" style="filter: brightness(0.8);">

    <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 style="text-shadow: 1px 1px 2px #000000;" class="text-white display-4">Gear Kami Siap Menemanimu</h2>
                <p style="text-shadow: 1px 1px 2px #000000;" class="text-white">Temukan semua kebutuhan camping berkualitas di satu tempat</p>
                <a href="<?= base_url() ?>" class="btn-get-started">Beranda</a>
            </div>
        </div>
    </div>
</section>

<section id="products" class="products section">
    <!-- Section Title -->
    <div class="container d-flex justify-content-between align-items-center mb-5" data-aos="fade-up">
        <div class="section-title pb-0 text-start">
            <h2>Produk Kami</h2>
            <p>Temukan Perlengkapan Camping Terbaik untuk Setiap Petualangan</p>
        </div>
        <?php
        $search = $_GET['q'] ?? '';
        $category = $_GET['category'] ?? '';
        $filteredProducts = $products;
        if ($search) {
            $filteredProducts = array_filter($products, function ($product) use ($search) {
                return stripos($product['name'], $search) !== false;
            });
        }
        if ($category) {
            $filteredProducts = array_filter($filteredProducts, function ($product) use ($category) {
                return $product['category_id'] == $category;
            });
        }

        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 8;
        $total = count($filteredProducts);
        $totalPages = (int) ceil($total / $perPage);
        $start = ($page - 1) * $perPage;
        $paginatedProducts = array_slice($filteredProducts, $start, $perPage);
        $index = $start + 1;
        ?>
        <form method="get" class="d-flex align-items-center justify-content-end gap-3" id="formEl">
            <select class="form-select" name="category" id="selectEl" aria-label="Default select example">
                <option value="">Pilih kategori</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category['id'] ?>" <?= (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'selected' : '' ?>>
                        <?= $category['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="d-flex gap-1 w-100 position-relative">
                <input class="form-control me-1" type="text" name="q" placeholder="Search" aria-label="Search" value="<?= isset($_GET['q']) ? esc($_GET['q']) : '' ?>" />
                <button class="search-button position-absolute" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <a href="<?= current_url() ?>" class="btn btn-outline-secondary">
                <i class="bi bi-x"></i>
            </a>
        </form>
    </div>
    <!-- End Section Title -->

    <div class="container">
        <div class="row g-4 justify-content-start mb-4" data-aos="fade-up" data-aos-delay="100">
            <?php if (!$paginatedProducts) : ?>
                <h3 class="display-4 text-center">Produk tidak ditemukan!</h3>
            <?php else : ?>
                <?php foreach ($paginatedProducts as $product) : ?>
                    <div class="product-item col-6 col-md-3">
                        <div class="card h-100">
                            <?php if ($product['discount']) : ?>
                                <!-- Sale badge-->
                                <div
                                    class="badge position-absolute"
                                    style="top: 0.5rem; right: 0.5rem">
                                    Promo
                                </div>
                            <?php endif; ?>
                            <!-- Product image-->
                            <img
                                class="card-img-top"
                                src="<?= base_url('img/product/uploads/') . $product['image'] ?>"
                                alt="<?= $product['name'] ?>" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?= $product['name'] ?></h5>
                                    <?php if ($product['discount']) : ?>
                                        <!-- Product real price -->
                                        <small class="text-decoration-line-through me-1">Rp<?= number_format($product['price'], '0', '.', ',') ?></small>
                                        <!-- Product discount price -->
                                        <?php $discountAmount = $product['price'] * ($product['discount'] / 100) ?>
                                        <?php $discountPrice = $product['price'] - $discountAmount ?>
                                        <span>Rp<?= number_format($discountPrice, '0', '.', ',') ?></span>
                                    <?php else : ?>
                                        <!-- Product price -->
                                        <span>Rp<?= number_format($product['price'], '0', '.', ',') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div
                                class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="d-flex flex-column flex-md-row gap-2 align-items-center justify-content-center">
                                    <a
                                        class="btn cart-btn mt-auto"
                                        href="<?= route_to('landing.shop.show', $product['slug']) ?>">
                                        Lihat detail
                                    </a>
                                    <?php if (logged_in()) : ?>
                                        <?= form_open(route_to('landing.shop.add')) ?>
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn cart-btn">
                                            <i class="bi bi-cart-plus-fill"></i>
                                        </button>
                                        <?= form_close() ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
                    <a class="page-link" href="?q=<?= urlencode($search) ?>&page=<?= $page - 1 ?>"><i class="bi bi-chevron-left"></i></a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                        <a class="page-link" href="?q=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
                    <a class="page-link" href="?q=<?= urlencode($search) ?>&page=<?= $page + 1 ?>"><i class="bi bi-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('head_css'); ?>
<style>
    .form-select:focus-visible {
        box-shadow: 0 0 0 0.25rem rgba(253, 104, 14, .25);
        border-color: var(--accent-color);
    }

    input[type=text]:focus-visible {
        box-shadow: 0 0 0 0.25rem rgba(253, 104, 14, .25);
        border-color: var(--accent-color);
    }

    input[type=text] {
        padding-right: 2.5rem;
    }

    .product-item .card {
        transition: .3s ease-in-out;
    }

    .product-item .card:hover {
        border-color: var(--accent-color);
    }

    .product-item .cart-btn {
        border: 1px solid var(--accent-color);
        transition: ease-in-out .3s;
        color: var(--accent-color);
    }

    .product-item .cart-btn:hover {
        color: var(--contrast-color) !important;
        background-color: var(--accent-color) !important;
    }

    .product-item .badge {
        background-color: var(--accent-color);
        color: var(--contrast-color);
    }

    .search-button {
        border: none;
        background-color: transparent;
        color: var(--accent-color);
        right: .75rem;
        top: 50%;
        transform: translateY(-50%);
        transition: .3s ease-in-out;
    }

    .product-item .badge {
        background-color: var(--accent-color);
        color: var(--contrast-color);
    }

    .pagination .page-link {
        color: var(--accent-color);
        background-color: transparent;
        border: 1px solid var(--accent-color);
    }

    .pagination .page-link:hover {
        color: var(--contrast-color);
        background-color: var(--accent-color);
    }

    .pagination .page-link.active,
    .active>.page-link {
        color: var(--contrast-color);
        background-color: var(--accent-color);
    }

    .pagination .page-link.disabled,
    .disabled>.page-link {
        color: var(--contrast-color);
        background-color: var(--default-color);
        border-color: var(--default-color);
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#formEl');
        const categorySelect = form.querySelector('#selectEl');
        if (categorySelect) {
            categorySelect.addEventListener('change', function() {
                form.submit();
            });
        }
    });
</script>
<?= $this->endSection(); ?>