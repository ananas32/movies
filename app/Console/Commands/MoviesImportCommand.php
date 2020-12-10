<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\MoviesImport;
use Excel;

class MoviesImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movies:parse';

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
        Excel::import(new MoviesImport, public_path() . '/storage/csv-files/IMDb movies.csv');
        dump('stop at: ' . now()->format('Y-m-d H:i:s'));
        dd('movies import success');
        return 0;
    }
}
