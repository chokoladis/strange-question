<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Http\Requests\Question\StoreRequest;
use App\Models\Category;
use App\Models\Question;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{

    public function index(){
        $questions = Question::getActive();
        return view('questions.index', compact('questions'));
    }

    public function add(){

        $categories = Category::getDaughtersCategories();

        return view('questions.add', compact('categories'));
    }

    public function store(StoreRequest $request){


        $data = $request->validated();
        $data['user_id'] = 1; // заглушка

        try {
            if ($request->hasFile('img')){
                $img = $request->file('img');
                if ($img->isValid()){                    
                    $res = FileService::save($img,'questions');
                    $data['file_id'] = $res['id'];
                } else {
                    // return JsonResponse(['error' => 'Не валидный файл']);
                }
            }
            unset($data['img']);
            
            $question = Question::firstOrCreate([
                'title' => $data['title']
            ],$data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function detail($question){
        $question = Question::getElement($question);
        return view('questions.detail', compact('question'));
    }

    public static function findByUrl(string $url){
        $urlExplode = explode('/', $url);
        $questionCode = $urlExplode[count($urlExplode) - 1];

        $question = Question::query()->where('code', $questionCode)->first();
        return $question;
    }
}
