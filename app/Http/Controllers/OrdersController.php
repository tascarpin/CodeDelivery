<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\AdminOrderRequest;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;

class OrdersController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderRepository $orderRepository, OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderRepository->paginate(3);
        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id, UserRepository $userRepository)
    {
        $order = $this->orderRepository->find($id);
        $list_status = $this->orderService->list_status();
        $deliveryman = $userRepository->findWhere(['role' => 'deliveryman'])->lists('name','id');
        return view('admin.orders.edit', compact('orders', 'list_status', 'deliveryman'));
    }

    public function update(AdminOrderRequest $adminOrderRequest, $id)
    {
        $data = $adminOrderRequest->all();
        $this->orderRepository->update($data, $id);
        return redirect()->route('admin.orders.index');
    }
}
