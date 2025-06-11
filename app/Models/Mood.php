<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    public $timestamps = false;

    protected $fillable = ['emoji', 'created_at'];
}
