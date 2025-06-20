<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\UserModel;

class User extends BaseController
{
    protected $orderModel, $orderBuilder, $userModel, $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->orderBuilder = $this->db->table('orders');
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        $this->orderBuilder
            ->select('SUM(total_price) AS total_spent')
            ->where(['status' => 'berhasil', 'user_id' => user()->id]);
        $query = $this->orderBuilder->get();
        $totalEarning = $query->getRow();

        $completedOrdersCount = $this->orderModel->where(['status' => 'berhasil', 'user_id' => user()->id])->countAllResults();
        $pendingOrdersCount = $this->orderModel->where(['status' => 'tertunda', 'user_id' => user()->id])->countAllResults();
        $totalEarningAmount = $totalEarning->total_spent ? $totalEarning->total_spent : 0;

        $query = $this->orderBuilder
            ->select('recipient_name, recipient_phone, avatar, orders.status as order_status, total_price')
            ->join('users', 'orders.user_id = users.id')
            ->where('orders.user_id', user()->id)
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

        return view('dashboard/user/index', $data);
    }

    public function orders()
    {
        $data = [
            'pageTitle' => 'Tektok Adventure | Data Pesanan',
            'orders' => $this->orderModel->where('user_id', user()->id)->findAll(),
        ];

        return view('dashboard/user/order/index', $data);
    }

    public function showOrder($orderId)
    {
        $this->orderBuilder->select('order_items.id as orderItemId, name, price, image, quantity');
        $this->orderBuilder->join('order_items', 'orders.id = order_items.order_id');
        $this->orderBuilder->join('products', 'order_items.product_id = products.id');
        $this->orderBuilder->where('orders.user_id', user()->id);
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

        return view('dashboard/user/order/show', $data);
    }

    public function profile()
    {
        $data = [
            'pageTitle' => "Dasbor | Pengguna | Profil"
        ];

        return view('dashboard/user/profile/index', $data);
    }

    public function editProfile()
    {
        $data = [
            'pageTitle' => "Dasbord | Pengguna | Edit Profil"
        ];

        return view('dashboard/user/profile/edit', $data);
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
            return redirect()->route('user.profile.index')->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->route('user.profile.index')->with('failed', 'Profil gagal diperbarui!');
        }
    }
}
