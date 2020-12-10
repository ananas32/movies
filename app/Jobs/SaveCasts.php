<?php

namespace App\Jobs;

use App\Models\Cast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveCasts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $arrayKeys, $rows;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($arrayKeys, $rows)
    {
        $this->arrayKeys = $arrayKeys;
        $this->rows = $rows;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rows = $this->rows;
        $firstRow = $this->arrayKeys;
        foreach ($rows as $row) {
//            $cast = Cast::firstOrNew(['imdb_name_id' => $row[array_search('imdb_name_id', $firstRow)]]);
            $cast = new Cast;

            $cast->imdb_title_id = $row[array_search('imdb_name_id', $firstRow)];
            $cast->title = $row[array_search('name', $firstRow)];
            $cast->year = $row[array_search('height', $firstRow)];
            $cast->genre = $row[array_search('bio', $firstRow)];
            $cast->duration = $row[array_search('date_of_birth', $firstRow)];
            $cast->country = $row[array_search('place_of_birth', $firstRow)];
            $cast->language = $row[array_search('children', $firstRow)];
            $cast->director = $row[array_search('is_usa', $firstRow)];
            $cast->writer = $row[array_search('is_europe', $firstRow)];
            $cast->save();
        }
    }
}
