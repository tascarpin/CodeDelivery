<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminClientRequest;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Services\ClientService;

class ClientsController extends Controller
{
    /**
     * @var ClientService
     */
    private $clientService;
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository, ClientService $clientService){

        $this->clientService = $clientService;

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
        $this->clientService->create($data);
        return redirect()->route('admin.clients.index');
    }

    public function edit($id){
        $client = $this->clientRepository->find($id);
        return view('admin.clients.edit', compact('client'));
    }

    public function update(AdminClientRequest $adminClientRequest, $id){
        $data = $adminClientRequest->all();
        $this->clientService->update($data, $id);
        return redirect()->route('admin.clients.index');
    }
}
