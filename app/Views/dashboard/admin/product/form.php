<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">
            <?= isset($product) ? 'Ubah Produk' : 'Tambah Produk Baru' ?>
        </h5>
        <div class="card">
            <div class="card-body">
                <?= form_open_multipart(isset($product) ? url_to('admin.products.update', $product['id']) : url_to('admin.products.store')) ?>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>"
                        id="name" name="name" value="<?= old('name', $product['name'] ?? '') ?>" autocomplete="on">
                    <?php if (session('errors.name')): ?>
                        <div class="invalid-feedback"><?= session('errors.name') ?></div>
                    <?php endif; ?>
                </div>

                <div class="row row-cols-1 g-3 row-cols-md-3 mb-3">
                    <div class="col">
                        <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text <?= session('errors.price') ? 'is-invalid' : '' ?>" id="price">Rp</span>
                            <input id="price" type="number" class="form-control" aria-label="Price" aria-describedby="price" name="price" value="<?= old('price', $product['price'] ?? '') ?>">
                            <?php if (session('errors.price')): ?>
                                <div class="invalid-feedback"><?= session('errors.price') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control <?= session('errors.stock') ? 'is-invalid' : '' ?>"
                            id="stock" name="stock" value="<?= old('stock', $product['stock'] ?? '') ?>">
                        <?php if (session('errors.stock')): ?>
                            <div class="invalid-feedback"><?= session('errors.stock') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <label for="discount" class="form-label">Diskon</label>
                        <div class="input-group">
                            <input type="number" class="form-control <?= session('errors.discount') ? 'is-invalid' : '' ?>"
                                id="discount" name="discount" value="<?= old('discount', $product['discount'] ?? '') ?>">
                            <?php if (session('errors.discount')): ?>
                                <div class="invalid-feedback"><?= session('errors.discount') ?></div>
                            <?php endif; ?>
                            <span class="input-group-text <?= session('errors.price') ? 'is-invalid' : '' ?>" id="price">%</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="image" class="form-label">Gambar</label>
                        <input class="form-control <?= session()->has('error_image') ? 'is-invalid' : '' ?>" type="file" accept="image/png, image/jpeg, image/jpg" id="image" name="image" <?= !isset($product) ? '' : '' ?>>
                        <?php if (session()->has('error_image')): ?>
                            <div class="invalid-feedback"><?= session('error_image') ?></div>
                        <?php endif; ?>
                        <small class="text-muted">Maksimal ukuran 2MB (png, jpg, jpeg)</small>
                        <?php if (isset($product['image'])): ?>
                            <div class="mt-2">
                                <img src="<?= base_url() ?>img/product/uploads/<?= $product['image'] ?>" alt="Main Image" style="height: 150px; width: 150px; object-fit: cover;" class="img-thumbnail">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select name="category_id" class="form-select <?= session()->has('error_category') ? 'is-invalid' : '' ?>" aria-label="Select Category">
                            <option selected>Pilih kategori</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category['id'] ?>" <?= $category['id'] === $product['category_id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('error_category') ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="is_featured" name="is_featured" <?= $product['is_featured'] === '1' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_featured">
                            Rekomendasi
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <div id="editor" style="height: 200px;"><?= old('description', $product['description'] ?? '') ?></div>
                    <input type="hidden" id="description" name="description">
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?= base_url(route_to('admin.products.index')) ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary"><?= isset($product) ? 'Perbarui' : 'Tambah' ?></button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'align': []
                }],
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }],
            ]
        },
        placeholder: 'Tulis deskripsi produk...',
    });

    function htmlToPlainText(html) {
        const div = document.createElement("div");
        div.innerHTML = html;
        return div.textContent || div.innerText || "";
    }

    const rawHtml = `<?= old('description', $product['description'] ?? '') ?>`;

    if (rawHtml) {
        const plain = htmlToPlainText(rawHtml);
        quill.setText(plain);
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const descriptionInput = document.getElementById('description');
        descriptionInput.value = quill.root.innerHTML;
    });
</script>
<?= $this->endSection(); ?>