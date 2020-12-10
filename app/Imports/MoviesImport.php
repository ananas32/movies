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

//        $firstRow = [
//            0 => "imdb_title_id",
//            1 => "title",
//            2 => "original_title",
//            3 => "year",
//            4 => "date_published",
//            5 => "genre",
//            6 => "duration",
//            7 => "country",
//            8 => "language",
//            9 => "director",
//            10 => "writer",
//            11 => "production_company",
//            12 => "actors",
//            13 => "description",
//            14 => "avg_vote",
//            15 => "votes",
//            16 => "budget",
//            17 => "usa_gross_income",
//            18 => "worlwide_gross_income",
//            19 => "metascore",
//            20 => "reviews_from_users",
//            21 => "reviews_from_critics",
//        ];
        $firstRow = $rows->first()->toArray();
        dump('first element success created at: ' . now()->format('Y-m-d H:i:s'));
        $totalQueue = 0;
        foreach ($rows->chunk(100) as $chunkRows) {
            \App\Jobs\SaveMovies::dispatch($firstRow, $chunkRows);
            $totalQueue++;
            dump($totalQueue);
        }
    }
}

