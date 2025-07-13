<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;
use Myth\Auth\Models\UserModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Myth\Auth\Password;

class Admin extends BaseController
{
    protected $userModel, $productModel, $orderModel, $categoryModel, $orderItemModel, $paymentModel, $productBuilder, $orderBuilder, $orderItemBuilder, $userBuilder, $authGroupUserBuilder, $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->productBuilder = $this->db->table('products');
        $this->orderBuilder = $this->db->table('orders');
        $this->userBuilder = $this->db->table('users');
        $this->orderItemBuilder = $this->db->table('order_items');
        $this->authGroupUserBuilder = $this->db->table('auth_groups_users');
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentModel = new PaymentModel();
    }

    public function index()
    {
        $this->orderBuilder
            ->select('SUM(total_price) AS total_spent')
            ->where('status', 'berhasil');
        $query = $this->orderBuilder->get();
        $totalEarning = $query->getRow();

        $completedOrdersCount = $this->orderModel->where('status', 'berhasil')->countAllResults();
        $pendingOrdersCount = $this->orderModel->where('status', 'tertunda')->countAllResults();
        $totalEarningAmount = $totalEarning->total_spent ? $totalEarning->total_spent : 0;

        $query = $this->orderBuilder
            ->select('recipient_name, recipient_phone, avatar, orders.status as order_status, total_price')
            ->join('users', 'orders.user_id = users.id')
            ->get(4);
        $orders = $query->getResult();

        $data = [
            'pageTitle' => 'Dashboard | Nuansa',
            'totalEarning' => $totalEarningAmount,
            'completedOrdersCount' => $completedOrdersCount,
            'pendingOrdersCount' => $pendingOrdersCount,
            'usersAmount' => $this->userModel->countAllResults(),
            'orders' => $orders
        ];

        return view('dashboard/admin/index', $data);
    }

    // Profile Controller
    public function profile()
    {
        $data = [
            'pageTitle' => "Dasbor | Admin | Profil",
        ];

        return view('dashboard/admin/profile/index', $data);
    }

    public function editProfile()
    {
        $data = [
            'pageTitle' => 'Dasbord | Admin | Edit Profil'
        ];

        return view('dashboard/admin/profile/edit', $data);
    }

    public function updateProfile()
    {
        $userId = user()->id;
        $postData = $this->request->getPost();

        $postData['id'] = $userId;

        $rules = $this->userModel->validationRules;
        $rules['id'] = 'permit_empty';

        $rules['email'] = str_replace('{id}', $userId, $rules['email']);
        $rules['username'] = str_replace('{id}', $userId, $rules['username']);

        if (!$this->userModel->validate($postData)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        $result = $this->userModel->save($postData);

        if ($result) {
            return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->route('admin.profile.index')->with('failed', 'Profil gagal diperbarui!');
        }
    }

    public function changePassword()
    {
        $data = [
            'pageTitle' => 'Dasbor | Admin | Ganti Sandi'
        ];

        return view('dashboard/admin/profile/change-password', $data);
    }

    public function updatePassword()
    {
        $rules = [
            'current_password' => [
                'label' => 'Sandi Saat Ini',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'new_password' => [
                'label' => 'Sandi Baru',
                'rules' => 'required|min_length[8]|strong_password',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'min_length' => '{field} minimal {param} karakter.',
                    'strong_password' => '{field} harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus.'
                ]
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Sandi',
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'matches' => '{field} tidak cocok dengan Sandi Baru.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        $userId = user()->id;
        $user = $this->userModel->find($userId);

        if (!Password::verify($currentPassword, $user->password_hash)) {
            return redirect()->back()->with('error', 'Sandi saat ini tidak benar!');
        }

        if (Password::verify($newPassword, $user->password_hash)) {
            return redirect()->back()->with('error', 'Sandi baru tidak boleh sama dengan sandi saat ini!');
        }

        $passwordHash = Password::hash($newPassword);
        $updateData = [
            'id' => $userId,
            'password_hash' => $passwordHash,
            'reset_hash' => null,
            'reset_at' => null,
            'reset_expires' => null,
            'force_pass_reset' => 0
        ];

        if ($this->userModel->save($updateData)) {
            $auth = service('authentication');
            $auth->logout();

            session()->setFlashdata('message', 'Sandi berhasil diperbarui! Silakan login dengan sandi baru.');

            return redirect()->to('/login');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui sandi!');
        }
    }

    // Product Controller
    public function products()
    {
        $query = $this->productBuilder
            ->select('categories.id as categoryId, products.id as productId, categories.name as category_name, products.name as product_name, products.slug as product_slug, products.description as product_description, is_featured, image, discount, price, stock')
            ->join('categories', 'products.category_id = categories.id')
            ->orderBy('products.name', 'ASC')
            ->get();

        $products = $query->getResultArray();

        $data = [
            'pageTitle' => 'Tektok Adventure | Kelola Produk',
            'products' => $products
        ];

        return view('dashboard/admin/product/index', $data);
    }

    public function createProduct()
    {
        $data = [
            'pageTitle' => 'Tektok Adventure | Tambah Produk Baru',
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('dashboard/admin/product/form', $data);
    }

    public function storeProduct()
    {
        $postData = $this->request->getPost();
        $postData['slug'] = url_title($postData['name'], '-', true);

        $categoryExists = $this->categoryModel->find($postData['category_id'] ?? null);
        if (!$categoryExists) {
            return redirect()->back()->withInput()->with('error_category', 'Kategori harus diisi!');
        }

        $imageFile = $this->request->getFile('image');

        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        if ($imageFile->isValid() && !in_array($imageFile->getExtension(), $allowedExt)) {
            return redirect()->back()->withInput()->with('error_image', 'Format gambar tidak valid!');
        }

        if ($imageFile->isValid() && $imageFile->getSize() > 2097152) {
            return redirect()->back()->withInput()->with('error_image', 'Ukuran gambar terlalu besar! Maksimal 2MB.');
        }

        if (!$this->validateData($postData, $this->productModel->getValidationRules(), $this->productModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $newName = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'img/product/uploads/', $newName);

            $postData['image'] = $newName;
        }

        $result = $this->productModel->save($postData);

        if ($result) {
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
        } else {
            return redirect()->route('admin.products.index')->with('failed', 'Produk gagal ditambahkan!');
        }
    }

    public function editProduct($slug)
    {
        $data = [
            'pageTitle' => 'Tektok Adventure | Ubah Produk',
            'product' => $this->productModel->where('slug', $slug)->first(),
            'categories' => $this->categoryModel->findAll()
        ];

        return view('dashboard/admin/product/form', $data);
    }

    public function updateProduct($id)
    {
        $product = $this->productModel->find($id);

        $postData = $this->request->getPost();
        $postData['slug'] = $product['name'] !== $postData['name'] ? url_title($postData['name'], '-', true) : $product['slug'];

        $categoryExists = $this->categoryModel->find($postData['category_id'] ?? null);
        if (!$categoryExists) {
            return redirect()->back()->withInput()->with('error_category', 'Kategori harus diisi!');
        }

        $imageFile = $this->request->getFile('image');

        if ($imageFile && $imageFile->isValid() && $imageFile->getError() === 0) {
            $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($imageFile->getExtension(), $allowedExt)) {
                return redirect()->back()->withInput()->with('error_image', 'Format gambar tidak valid!');
            }
            if ($imageFile->getSize() > 2097152) {
                return redirect()->back()->withInput()->with('error_image', 'Ukuran gambar terlalu besar! Maksimal 2MB.');
            }
            if (!$imageFile->hasMoved()) {
                $newName = $imageFile->getRandomName();
                $imageFile->move(FCPATH . 'img/product/uploads/', $newName);

                if (!empty($product['image']) && file_exists(FCPATH . $product['image']) && $product['image'] !== 'img/product/uploads/default-img-product.svg') {
                    @unlink(FCPATH . $product['image']);
                }

                $postData['image'] = $newName;
            }
        } else {
            $postData['image'] = $product['image'];
        }

        if (!$this->validateData($postData, $this->productModel->getValidationRules(), $this->productModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $postData['id'] = $id;
        $result = $this->productModel->save($postData);

        if ($result) {
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
        } else {
            return redirect()->route('admin.products.index')->with('failed', 'Produk gagal diperbarui!');
        }
    }

    public function destroyProduct($slug)
    {
        $product = $this->productModel->where('slug', $slug)->first();
        if (!$product) {
            return redirect()->route('admin.products.index')->with('failed', 'Produk tidak ditemukan!');
        }

        if (!empty($product['image']) && file_exists(FCPATH . 'img/uploads/main/' . $product['image']) && $product['image'] !== 'img/product/uploads/default.svg') {
            @unlink(FCPATH . 'img/product/uploads/' . $product['image']);
        }

        $this->productModel->delete($product['id']);
        $query = $this->request->getServer('QUERY_STRING');
        $url = route_to('admin.products.index') . ($query ? '?' . $query : '');
        return redirect()->to($url)->with('success', 'Produk berhasil dihapus!');
    }

    // Order Controller
    public function orders()
    {
        $orders = $this->orderModel->findAll();

        $data = [
            'pageTitle' => 'Nuansa | Admin | Pesanan',
            'orders' => $orders
        ];

        return view('dashboard/admin/order/index', $data);
    }

    public function showOrder($orderId)
    {
        $this->orderBuilder->select('order_items.id as orderItemId, name, price, image, quantity');
        $this->orderBuilder->join('order_items', 'orders.id = order_items.order_id');
        $this->orderBuilder->join('products', 'order_items.product_id = products.id');
        $this->orderBuilder->where('order_items.order_id', $orderId);
        $query = $this->orderBuilder->get();
        $orderItems = $query->getResult();

        $order = $this->orderModel->where('id', $orderId)->first();

        $proofOfPayment = $this->orderBuilder->select('proof_of_payment')
            ->join('payments', 'orders.id = payments.order_id')
            ->where('payments.order_id', $orderId)
            ->get()
            ->getRow();

        $data = [
            'pageTitle' => 'Nuansa | Detail Pesanan',
            'order_items' => $orderItems,
            'order' => $order,
            'proof_of_payment' => $proofOfPayment
        ];

        return view('dashboard/admin/order/show', $data);
    }

    public function updateOrder($orderId)
    {
        $query = $this->orderItemBuilder
            ->select('quantity, products.id as product_id, stock')
            ->join('orders', 'order_items.order_id = orders.id')
            ->join('products', 'order_items.product_id = products.id')
            ->where('order_items.order_id', $orderId)
            ->get();

        $orders = $query->getResultArray();

        $status = $this->request->getPost('status');

        $this->orderModel->update($orderId, [
            'status' => $status,
        ]);

        if ($status === 'berhasil') {
            foreach ($orders as $order) {
                $this->productModel->update($order['product_id'], [
                    'stock' => $order['stock'] - $order['quantity']
                ]);
            }
            return redirect()->back()->with('proofed', 'Pesanan berhasil disetujui!');
        } else {
            return redirect()->back()->with('proofed', 'Pesanan berhasil dibatalkan!');
        }
    }

    // Cashier Controller
    public function cashier()
    {
        $query = $this->productBuilder
            ->select('categories.id as categoryId, products.id as productId, categories.name as category_name, products.name as product_name, products.slug as product_slug, products.description as product_description, is_featured, image, discount, price, stock')
            ->join('categories', 'products.category_id = categories.id')
            ->where('stock >', 0)
            ->orderBy('products.name', 'ASC')
            ->get();

        $products = $query->getResultArray();

        $data = [
            'pageTitle' => 'Tektok Adventure | Kasir',
            'products' => $products
        ];

        return view('dashboard/admin/cashier/index', $data);
    }

    public function cashierCheckout()
    {
        $postData = $this->request->getPost();
        $cartItems = json_decode($postData['cart_items'], true);

        if (empty($cartItems)) {
            return redirect()->back()->with('failed', 'Keranjang kosong!');
        }

        foreach ($cartItems as $item) {
            $product = $this->productModel->find($item['id']);
            if (!$product || $product['stock'] < $item['quantity']) {
                return redirect()->back()->with('failed', 'Stok produk ' . $item['name'] . ' tidak mencukupi!');
            }
        }

        $orderData = [
            'user_id' => user()->id,
            'status' => 'berhasil',
            'total_price' => $postData['total_price'],
            'street_address' => 'Pembelian Langsung di Toko',
            'recipient_name' => $postData['recipient_name'],
            'recipient_email' => $postData['recipient_email'] ?? null,
            'recipient_phone' => $postData['recipient_phone'] ?? null,
            'notes' => $postData['notes'] ?? 'Pembelian langsung di toko - ' . $postData['payment_method']
        ];

        $this->orderModel->save($orderData);
        $orderId = $this->orderModel->insertID();

        foreach ($cartItems as $item) {
            $this->orderItemModel->save([
                'order_id' => $orderId,
                'product_id' => $item['id'],
                'quantity' => $item['quantity']
            ]);

            $product = $this->productModel->find($item['id']);
            $newStock = $product['stock'] - $item['quantity'];
            $this->productModel->update($item['id'], ['stock' => $newStock]);
        }

        $this->paymentModel->save([
            'order_id' => $orderId,
            'proof_of_payment' => 'cash_payment_' . date('YmdHis') . '.txt'
        ]);

        return redirect()->route('admin.cashier.receipt', [$orderId])->with('success', 'Transaksi berhasil!');
    }

    public function cashierReceipt($orderId)
    {
        $order = $this->orderModel->find($orderId);

        if (!$order) {
            return redirect()->route('admin.cashier.index')->with('failed', 'Pesanan tidak ditemukan!');
        }

        $query = $this->orderItemBuilder
            ->select('order_items.*, products.name, products.price, products.image, products.discount')
            ->join('products', 'order_items.product_id = products.id')
            ->where('order_items.order_id', $orderId)
            ->get();

        $orderItems = $query->getResult();

        $data = [
            'pageTitle' => 'Tektok Adventure | Struk Pembayaran',
            'order' => $order,
            'orderItems' => $orderItems
        ];

        return view('dashboard/admin/cashier/receipt', $data);
    }

    public function cashierReceiptPdf($orderId)
    {
        if (!class_exists('Dompdf\Dompdf')) {
            throw new \RuntimeException('Dompdf library is not installed. Please run: composer require dompdf/dompdf');
        }

        $order = $this->orderModel->find($orderId);

        if (!$order) {
            return redirect()->route('admin.cashier.index')->with('failed', 'Pesanan tidak ditemukan!');
        }

        $query = $this->orderItemBuilder
            ->select('order_items.*, products.name, products.price, products.image, products.discount')
            ->join('products', 'order_items.product_id = products.id')
            ->where('order_items.order_id', $orderId)
            ->get();

        $orderItems = $query->getResult();

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $html = $this->generateReceiptPdf($order, $orderItems);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Struk_' . $orderId . '_' . date('YmdHis') . '.pdf';
        $dompdf->stream($filename, ["Attachment" => false]);
    }

    private function generateReceiptPdf($order, $orderItems)
    {
        $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Struk Pembayaran</title>
                <style>
                    body {
                font-family: Arial, sans-serif;
                font-size: 12px;
                margin: 10px;
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .header h2 {
                        margin: 0;
                        font-size: 16px;
                    }
                    .header p {
                        margin: 2px 0;
                        font-size: 10px;
                    }
                    .divider {
                        border-top: 1px dashed #000;
                        margin: 10px 0;
                    }
                    table {
                        width: 100%;
                        font-size: 11px;
                    }
                    .item-name {
                        font-weight: bold;
                    }
                    .text-right {
                        text-align: right;
                    }
                    .total {
                        font-weight: bold;
                        font-size: 14px;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 20px;
                        font-size: 10px;
                    }
                </style>
        </head>
        <body>
            <div class="header">
                <h2>TEKTOK ADVENTURE</h2>
                <p>Pringgabaya, Lombok Timur</p>
                <p>Telp: +62 851-3903-8087</p>
            </div>
            
            <div class="divider"></div>
        
            <table>
                <tr>
                    <td>No. Order:</td>
                    <td class="text-right">#' . str_pad($order['id'], 6, '0', STR_PAD_LEFT) . '</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td class="text-right">' . date('d/m/Y H:i', strtotime($order['created_at'])) . '</td>
                </tr>
                <tr>
                    <td>Kasir:</td>
                    <td class="text-right">' . user()->username . '</td>
                </tr>
                <tr>
                    <td>Pelanggan:</td>
                    <td class="text-right">' . $order['recipient_name'] . '</td>
                </tr>
            </table>
        
            <div class="divider"></div>
        
            <table>';

        $subtotal = 0;
        $totalDiscount = 0;

        foreach ($orderItems as $item) {
            $itemTotal = $item->price * $item->quantity;
            $discount = $item->discount > 0 ? ($item->discount / 100) * $itemTotal : 0;
            $finalPrice = $itemTotal - $discount;

            $subtotal += $itemTotal;
            $totalDiscount += $discount;

            $html .= '
            <tr>
                <td colspan="2" class="item-name">' . $item->name . '</td>
            </tr>
            <tr>
                <td>' . $item->quantity . ' x Rp' . number_format($item->price, 0, ',', '.') . '</td>
                <td class="text-right">Rp' . number_format($itemTotal, 0, ',', '.') . '</td>
            </tr>';

            if ($discount > 0) {
                $html .= '
            <tr>
                <td>Diskon ' . $item->discount . '%</td>
                <td class="text-right">-Rp' . number_format($discount, 0, ',', '.') . '</td>
            </tr>';
            }
        }

        $html .= '
            </table>
        
            <div class="divider"></div>
        
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">Rp' . number_format($subtotal, 0, ',', '.') . '</td>
                </tr>';

        if ($totalDiscount > 0) {
            $html .= '
                <tr>
                    <td>Total Diskon:</td>
                    <td class="text-right">-Rp' . number_format($totalDiscount, 0, ',', '.') . '</td>
                </tr>';
        }

        $html .= '
                <tr class="total">
                    <td>TOTAL:</td>
                    <td class="text-right">Rp' . number_format($order['total_price'], 0, ',', '.') . '</td>
                </tr>
            </table>
        
            <div class="divider"></div>
        
            <div class="footer">
                <p>Terima kasih atas kunjungan Anda</p>
                <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
            </div>
        </body>
        </html>';

        return $html;
    }

    // User Controller
    public function users()
    {
        $this->userBuilder->select('users.id as userId, email, full_name, username, avatar, active');
        $this->userBuilder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->userBuilder->where('auth_groups_users.group_id', 2);
        $query = $this->userBuilder->get();
        $users = $query->getResultArray();

        $data = [
            'index' => 1,
            'pageTitle' => 'Dasbor | Admin | Pengguna',
            'users' => $users
        ];

        return view('dashboard/admin/user/index', $data);
    }

    public function destroyUser($username)
    {
        $queryAuthGroupsUsers = $this->authGroupUserBuilder->get();
        $authGroupsUsers = $queryAuthGroupsUsers->getResult();

        $authGroupsUserId = [];

        foreach ($authGroupsUsers as $row) {
            $authGroupsUserId[] = $row->user_id;
        }

        $user = $this->userBuilder->where('username', $username)->get()->getRow();
        $userId = $user->id;

        if (!$user && !in_array($userId, $authGroupsUserId)) {
            return redirect()->route('admin.users')->with('failed', 'Pengguna tidak ditemukan!');
        }

        if (!empty($user->avatar) && $user->avatar !== 'default-img-avatar.svg') {
            $avatarPath = FCPATH . 'img/uploads/avatar/' . $user->avatar;
            if (file_exists($avatarPath)) {
                @unlink($avatarPath);
            }
        }

        $this->userBuilder->where('username', $username)->delete();
        $query = $this->request->getServer('QUERY_STRING');
        $url = route_to('admin.users.index') . ($query ? '?' . $query : '');
        return redirect()->to($url)->with('success', 'Pengguna berhasil dihapus!');
    }

    // Report Controller
    public function reports()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $ordersBuilder = $this->db->table('orders');
        $ordersBuilder->select('orders.*, users.email as recipient_email')
            ->join('users', 'users.id = orders.user_id')
            ->where('orders.status', 'berhasil');

        if ($startDate) {
            $ordersBuilder->where('orders.created_at >=', $startDate);
        }
        if ($endDate) {
            $ordersBuilder->where('orders.created_at <=', $endDate . ' 23:59:59');
        }

        $query = $ordersBuilder->get();
        $filteredOrders = $query->getResultArray();

        $totalSales = array_reduce($filteredOrders, function ($carry, $order) {
            return $carry + $order['total_price'];
        }, 0);

        $data = [
            'pageTitle' => 'Nuansa | Admin | Laporan Transaksi',
            'orders' => $this->orderModel->findAll(),
            'filteredOrders' => $filteredOrders,
            'totalSales' => $totalSales,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        return view('dashboard/admin/report/index', $data);
    }

    public function previewReportPdf()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $ordersBuilder = $this->db->table('orders');
        $ordersBuilder->select('orders.*, users.email as recipient_email')
            ->join('users', 'users.id = orders.user_id')
            ->where('orders.status', 'berhasil');

        if ($startDate) {
            $ordersBuilder->where('orders.created_at >=', $startDate);
        }
        if ($endDate) {
            $ordersBuilder->where('orders.created_at <=', $endDate . ' 23:59:59');
        }

        $query = $ordersBuilder->get();
        $filteredOrders = $query->getResultArray();

        $totalSales = array_reduce($filteredOrders, function ($carry, $order) {
            return $carry + $order['total_price'];
        }, 0);

        $data = [
            'pageTitle' => 'Preview Laporan Penjualan',
            'orders' => $filteredOrders,
            'totalSales' => $totalSales,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        return view('dashboard/admin/report/preview', $data);
    }

    public function exportReportPdf()
    {
        if (!class_exists('Dompdf\Dompdf')) {
            throw new \RuntimeException('Dompdf library is not installed. Please run: composer require dompdf/dompdf');
        }

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $ordersBuilder = $this->db->table('orders');
        $ordersBuilder->select('orders.*, users.email as recipient_email')
            ->join('users', 'users.id = orders.user_id')
            ->where('orders.status', 'berhasil');

        if ($startDate) {
            $ordersBuilder->where('orders.created_at >=', $startDate);
        }
        if ($endDate) {
            $ordersBuilder->where('orders.created_at <=', $endDate . ' 23:59:59');
        }

        $query = $ordersBuilder->get();
        $filteredOrders = $query->getResultArray();

        $totalSales = array_reduce($filteredOrders, function ($carry, $order) {
            return $carry + $order['total_price'];
        }, 0);

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = $this->generatePdfContent($filteredOrders, $totalSales, $startDate, $endDate);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $filename = 'Laporan_Penjualan_';
        if ($startDate && $endDate) {
            $filename .= date('d_m_Y', strtotime($startDate)) . '_to_' . date('d_m_Y', strtotime($endDate));
        } elseif ($startDate) {
            $filename .= 'dari_' . date('d_m_Y', strtotime($startDate));
        } elseif ($endDate) {
            $filename .= 'sampai_' . date('d_m_Y', strtotime($endDate));
        } else {
            $filename .= 'semua_periode';
        }
        $filename .= '.pdf';

        // Output the generated PDF to Browser
        // Parameters:
        // 1. filename
        // 2. options: 'D' = Download, 'I' = Inline (display in browser), 'F' = Save to file, 'S' = Return as string
        $dompdf->stream($filename, ["Attachment" => true]);
    }

    private function generatePdfContent($orders, $totalSales, $startDate = null, $endDate = null)
    {
        $html = '
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Laporan Penjualan</title>
            <style>
                body { 
                    font-family: Helvetica, Arial, sans-serif; 
                    font-size: 10pt;
                    margin: 0;
                    padding: 20px;
                }
                .report-header { 
                    text-align: center; 
                    margin-bottom: 20px;
                    border-bottom: 2px solid #000;
                    padding-bottom: 10px;
                }
                .report-header h1 { 
                    margin: 0; 
                    color: #333;
                    font-size: 24pt;
                }
                .report-header p { 
                    margin: 5px 0; 
                    color: #666;
                    font-size: 12pt;
                }
                .company-info {
                    text-align: center;
                    margin-bottom: 10px;
                }
                .company-info p {
                    margin: 2px 0;
                    font-size: 9pt;
                    color: #555;
                }
                .total-sales {
                    background-color: #f0f0f0;
                    padding: 15px;
                    text-align: center;
                    margin-bottom: 20px;
                    font-weight: bold;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }
                .total-sales h3 {
                    margin: 0 0 5px 0;
                    color: #333;
                }
                .total-sales .amount {
                    font-size: 18pt;
                    color: #28a745;
                }
                table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    margin-bottom: 20px; 
                }
                table th, table td { 
                    border: 1px solid #ddd; 
                    padding: 8px;
                    text-align: left;
                }
                th { 
                    background-color: #f8f8f8;
                    font-weight: bold;
                    color: #333;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                .text-center {
                    text-align: center;
                }
                .text-right {
                    text-align: right;
                }
                .footer {
                    font-size: 8pt;
                    text-align: center;
                    color: #666;
                    margin-top: 30px;
                    padding-top: 10px;
                    border-top: 1px solid #ddd;
                }
                .summary-info {
                    margin-bottom: 20px;
                    padding: 10px;
                    background-color: #f5f5f5;
                    border-radius: 5px;
                }
                .summary-info p {
                    margin: 5px 0;
                    font-size: 10pt;
                }
            </style>
        </head>
        <body>
            <div class="company-info">
                <p><strong>Tektok Adventure</strong></p>
                <p>Pringgabaya, Lombok Timur</p>
                <p>Telp: +62 851-3903-8087 | Email: ucihalingga12@gmail.com</p>
            </div>
            
            <div class="report-header">
                <h1>Laporan Penjualan</h1>';

        if ($startDate && $endDate) {
            $html .= "<p>Periode: " . date('d F Y', strtotime($startDate)) . " - " . date('d F Y', strtotime($endDate)) . "</p>";
        } elseif ($startDate) {
            $html .= "<p>Mulai dari: " . date('d F Y', strtotime($startDate)) . "</p>";
        } elseif ($endDate) {
            $html .= "<p>Sampai dengan: " . date('d F Y', strtotime($endDate)) . "</p>";
        } else {
            $html .= "<p>Semua Periode</p>";
        }

        $html .= '
            </div>
            
            <div class="total-sales">
                <h3>Total Penjualan</h3>
                <div class="amount">Rp ' . number_format($totalSales, 0, ',', '.') . '</div>
            </div>
            
            <div class="summary-info">
                <p><strong>Ringkasan Laporan:</strong></p>
                <p>Total Transaksi: ' . count($orders) . ' pesanan</p>
                <p>Status: Semua transaksi berhasil</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="25%">Nama Penerima</th>
                        <th width="25%">Email</th>
                        <th width="15%">No. Telepon</th>
                        <th class="text-right" width="15%">Total Harga</th>
                    </tr>
                </thead>
                <tbody>';

        if (empty($orders)) {
            $html .= '
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data penjualan yang ditemukan.</td>
                </tr>';
        } else {
            foreach ($orders as $index => $order) {
                $html .= "
                <tr>
                    <td class='text-center'>" . ($index + 1) . "</td>
                    <td>" . date('d/m/Y', strtotime($order['created_at'])) . "</td>
                    <td>" . htmlspecialchars($order['recipient_name']) . "</td>
                    <td>" . htmlspecialchars($order['recipient_email']) . "</td>
                    <td>" . htmlspecialchars($order['recipient_phone'] ?? '-') . "</td>
                    <td class='text-right'>Rp " . number_format($order['total_price'], 0, ',', '.') . "</td>
                </tr>";
            }
        }

        $html .= '
                </tbody>
            </table>
            
            <div class="footer">
                <p>Laporan ini dicetak pada: ' . date('d F Y H:i:s') . '</p>
                <p>© ' . date('Y') . ' Tektok Adventure - Laporan Penjualan</p>
            </div>
        </body>
        </html>';

        return $html;
    }
}
