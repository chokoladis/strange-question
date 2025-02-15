<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Http\Requests\Question\StoreRequest;
use App\Models\Category;
use App\Models\Question;
use App\Services\FileService;

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
        $data['user_id'] = auth()->id();//user()->id; // заглушка
        $data['active'] = $request->user()->can('isAdmin', auth()->user());

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

            if ($question->wasRecentlyCreated){
                return redirect()->route('questions.index')->with('message', 'Вопрос сохранен и будет опубликован позже');
            } else {
                return redirect()->back()->with('message', 'Такой вопрос уже задавали.');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function detail($question){
        [$question, $error] = Question::getElement($question);

        return view('questions.detail', compact('question', 'error'));
    }

    public static function findByUrl(string $url){
        $urlExplode = explode('/', $url);
        $questionCode = $urlExplode[count($urlExplode) - 1];

        $question = Question::query()->where('code', $questionCode)->first();
        return $question;
    }
}
