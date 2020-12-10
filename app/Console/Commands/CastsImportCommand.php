<?php

namespace App\Console\Commands;

use App\Imports\CastsImport;
use App\Models\Cast;
use App\Models\Statistic;
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
        $startAt = now()->format('Y-m-d H:i:s');
        Excel::import(new CastsImport, public_path() . '/storage/csv-files/IMDb names.csv');
        $stopAt = now()->format('Y-m-d H:i:s');

        $statistic = new Statistic();
        $statistic->description = 'cast table';
        $statistic->total_row = Cast::count();
        $statistic->start_at = $startAt;
        $statistic->stop_at = $stopAt;
        $statistic->save();

        dd('movies import success');
    }
}
