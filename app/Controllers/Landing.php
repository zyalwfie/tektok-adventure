<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class Landing extends BaseController
{
    protected $productModel, $categoryModel;


    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
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
        $data = [
            'pageTitle' => 'Tektok Adventure | Keranjang'
        ];

        return view('landing/cart/index', $data);
    }
}
