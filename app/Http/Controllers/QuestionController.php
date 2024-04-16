<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    // Question
    public function index(){

    }

    public function add(){
        return view('questions.add');
    }

    // public function store(StoreRequest $request){}
}
