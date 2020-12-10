<?php

namespace App\Imports;

use App\Models\Movie;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MoviesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $firstRow = null;
//            array_search('green', $array);

        foreach ($rows as $row) {
            if (!$firstRow) {
                $movie = Movie::firstOrNew(['imdb_title_id' => $row[0]]);
                $movie->imdb_title_id = $row[0];
                $movie->title = $row[1];
                $movie->year = $row[3];
                $movie->genre = $row[5];
                $movie->duration = $row[6];
                $movie->country = $row[7];
                $movie->language = $row[8];
                $movie->director = $row[9];
                $movie->writer = $row[10];
                $movie->actors = $row[12];
                $movie->description = $row[13];
                $movie->avg_vote = $row[14];
                $movie->votes = $row[15];
                $movie->reviews_from_users = $row[20];
                $movie->reviews_from_critics = $row[21];
                $movie->save();
            }else {
                $firstRow = $rows->first()->toArray();
                dd($firstRow);
            }
        }
    }
}
//                is_usa
//                is_europe
//                is_top
