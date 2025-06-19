<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class Landing extends BaseController
{
    protected $productModel, $categoryModel, $cartModel, $cartsTotalAmount, $db;


    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->cartModel = new CartModel();
    }


    public function index()
    {
        $data = [
            'pageTitle' => 'Tektok Adventure',
            'products' => $this->productModel->where('is_featured', 1)->limit(3)->find(),
        ];

        return view('landing/index', $data);
    }

    public function shop()
    {
        $data = [
            'pageTitle' => 'Tektok Adventure | Belanja',
            'products' => $this->productModel->findAll(),
            'categories' => $this->categoryModel->findAll(),
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
            'relatedProducts' => $relatedProducts
        ];

        return view('landing/shop/show', $data);
    }

    public function cart()
    {
        $cartsBuilder = $this->db->table('carts');
        $query = $cartsBuilder
            ->select('carts.id as cart_id, categories.name as category_name, products.id as product_id, products.name as product_name, products.description as product_description, image, products.slug as product_slug, price, price_at_add, quantity, stock')
            ->join('products', 'carts.product_id = products.id')
            ->join('categories', 'products.category_id = categories.id')
            ->get();
        $carts = $query->getResult();

        foreach ($carts as $cart) {
            $this->cartsTotalAmount += $cart->price_at_add;
        }

        $data = [
            'pageTitle' => 'Tektok Adventure | Keranjang',
            'carts' => $carts,
            'cartsTotalAmount' => $this->cartsTotalAmount,
        ];

        return view('landing/cart', $data);
    }

    public function addToCart()
    {
        $quantity = $this->request->getPost('quantity') ?? 1;
        $productId = $this->request->getPost('product_id');
        $product = $this->productModel->find($productId);
        $cart = $this->cartModel->where(['product_id' => $productId, 'user_id' => user()->id])->first();
        $currentCartQty = $cart ? (int)$cart['quantity'] : 0;
        $totalRequestedQty = $currentCartQty + $quantity;

        if ($product['stock'] < 1 || $totalRequestedQty > $product['stock']) {
            return redirect()->back()->withInput()->with('not_in_stock', 'Stok produk tidak mencukupi!');
        }

        if ($cart) {
            $newQuantity = $totalRequestedQty;
            $newPriceAtAdd = $product['price'] * $newQuantity;
            $this->cartModel->update($cart['id'], [
                'quantity' => $newQuantity,
                'price_at_add' => $newPriceAtAdd
            ]);
        } else {
            $this->cartModel->save([
                'user_id' => user()->id,
                'product_id' => $productId,
                'quantity' => $totalRequestedQty,
                'price_at_add' => $product['price'] * $totalRequestedQty
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
}
