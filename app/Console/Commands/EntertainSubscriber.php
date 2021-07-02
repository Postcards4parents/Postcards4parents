<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EntertainSubscriber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postcard:newsubscriberretain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending mailer on postcard subscriber';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        
      //  $return=app()->call('App\Http\Controllers\HomeContentController@mailerCron');
        $return=app()->call('App\Http\Controllers\HomeContentController@newSubscribers'); 
        Log::channel('single')->info('Mailer details.',$return);

        dd(json_encode($return));
        // $headers=['info'];
        // $this->table($headers,$return);
    }
}
