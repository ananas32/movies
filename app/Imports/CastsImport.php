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
        \App\Jobs\SaveCasts::dispatch($rows);
    }

    public function chunkSize(): int
    {
        return 60000;
    }
}

