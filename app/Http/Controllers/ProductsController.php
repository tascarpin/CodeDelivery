<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminProductRequest;
use CodeDelivery\Repositories\CategoryRepository;
use CodeDelivery\Repositories\ProductRepository;

class ProductsController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function index(){
        $products = $this->productRepository->paginate(3);
        return view('admin.products.index', compact('products'));
    }

    public function create(){
        $categories = $this->categoryRepository->lists('name', 'id');
        return view('admin.products.create', compact('categories'));
    }

    public function store(AdminProductRequest $adminProductRequest){
        $data = $adminProductRequest->all();
        $this->productRepository->create($data);
        return redirect()->route('admin.products.index');
    }

    public function edit($id){
        $product = $this->productRepository->find($id);
        $categories = $this->categoryRepository->lists('name', 'id');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(AdminProductRequest $adminProductRequest, $id){
        $data = $adminProductRequest->all();
        $this->productRepository->update($data, $id);
        return redirect()->route('admin.products.index');
    }

    public function destroy($id){
        $this->productRepository->find($id)->delete();
        return redirect()->route('admin.products.index');
    }
}
