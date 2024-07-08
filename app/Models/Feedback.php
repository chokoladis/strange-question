<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    const SUBJECTS = [
        'Проблемы с сайтом', 'Предложения и идеи', 'Сотрудничество/реклама', 'Другое'
    ];
    
}
