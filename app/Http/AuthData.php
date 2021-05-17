<?php
namespace App\Helper;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;
use App\category;
use Illuminate\Support\Facades\DB;
use App\subcategory;


class AuthData
{
    
    public static function shout()
    {
        //return "AJAY  HJKLJ";
         //Session::put('user', Auth::user()->id);
        // session(['user1' => 'Ann']);
         //dd(Session::get('user'));
        
         //dd(Auth::user());

       return User::find(7);
      

    }
    public static function category()
    {
        $all=category::where('cat_id','=',0)->pluck('name','id');
        return $all;
    }
    public static function subcategory($cat_id)
    {
        $all=category::where('cat_id','>',1)->where('cat_id','=',$cat_id)->pluck('name','id');
        return $all;
    }



}
?>