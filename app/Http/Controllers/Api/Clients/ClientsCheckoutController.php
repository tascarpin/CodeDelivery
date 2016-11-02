<?php

namespace CodeDelivery\Http\Controllers\Api\Clients;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientsCheckoutController extends Controller
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
        $id = Authorizer::getResourceOwnerId();
        $client_id = $this->userRepository->find($id)->client->id;
        $orders = $this->orderRepository->with('items')->scopeQuery(function($query) use($client_id){
            return $query->where('client_id', '=', $client_id);
        })->paginate();

        return $orders;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $client_id = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $client_id;
        $object = $this->createOrderService($data);

        return $this->orderRepository->with('items')->find($object->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $object = $this->orderRepository->with(['client', 'items', 'cupom'])->find($id);
        $object->items->each(function($item){
            $item->product;
        });
        return $object;
    }
}
