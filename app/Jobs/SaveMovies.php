<?php

namespace App\Jobs;

use App\Models\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveMovies implements ShouldQueue
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
//            $movie = Movie::firstOrNew(['imdb_title_id' => $row[0]]);
            $movie = new Movie;

            $movie->imdb_title_id = $row[array_search('imdb_title_id', $firstRow)];
            $movie->title = $row[array_search('title', $firstRow)];
            $movie->year = $row[array_search('year', $firstRow)];
            $movie->genre = $row[array_search('genre', $firstRow)];
            $movie->duration = $row[array_search('duration', $firstRow)];
            $movie->country = $row[array_search('country', $firstRow)];
            $movie->language = $row[array_search('language', $firstRow)];
            $movie->director = $row[array_search('director', $firstRow)];
            $movie->writer = $row[array_search('writer', $firstRow)];
            $movie->actors = $row[array_search('actors', $firstRow)];
            $movie->description = $row[array_search('description', $firstRow)];
            $movie->avg_vote = $row[array_search('avg_vote', $firstRow)];
            $movie->votes = $row[array_search('votes', $firstRow)];
            $movie->reviews_from_users = $row[array_search('reviews_from_users', $firstRow)];
            $movie->reviews_from_critics = $row[array_search('reviews_from_critics', $firstRow)];
            $movie->save();
        }
    }
    //                is_usa
//                is_europe
//                is_top
}
