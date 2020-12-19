<?php

namespace App\Jobs;

use App\Imports\CastsImport;
use App\Imports\MoviesImport;
use Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StartImportCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Excel::import(new MoviesImport, public_path() . '/storage/csv-files/IMDb movies.csv');
//        Excel::import(new CastsImport, public_path() . '/storage/csv-files/IMDb names.csv');
    }
}
