<?php

namespace App\Console\Commands;

use App\Models\Statistic;
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
        $startAt = now()->format('Y-m-d H:i:s');
        Excel::import(new MoviesImport, public_path() . '/storage/csv-files/IMDb movies.csv');
        $stopAt = now()->format('Y-m-d H:i:s');
        dd('movies import success');
        $statistic = new Statistic();
        $statistic->description = 'cast table';
        $statistic->total_row = MoviesImport::count();
        $statistic->start_at = $startAt;
        $statistic->stop_at = $stopAt;
        $statistic->save();
    }
}
