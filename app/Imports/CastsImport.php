<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CastsImport implements ToCollection, WithChunkReading
{
    use RemembersChunkOffset;
    public function collection(Collection $rows)
    {
        $chunkOffset = $this->getChunkOffset();
        dump('first element success created at: ' . now()->format('Y-m-d H:i:s'));
        $totalQueue = 0;
        foreach ($rows->chunk(100) as $chunkRows) {
            \App\Jobs\SaveCasts::dispatch($chunkRows);
            $totalQueue++;
            dump('chunk: '.$chunkOffset . ' total: '. $totalQueue);
        }
    }

    public function chunkSize(): int
    {
        return 60000;
    }
}

