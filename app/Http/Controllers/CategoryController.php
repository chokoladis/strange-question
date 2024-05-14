<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
use App\Services\FileService;
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

        try {
            if ($request->hasFile('img')){
                $img = $request->file('img');
                if ($img->isValid()){                    
                    $res = FileService::save($img,'categories');
                    $data['file_id'] = $res['id'];
                } else {
                    // return JsonResponse(['error' => 'Не валидный файл']);
                }
            }
            unset($data['img']);
            
            $category = Category::firstOrCreate([ 'title' => $data['title'] ],$data);
        } catch (\Throwable $th) {
            throw $th;
        }
        dd($data);

        // ['result' => $category]
        // return HttpFoundationJsonResponse()-;
    }

    // $data['user_id'] = auth()->user()->id;
    // $data['user_id'] = 1;
}
