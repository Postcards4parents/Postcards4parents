<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Managetemp;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');

        
    }
     
    public function mail_test(){


        $manage_tem= Managetemp::find(4);
        $mail_subject= $manage_tem['mail_subject'];
        $body=$manage_tem['mail_desc'];
        $to_email = 'ajay.kumar@sourcesoftsolutions.com';
        $to_name = 'Ajay kumar';
        $data = ['name'=>'Ajay', 'body' => $body];

        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email, $mail_subject) {
        $message->to($to_email, $to_name)
        ->subject($mail_subject);
        $message->from('ajay.sourcesoft@gmail.com','Test Mail');
        });
    }




}
