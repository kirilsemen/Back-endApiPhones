<?php

namespace App\Console\Commands;

use App\Jobs\SendOrdersToOwners;
use Illuminate\Console\Command;

class CronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send orders data to owners.';

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
     * @return void
     */
    public function handle()
    {
        dispatch(new SendOrdersToOwners());
    }
}
