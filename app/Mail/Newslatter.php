<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Newslatter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $manage_temp= $this->data;
        $mail_subject=  $manage_temp['mail_subject'];
        $body=$manage_temp['mail_desc'];
        $data = ['name'=>'Ajay', 'body' => $body];
        return $this->view('emails.mail',$data)->subject($mail_subject);
    }
}
