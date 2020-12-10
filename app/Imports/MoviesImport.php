<?php

namespace App\Imports;

use App\Models\Movie;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MoviesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $firstRow = $rows->first()->toArray();
        dump('first element success created at: ' . now()->format('Y-m-d H:i:s'));
        $totalQueue = 0;
        $rows->shift();
        foreach ($rows->chunk(100) as $chunkRows) {
            \App\Jobs\SaveMovies::dispatch($firstRow, $chunkRows);
            $totalQueue++;
            dump($totalQueue);
        }
    }
}

