<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\JsonResponse as HttpFoundationJsonResponse;

class CategoryController extends Controller
{

    public function index(){
        $categories = Category::getCategoriesLevel0();
        return view('categories.index', compact('categories'));
    }

    public function detail($category){
        $category = Category::getElement($category);
        $childs = self::getCurrCategoryChilds($category);
        return view('categories.detail', compact('category', 'childs'));
    }

    public function add(){
        
        // cache and function resource activeWithParents
        $categories = Category::getDaughtersCategories();

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

            // check role
            $data['active'] = 1;
            
            $category = Category::firstOrCreate([ 'title' => $data['title'] ],$data);

            return redirect()->route('categories.index');
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    static function getCurrCategoryChilds(Category $category){

        $category_childs = Cache::remember($category->id.'_childs', Category::$timeCache, function($category){
            dd($category);

            return Category::query()
                ->where('active', 1)
                // ->where('category_parent_id', $category->id)
                ->get();
        });

        return $category_childs;
    }
}
