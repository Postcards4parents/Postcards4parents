<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class updateGrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postcard:updateGrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Yearly cron run on 1st jan every year to update grades';

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
        $return=app()->call('App\Http\Controllers\HomeContentController@mailerCron'); 
        $this->info($return);

    }
}
