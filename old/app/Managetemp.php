<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Managetemp extends Model
{
   protected $table='manage_templates';
   
    protected $fillable = [
        'cat_id','subcat_id','mail_subject','mail_desc'
    ];

    public function category()
    {
        return $this->belongsTo('App\category', 'cat_id','id');
    }
    public function subcategory()
    {
        return $this->belongsTo('App\category', 'subcat_id','id');
    }


}
