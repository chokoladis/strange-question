<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserComments extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $guarded = [];

    public function user() : HasOne{
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
