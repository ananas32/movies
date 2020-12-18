<?php

namespace App\Jobs;

use App\Models\Cast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SaveCasts implements ShouldQueue
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
//            $cast = Cast::firstOrNew(['imdb_name_id' => $row[0]]);
            $cast = new Cast;
            DB::beginTransaction();
            try {
                $cast->saveParseRow($cast, $row);
                DB::commit();
            } catch (\Exception $exception) {
                info('В строке: ' . $row . ' случилась ошибка, формата ', $exception);
                DB::rollBack();
            }
        }
    }
}
