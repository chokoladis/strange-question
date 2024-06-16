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
        $categories = Category::getCategoriesLevel0();
        return view('categories.index', compact('categories'));
    }

    public function detail($category){
        $category = Category::getElement($category);
        return view('categories.detail', compact('category'));
    }

    public function add(){
        
        // cache and function resource activeWithParents
        // $categoriesFormating = [];

        $categories = Category::getActive();

        foreach ($categories as $category) {
            $daughters = $category->getDaughtersCategories();
            // dump($category, $daughters);
        }
        // foreach($categories as $category){

        //     // $daughters = $category->getDaughterCategories();
        //     // $parents = $category->getParentsCategories();
            
                
        //     //     $categoriesFormating[$category->id] = [
        //     //         'model' => $category,
        //     //         'childs_ids' => $categoryChilds
        //     //     ];
        //     // } else {
        //     //     $categoriesFormating[$category->category_parent_id]['childs'][$category->id] = $category;
        //     // }
            
        // }

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
}
