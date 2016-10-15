<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\AdminCupomRequest;
use CodeDelivery\Repositories\CupomRepository;

class CupomsController extends Controller
{
    /**
     * @var CupomRepository
     */
    private $cupomRepository;

    public function __construct(CupomRepository $cupomRepository)
    {
        $this->cupomRepository = $cupomRepository;
    }

    public function index()
    {
        $cupoms = $this->cupomRepository->paginate(3);
        return view('admin.cupoms.index', compact('cupoms'));
    }

    public function create()
    {
        return view('admin.cupoms.create');
    }

    public function edit($id){
        $cupom = $this->cupomRepository->find($id);
        return view('admin.cupoms.edit', compact('cupom'));
    }

    public function store(AdminCupomRequest $adminCupomRequest){
        $data = $adminCupomRequest->all();
        $this->cupomRepository->create($data);
        return redirect()->route('admin.cupoms.index');
    }

    public function update(AdminCupomRequest $adminCupomRequest, $id){
        $data = $adminCupomRequest->all();
        $this->cupomRepository->update($data, $id);
        return redirect()->route('admin.cupoms.index');
    }
}

