<?php

namespace App\Jobs;

use App\Models\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SaveMovies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rows;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rows)
    {
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
        foreach ($rows as $row) {
            $movie = new Movie();
            DB::beginTransaction();
            try {
                $movie->saveParseRow($movie, $row);
                DB::commit();
            } catch (\Exception $exception) {
                info('В строке: ' . $row . ' случилась ошибка, формата ', $exception);
                DB::rollBack();
            }
        }
    }
}
