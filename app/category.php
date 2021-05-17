<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Managetemp;

class category extends Model
{
    
    protected $fillable = [
        'name', 'cat_id', 'age_group','description'
    ];


public function children()
{
    return $this->hasMany(Category::class, 'cat_id');
}

public function parent()
{
    return $this->belongsTo(Category::class, 'cat_id');
}

public function cat_mail_template()
{
        return $this->hasMany('App\Managetemp','cat_id','id');
}
public function sub_cat_mail_template()
{
        return $this->hasMany('App\Managetemp','subcat_id','id');
}


}
