<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    // Question
    public function index(){

    }

    public function add(){

        $categories = Category::query()->where('active', true);

        return view('questions.add', compact('categories'));
    }

    public function store(StoreRequest $request){

        // 'user_id' => user()->id

    }
}
