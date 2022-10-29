<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TokenUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('oauth_clients')
        ->where('name', 'Laravel Password Grant Client')
        ->where('id', 2)
        ->update(['secret' => 'cQdhQwWaaGfak9WvqGpguWcmqVZLrWwylkggCOt7']);
    }
}
