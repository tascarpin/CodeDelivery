<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    use OrderService;

    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        ProductRepository $productRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $client_id = $this->userRepository->find(Auth::user()->id)->client->id;
        $orders = $this->orderRepository->scopeQuery(function($query) use($client_id){
            return $query->where('client_id', '=', $client_id);
        })->paginate();

        return view('customer.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = $this->productRepository->all(['id', 'name', 'price']);
        return view('customer.orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $client_id = $this->userRepository->find(Auth::user()->id)->client->id;
        $data['client_id'] = $client_id;
        $this->createOrderService($data);

        return redirect()->route('customer.orders.index');
    }

}
