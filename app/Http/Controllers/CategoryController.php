<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::query()->where('active', true);
        return view('categories.index', compact('categories'));
    }

    public function add(){

        return view('categories.add');
    }

    public function store(StoreRequest $request){

        // 'user_id' => user()->id

    }
}
