<?php

namespace App\Console\Commands;

use App\Imports\CastsImport;
use Illuminate\Console\Command;
use Excel;

class CastsImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'casts:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        dump('start at: ' . now()->format('Y-m-d H:i:s'));
        Excel::import(new CastsImport, public_path() . '/storage/csv-files/IMDb names.csv');
        dump('stop at: ' . now()->format('Y-m-d H:i:s'));
        dd('movies import success');
    }
}
