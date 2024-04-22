<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse as HttpFoundationJsonResponse;

class CategoryController extends Controller
{

    public function index(){
        $categories = Category::getActive();
        return view('categories.index', compact('categories'));
    }

    public function detail($category){
        $category = Category::getElement($category);
        return view('categories.detail', compact('category'));
    }

    public function add(){
        
        $categories = Category::getActive();

        return view('categories.add', compact('categories'));
    }

    public function store(StoreRequest $request){

        $data = $request->validated();
        
        $category = Category::firstOrCreate($data);

        // ['result' => $category]
        // return HttpFoundationJsonResponse()-;
    }

    // $data['user_id'] = auth()->user()->id;
    // $data['user_id'] = 1;
}
