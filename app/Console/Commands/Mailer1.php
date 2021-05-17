<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Contentful\Delivery\Client as DeliveryClient;
use app\Helper\ContentAssetHelper;
use app\Helper\ContentEntryInline;
use app\Helper\ContentDynamicExcess;
use app\Helper\ContentEntryBlock;
use app\Helper\ContentHyperlink;
use app\Helper\ContentEntryHyperlink;


class Mailer1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postcard:mailer1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly postcard mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DeliveryClient $client)
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
       
        
        //$this->client;
        
        $return=app()->call('App\Http\Controllers\ContentfullController@index'); 
        $this->info($return);



    }
}
