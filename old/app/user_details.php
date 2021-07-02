<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_details extends Model
{
    
    protected $fillable = [
        'parent_fname', 'parent_lname', 'country','parent_gender','child_fname',
        'child_grade','child_gender','sibling_fname','sibling_grade','sibling_gender'
    ];


}
