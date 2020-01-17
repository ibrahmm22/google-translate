<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['names', 'hits', 'translated_names'];
    public $timestamps = false;
}
