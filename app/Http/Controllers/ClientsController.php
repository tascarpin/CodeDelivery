<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminClientRequest;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\ClientService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientsController extends Controller
{
    use ClientService;

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ClientRepository
     */
    private $clientRepository;


    public function __construct(ClientRepository $clientRepository, UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
        $this->clientRepository = $clientRepository;
    }

    public function index(){
        $clients = $this->clientRepository->paginate(3);
        return view('admin.clients.index', compact('clients'));
    }

    public function create(){
        return view('admin.clients.create');
    }

    public function store(AdminClientRequest $adminClientRequest){
        $data = $adminClientRequest->all();
        $this->storeClientService($data);
        return redirect()->route('admin.clients.index');
    }

    public function edit($id){
        $client = $this->clientRepository->find($id);
        return view('admin.clients.edit', compact('client'));
    }

    public function update(AdminClientRequest $adminClientRequest, $id){
        $data = $adminClientRequest->all();
        $this->updateClientService($data, $id);
        return redirect()->route('admin.clients.index');
    }

    public function authenticated(){
        return $this->userRepository
            ->skipPresenter(false)
            ->find(Authorizer::getResourceOwnerID());
    }
}
