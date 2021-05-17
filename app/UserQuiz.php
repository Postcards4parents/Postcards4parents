<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Managetemp;

class UserQuiz extends Model
{
    protected $table = 'user_quiz';
    protected $fillable = [
        'user_name', 'user_email', 'grade', 'results'
    ];



}
?>
