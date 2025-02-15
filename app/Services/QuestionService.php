<?php

namespace App\Services;

use App\Models\Question;

Class QuestionService
{
    private static $model = Question::class;

    public static function getList($filter = [], $select = ['*'], $limit = 10)
    {
        //        cache
        if (empty($filter)) {
            return false;
        }

        $limit = $limit > 0 && $limit < 100 ? $limit : 10;

        $query = self::$model::query();

        foreach ($filter as $key => $item) {
            $query->where($key, $item);
        }

        $result = $query->paginate($limit, $select);

        return $result;
    }

    public function getByCode(string $code)
    {
        $question = $this->model::where('code', $code)->first();
    }
}