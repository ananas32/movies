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
    public function __construct($rows)
    {
        $this->arrayKeys = [
            0 => "imdb_name_id",
            1 => "name",
            2 => "birth_name",
            3 => "height",
            4 => "bio",
            5 => "birth_details",
            6 => "date_of_birth",
            7 => "place_of_birth",
            8 => "death_details",
            9 => "date_of_death",
            10 => "place_of_death",
            11 => "reason_of_death",
            12 => "spouses_string",
            13 => "spouses",
            14 => "divorces",
            15 => "spouses_with_children",
            16 => "children",
        ];;
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
            if(env('FIRST_START_PARSER')) {
                //first start
                $cast = new Cast;
            } else {
                // update parser
                $cast = Cast::firstOrNew(['imdb_name_id' => $row[array_search('imdb_name_id', $firstRow)]]);
            }

            $place_of_birth = $row[array_search('place_of_birth', $firstRow)];
            $cast->imdb_name_id = $row[array_search('imdb_name_id', $firstRow)];
            $cast->name = $row[array_search('name', $firstRow)];
            $cast->height = $row[array_search('height', $firstRow)];
            $cast->bio = $row[array_search('bio', $firstRow)];
            $cast->date_of_birth = $row[array_search('date_of_birth', $firstRow)];
            $cast->place_of_birth = $place_of_birth;
            $cast->children = $row[array_search('children', $firstRow)];

            if (strripos($place_of_birth, 'USA') !== false) {
                $cast->is_usa = 1;
            } else {
                $cast->is_europe = 1;
            }

            $cast->save();
        }
        dump('save cast');
    }
}
