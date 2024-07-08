<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Feedback\StoreRequest;

class FeedbackController extends Controller
{
    
    public function store(StoreRequest $request){
        return $request;
    }

}
