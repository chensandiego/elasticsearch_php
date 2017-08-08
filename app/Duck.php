<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Duck extends Model
{
    use Searchable;

    protected $guarded=[];
    
}
