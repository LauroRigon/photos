<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    protected $fillable = [
        'name',
        'user_id',
        'album_id',
        'img',
        ];
}
