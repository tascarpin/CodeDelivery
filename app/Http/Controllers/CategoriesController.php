<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminCategoryRequest;
use CodeDelivery\Repositories\CategoryRepository;

class CategoriesController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(){
        $categories = $this->categoryRepository->paginate(3);
        return view('admin.categories.index', compact('categories'));
    }

    public function create(){
        return view('admin.categories.create');
    }

    public function store(AdminCategoryRequest $adminCategoryRequest){
        $data = $adminCategoryRequest->all();
        $this->categoryRepository->create($data);
        return redirect()->route('admin.categories.index');
    }

    public function edit($id){
        $category = $this->categoryRepository->find($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(AdminCategoryRequest $adminCategoryRequest, $id){
        $data = $adminCategoryRequest->all();
        $this->categoryRepository->update($data, $id);
        return redirect()->route('admin.categories.index');
    }
}
