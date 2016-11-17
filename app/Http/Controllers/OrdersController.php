<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\AdminOrderRequest;
use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;

class OrdersController extends Controller
{
    use OrderService;

    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var CupomRepository
     */
    private $cupomRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        OrderRepository $orderRepository,
        CupomRepository $cupomRepository,
        ProductRepository $productRepository)
    {

        $this->orderRepository = $orderRepository;
        $this->cupomRepository = $cupomRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->paginate(3);
        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id, UserRepository $userRepository)
    {
        $order = $this->orderRepository->find($id);
        $list_status = $this->list_statusService();
        $deliveryman = $userRepository->findWhere(['role' => 'deliveryman'])->lists('name','id');
        return view('admin.orders.edit', compact('order', 'list_status', 'deliveryman'));
    }

    public function update(AdminOrderRequest $adminOrderRequest, $id)
    {
        $data = $adminOrderRequest->all();
        $this->orderRepository->update($data, $id);
        return redirect()->route('admin.orders.index');
    }
}
