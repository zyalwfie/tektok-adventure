<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title">Kasir</h4>
                        <p class="card-subtitle">Buat pesanan untuk pembelian langsung di toko</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="ti ti-plus"></i> Tambah Produk
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="cartItems">
                            <tr id="emptyCart">
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Belum ada produk yang ditambahkan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Ringkasan Pesanan</h5>

                <div class="d-flex justify-content-between mb-3">
                    <span>Subtotal</span>
                    <span class="fw-bold">Rp<span id="subtotal">0</span></span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>Diskon</span>
                    <span class="fw-bold">Rp<span id="discount">0</span></span>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-4">
                    <h5>Total</h5>
                    <h5 class="fw-bold">Rp<span id="total">0</span></h5>
                </div>

                <form id="checkoutForm" action="<?= route_to('admin.cashier.checkout') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="cart_items" id="cartItemsInput">

                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="customer_name" name="recipient_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">No. Telepon</label>
                        <input type="tel" class="form-control" id="customer_phone" name="recipient_phone"
                            placeholder="08xxxxxxxxxx" pattern="^(\+62|62|0)8[1-9][0-9]{6,10}$">
                    </div>

                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="customer_email" name="recipient_email">
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="">Pilih metode pembayaran</option>
                            <option value="cash">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>

                    <div class="mb-3" id="cashPaymentSection" style="display: none;">
                        <label for="cash_amount" class="form-label">Jumlah Bayar</label>
                        <input type="number" class="form-control" id="cash_amount" name="cash_amount">
                        <div class="mt-2">
                            <small class="text-muted">Kembalian: Rp<span id="change">0</span></small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="checkoutBtn" disabled>
                        <i class="ti ti-shopping-cart-check"></i> Proses Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Pilih Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="searchProduct" placeholder="Cari produk...">
                </div>

                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="productList">
                            <?php foreach ($products as $product) : ?>
                                <tr class="product-row" data-name="<?= strtolower($product['product_name']) ?>">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('img/product/uploads/') . $product['image'] ?>"
                                                width="40" height="40" class="rounded me-2" style="object-fit: cover;">
                                            <span><?= $product['product_name'] ?></span>
                                        </div>
                                    </td>
                                    <td><?= $product['category_name'] ?></td>
                                    <td>Rp<?= number_format($product['price'], 0, ',', '.') ?></td>
                                    <td>
                                        <span class="badge <?= $product['stock'] > 10 ? 'bg-success' : ($product['stock'] > 0 ? 'bg-warning' : 'bg-danger') ?>">
                                            <?= $product['stock'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary add-to-cart-btn"
                                            data-id="<?= $product['productId'] ?>"
                                            data-name="<?= $product['product_name'] ?>"
                                            data-price="<?= $product['price'] ?>"
                                            data-stock="<?= $product['stock'] ?>"
                                            data-image="<?= $product['image'] ?>"
                                            data-discount="<?= $product['discount'] ?>"
                                            <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                                            <i class="ti ti-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <span id="toastMessage">Produk berhasil ditambahkan</span>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('foot_js'); ?>
<script>
    let cart = [];

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function updateCartDisplay() {
        const cartItemsEl = document.getElementById('cartItems');
        const subtotalEl = document.getElementById('subtotal');
        const discountEl = document.getElementById('discount');
        const totalEl = document.getElementById('total');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const cartItemsInput = document.getElementById('cartItemsInput');

        if (cart.length === 0) {
            cartItemsEl.innerHTML = `
            <tr id="emptyCart">
                <td colspan="5" class="text-center py-4 text-muted">
                    Belum ada produk yang ditambahkan
                </td>
            </tr>
        `;
            checkoutBtn.disabled = true;
        } else {
            let html = '';
            let subtotal = 0;
            let totalDiscount = 0;

            cart.forEach((item, index) => {
                const itemSubtotal = item.price * item.quantity;
                const itemDiscount = item.discount > 0 ? (item.discount / 100) * itemSubtotal : 0;
                const finalPrice = itemSubtotal - itemDiscount;

                subtotal += itemSubtotal;
                totalDiscount += itemDiscount;

                html += `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="${base_url}img/product/uploads/${item.image}" 
                                 width="40" height="40" class="rounded me-2" style="object-fit: cover;">
                            <div>
                                <div>${item.name}</div>
                                ${item.discount > 0 ? `<small class="text-danger">Diskon ${item.discount}%</small>` : ''}
                            </div>
                        </div>
                    </td>
                    <td>Rp${formatRupiah(item.price)}</td>
                    <td>
                        <div class="input-group input-group-sm" style="width: 120px;">
                            <button class="btn btn-outline-secondary" onclick="updateQuantity(${index}, ${item.quantity - 1})">
                                <i class="ti ti-minus"></i>
                            </button>
                            <input type="number" class="form-control text-center" value="${item.quantity}" 
                                   onchange="updateQuantity(${index}, this.value)" min="1" max="${item.stock}">
                            <button class="btn btn-outline-secondary" onclick="updateQuantity(${index}, ${item.quantity + 1})">
                                <i class="ti ti-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td>Rp${formatRupiah(finalPrice)}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="removeFromCart(${index})">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            });

            cartItemsEl.innerHTML = html;
            subtotalEl.textContent = formatRupiah(subtotal);
            discountEl.textContent = formatRupiah(totalDiscount);
            totalEl.textContent = formatRupiah(subtotal - totalDiscount);
            checkoutBtn.disabled = false;

            cartItemsInput.value = JSON.stringify(cart);
        }
    }

    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = parseInt(this.dataset.id);
            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                if (existingItem.quantity < parseInt(this.dataset.stock)) {
                    existingItem.quantity++;
                    showToast('Jumlah produk berhasil ditambah');
                } else {
                    showToast('Stok tidak mencukupi', 'error');
                    return;
                }
            } else {
                cart.push({
                    id: productId,
                    name: this.dataset.name,
                    price: parseInt(this.dataset.price),
                    stock: parseInt(this.dataset.stock),
                    image: this.dataset.image,
                    discount: parseInt(this.dataset.discount) || 0,
                    quantity: 1
                });
                showToast('Produk berhasil ditambahkan');
            }

            updateCartDisplay();
            bootstrap.Modal.getInstance(document.getElementById('addProductModal')).hide();
        });
    });

    function updateQuantity(index, newQuantity) {
        newQuantity = parseInt(newQuantity);
        if (newQuantity < 1) return;
        if (newQuantity > cart[index].stock) {
            showToast('Stok tidak mencukupi', 'error');
            return;
        }
        cart[index].quantity = newQuantity;
        updateCartDisplay();
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCartDisplay();
        showToast('Produk berhasil dihapus');
    }

    document.getElementById('searchProduct').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.product-row').forEach(row => {
            const productName = row.dataset.name;
            row.style.display = productName.includes(searchTerm) ? '' : 'none';
        });
    });

    document.getElementById('payment_method').addEventListener('change', function() {
        const cashSection = document.getElementById('cashPaymentSection');
        cashSection.style.display = this.value === 'cash' ? 'block' : 'none';
    });

    document.getElementById('cash_amount').addEventListener('input', function() {
        const total = parseInt(document.getElementById('total').textContent.replace(/\./g, ''));
        const cashAmount = parseInt(this.value) || 0;
        const change = cashAmount - total;
        document.getElementById('change').textContent = formatRupiah(Math.max(0, change));
    });

    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();

        if (cart.length === 0) {
            showToast('Keranjang masih kosong', 'error');
            return;
        }

        const paymentMethod = document.getElementById('payment_method').value;
        if (paymentMethod === 'cash') {
            const total = parseInt(document.getElementById('total').textContent.replace(/\./g, ''));
            const cashAmount = parseInt(document.getElementById('cash_amount').value) || 0;
            if (cashAmount < total) {
                showToast('Jumlah bayar kurang', 'error');
                return;
            }
        }

        // Add total price to form
        const totalInput = document.createElement('input');
        totalInput.type = 'hidden';
        totalInput.name = 'total_price';
        totalInput.value = document.getElementById('total').textContent.replace(/\./g, '');
        this.appendChild(totalInput);

        this.submit();
    });

    // Show toast notification
    function showToast(message, type = 'success') {
        const toast = document.getElementById('successToast');
        const toastEl = new bootstrap.Toast(toast);
        document.getElementById('toastMessage').textContent = message;

        if (type === 'error') {
            toast.querySelector('.toast-header').classList.remove('bg-success');
            toast.querySelector('.toast-header').classList.add('bg-danger');
        } else {
            toast.querySelector('.toast-header').classList.remove('bg-danger');
            toast.querySelector('.toast-header').classList.add('bg-success');
        }

        toastEl.show();
    }

    // Initialize
    const base_url = '<?= base_url() ?>';
    updateCartDisplay();
</script>
<?= $this->endSection(); ?>