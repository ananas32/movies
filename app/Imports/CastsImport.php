<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CastsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        dd('eee');

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

