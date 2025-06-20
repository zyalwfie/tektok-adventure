<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\CategoryModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;

class Landing extends BaseController
{
    protected $productModel, $categoryModel, $cartModel, $cartsTotalAmount, $cartsTotalCount, $orderModel, $orderItemModel, $paymentModel, $db;


    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentModel = new PaymentModel();
    }


    public function index()
    {
        $data = [
            'pageTitle' => 'Tektok Adventure',
            'products' => $this->productModel->where('is_featured', 1)->limit(3)->find(),
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->cartModel->where('user_id', user()->id)->countAllResults())
        ];

        return view('landing/index', $data);
    }

    public function shop()
    {
        $data = [
            'pageTitle' => 'Tektok Adventure | Belanja',
            'products' => $this->productModel->findAll(),
            'categories' => $this->categoryModel->findAll(),
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->cartModel->where('user_id', user()->id)->countAllResults())
        ];

        return view('landing/shop/index', $data);
    }

    public function showShop($slug)
    {
        $product = $this->productModel->where('slug', $slug)->first();
        $relatedProducts = $this->productModel
            ->where('category_id', $product['category_id'])
            ->where('slug !=', $product['slug'])
            ->limit(4)
            ->find();

        $data = [
            'pageTitle' => 'Tektok Adventure | ' . $product['name'],
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->cartModel->where('user_id', user()->id)->countAllResults())
        ];

        return view('landing/shop/show', $data);
    }

    public function cart()
    {
        $cartsBuilder = $this->db->table('carts');
        $query = $cartsBuilder
            ->select('carts.id as cart_id, categories.name as category_name, products.id as product_id, products.name as product_name, products.description as product_description, image, products.slug as product_slug, price, price_at_add, quantity, stock, discount')
            ->join('products', 'carts.product_id = products.id')
            ->join('categories', 'products.category_id = categories.id')
            ->get();
        $carts = $query->getResult();

        foreach($carts as $cart) {
            $this->cartsTotalAmount += $cart->price_at_add;
        }
        
        $data = [
            'pageTitle' => 'Tektok Adventure | Keranjang',
            'carts' => $carts,
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->cartModel->where('user_id', user()->id)->countAllResults()),
            'cartsTotalAmount' => $this->cartsTotalAmount
        ];

        return view('landing/cart', $data);
    }

    public function addToCart()
    {
        $quantity = $this->request->getPost('quantity') ?? 1;

        if (!preg_match('/^\d+$/', $quantity)) {
            return redirect()->back()->withInput()->with('wrong_type_of', 'Kuantitas yang kamu masukkan harus berupa angka!');
        }

        $productId = $this->request->getPost('product_id');
        $product = $this->productModel->find($productId);
        $cart = $this->cartModel->where(['product_id' => $productId, 'user_id' => user()->id])->first();
        $currentCartQty = $cart ? (int)$cart['quantity'] : 0;
        $totalRequestedQty = $currentCartQty + $quantity;
        $priceAtAdd = $product['price'];

        if ($product['stock'] < 1 || $totalRequestedQty > $product['stock']) {
            return redirect()->back()->withInput()->with('not_in_stock', 'Stok produk tidak mencukupi!');
        }

        if ($product['discount'] > 1) {
            $dicountPrice = $product['discount'] / 100 * $product['price'];
            $dicountPriceResult = $product['price'] - $dicountPrice;
            $priceAtAdd = $dicountPriceResult;
        }

        if ($cart) {
            $newQuantity = $totalRequestedQty;
            $newPriceAtAdd = $priceAtAdd;
            $this->cartModel->update($cart['id'], [
                'quantity' => $newQuantity,
                'price_at_add' => $newPriceAtAdd
            ]);
        } else {
            $this->cartModel->save([
                'user_id' => user()->id,
                'product_id' => $productId,
                'quantity' => $totalRequestedQty,
                'price_at_add' => $priceAtAdd
            ]);
        }

        return redirect()->route('landing.cart.index')->with('success', 'Kuantitas produk berhasil ditambahkan!');
    }

    public function increaseCartQuantity($cartId)
    {
        $cart = $this->cartModel->find($cartId);
        $currentCartQty = $cart['quantity'];
        if (!$cart || $cart['user_id'] !== user()->id) {
            return redirect()->route('landing.cart.index');
        }

        $product = $this->productModel->find($cart['product_id']);
        if (!$product) {
            return redirect()->route('landing.cart.index');
        }

        if ($currentCartQty > $product['stock']) {
            return redirect()->back()->with('not_in_stock', 'Stok produk tidak mencukupi!');
        } else {
            $newQuantity = $cart['quantity'] + 1;
            $newPriceAtAdd = $product['price'] * $newQuantity;
            $this->cartModel->update($cartId, [
                'quantity' => $newQuantity,
                'price_at_add' => $newPriceAtAdd
            ]);
            return redirect()->back()->with('success', 'Kuantitas produk berhasil ditambahkan!');
        }
    }

    public function decreaseCartQuantity($cartId)
    {
        $cart = $this->cartModel->find($cartId);
        $currentCartQty = $cart['quantity'];
        if (!$cart || $cart['user_id'] !== user()->id) {
            return redirect()->route('landing.cart.index');
        }

        if ($currentCartQty > 1) {
            $product = $this->productModel->find($cart['product_id']);
            $newQuantity = $currentCartQty - 1;
            $newPriceAtAdd = $product['price'] * $newQuantity;
            $this->cartModel->update($cartId, [
                'quantity' => $newQuantity,
                'price_at_add' => $newPriceAtAdd
            ]);
        }

        return redirect()->back()->with('success', 'Kuantitas stok berhasil dikurangi!');
    }

    public function destroyCart($cartId)
    {
        $cart = $this->cartModel->find($cartId);
        if ($cart && $cart['user_id'] === user()->id) {
            $this->cartModel->delete($cartId);
        }
        return redirect()->route('landing.cart.index');
    }

    public function payment($orderId)
    {
        $order = $this->orderModel->where('id', $orderId)->first();
        $payment = $this->paymentModel->where('order_id', $orderId)->first();

        if (!$order) {
            return redirect()->back()->with('no_order', 'Pesanan belum dibuat');
        }

        if ($payment && $payment['proof_of_payment']) {
            return redirect()->route('landing.cart.payment.done');
        }

        $data = [
            'pageTitle' => 'Tektok Adventure | Pembayaran',
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->cartModel->where('user_id', user()->id)->countAllResults()),
            'order_id' => $orderId
        ];

        return view('landing/payment', $data);
    }

    public function paymentCreate()
    {
        $carts = $this->cartModel->where('user_id', user()->id)->findAll();
        $postData = $this->request->getPost();

        if (!$this->validateData($postData, $this->orderModel->getValidationRules(), $this->orderModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        } elseif (!$carts) {
            return redirect()->back()->withInput()->with('empty_carts', 'Tidak ada apa-apa di dalam keranjang!');
        }

        $postData['user_id'] = user()->id;
        $this->orderModel->save($postData);
        $order = $this->orderModel->orderBy('created_at', 'DESC')->first();

        if (isset($postData['product_id'], $postData['quantity'])) {
            foreach ($postData['product_id'] as $idx => $productId) {
                $quantity = isset($postData['quantity'][$idx]) ? $postData['quantity'][$idx] : 1;
                $this->orderItemModel->save([
                    'order_id' => $order['id'],
                    'product_id' => $productId,
                    'user_id' => user()->id,
                    'quantity' => $quantity
                ]);
            }
        }

        $this->cartModel->where('user_id', user()->id)->delete();
        $paymentResult = $this->paymentModel->save([
            'order_id' => $order['id'],
        ]);

        if ($paymentResult) {
            return redirect()->route('landing.cart.payment.index', [$order['id']])->with('success', 'Pesanan telah dibuat!');
        } else {
            return redirect()->back()->with('failed', 'Pesanan gagal dibuat!');
        }
    }

    public function paymentUpload()
    {
        $file = $this->request->getFile('proof_of_payment');
        $orderId = $this->request->getPost('order_id');
        $uriString = $this->request->getPost('uri_string');
        $errors = [];

        if ($file->isValid()) {
            $mimeType = $file->getMimeType();
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
            if (!in_array($mimeType, $allowedTypes)) {
                $errors['proof_of_payment'] = 'File harus berupa gambar (jpg, jpeg, png) atau PDF.';
            } elseif ($file->getSize() > 2097152) {
                $errors['proof_of_payment'] = 'Ukuran file maksimal 2MB.';
            }
        } else {
            $errors['proof_of_payment'] = 'Bukti pembayaran harus diunggah!';
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $newName = $file->getRandomName();
        $file->move(FCPATH . 'img/product/proof', $newName);

        $payment = $this->paymentModel->where('order_id', $orderId)->first();
        if ($payment) {
            $this->paymentModel->update($payment['id'], [
                'proof_of_payment' => $newName
            ]);
        }

        if ($uriString === 'dashboard/user/orders/show/' . $orderId) {
            return redirect()->back()->with('proofed', 'File bukti berhasil diunggah!');
        }

        return redirect()->route('landing.cart.payment.done');
    }

    public function paymentUpdate()
    {
        dd($this->request->getFile('proof_of_payment'));
        
        $file = $this->request->getFile('proof_of_payment');
        $orderId = $this->request->getPost('order_id');
        $errors = [];

        if ($file->isValid()) {
            $mimeType = $file->getMimeType();
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($mimeType, $allowedTypes)) {
                $errors['proof_of_payment'] = 'File harus berupa gambar (jpg, jpeg, png) atau PDF.';
            } elseif ($file->getSize() > 2097152) {
                $errors['proof_of_payment'] = 'Ukuran file maksimal 2MB.';
            }
        } else {
            $errors['proof_of_payment'] = 'Bukti pembayaran harus diunggah!';
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $newName = $file->getRandomName();
        $file->move(FCPATH . 'img/product/proof', $newName);

        $payment = $this->paymentModel->where('order_id', $orderId)->first();
        if ($payment) {
            if (!empty($payment['proof_of_payment'])) {
                $oldPath = FCPATH . 'img/product/proof/' . $payment['proof_of_payment'];
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
            $this->paymentModel->update($payment['id'], [
                'proof_of_payment' => $newName
            ]);
        }

        return redirect()->back()->with('proofed', 'File bukti berhasil diperbarui!');
    }

    public function paymentDone()
    {
        $data = [
            'pageTitle' => 'Nuansa | Pembayaran',
            'cartsTotalCount' => ((!logged_in()) ? 0 : $this->cartModel->where('user_id', user()->id)->countAllResults()),
        ];

        return view('landing/thanks', $data);
    }
}
