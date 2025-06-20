<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use Myth\Auth\Models\UserModel;

class Admin extends BaseController
{
    protected $userModel, $productModel, $orderModel, $categoryModel, $productBuilder, $orderBuilder, $userBuilder, $authGroupUserBuilder, $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->productBuilder = $this->db->table('products');
        $this->orderBuilder = $this->db->table('orders');
        $this->userBuilder = $this->db->table('users');
        $this->authGroupUserBuilder = $this->db->table('auth_groups_users');
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $data = [
            'pageTitle' => 'Tektok Adventure | Dasbor Admin',
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
        $status = $this->request->getPost('status');

        $this->orderModel->update($orderId, [
            'status' => $status,
        ]);

        if ($status === 'berhasil') {
            return redirect()->back()->with('proofed', 'Pesanan berhasil disetujui!');
        } else {
            return redirect()->back()->with('proofed', 'Pesanan berhasil dibatalkan!');
        }
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
}
