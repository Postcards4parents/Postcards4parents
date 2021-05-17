<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    
    protected $fillable = [
        'name', 'cat_id', 'age_group','description'
    ];


}
