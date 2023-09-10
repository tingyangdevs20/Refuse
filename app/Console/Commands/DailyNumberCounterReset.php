<?php

namespace App\Console\Commands;

use App\Model\Number;
use Illuminate\Console\Command;

class DailyNumberCounterReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countreset:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to reset numbers counter daily';

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
     * @return int
     */
    public function handle()
    {
        $numbers=Number::all();
        foreach ($numbers as $number) {
            $number->sms_count=0;
            $number->save();
        }
        echo "Number Counter Reset done";
        return 0;
    }
}
