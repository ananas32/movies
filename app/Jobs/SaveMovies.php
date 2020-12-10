<?php

namespace App\Jobs;

use App\Models\Country;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Movie;
use App\Models\NewMovies;
use App\Models\OldMovies;
use Illuminate\Bus\Queueable;
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

            $year = $row[array_search('year', $firstRow)];
            $genre = $row[array_search('genre', $firstRow)];
            $country = $row[array_search('country', $firstRow)];
            $language = $row[array_search('language', $firstRow)];
            $avg_vote = $row[array_search('avg_vote', $firstRow)];

            if (env('FIRST_START_PARSER')) {
                //first start
                $movie = new Movie;
            } else {
                // update parser
                $movie = Movie::firstOrNew(['imdb_title_id' => $row[0]]);
            }

            $movie->imdb_title_id = $row[array_search('imdb_title_id', $firstRow)];
            $movie->title = $row[array_search('title', $firstRow)];
            $movie->year = $year;
            $movie->genre = $genre;
            $movie->duration = $row[array_search('duration', $firstRow)];
            $movie->country = $country;
            $movie->language = $language;
            $movie->director = $row[array_search('director', $firstRow)];
            $movie->writer = $row[array_search('writer', $firstRow)];
            $movie->actors = $row[array_search('actors', $firstRow)];
            $movie->description = $row[array_search('description', $firstRow)];
            $movie->avg_vote = (double)$avg_vote;
            $movie->votes = $row[array_search('votes', $firstRow)];
            $movie->reviews_from_users = $row[array_search('reviews_from_users', $firstRow)];
            $movie->reviews_from_critics = $row[array_search('reviews_from_critics', $firstRow)];

            $isUSA = strripos($country, 'USA') !== false;
            if ($isUSA) {
                $movie->is_usa = 1;
            } else {
                $movie->is_europe = 1;
            }

            if ($avg_vote >= 8) {
                $movie->is_top = 1;
            }

            if ($country) {
//                $countryRow = Country::firstOrNew(['title' => $country]);
                $countryArray = explode(',', $genre);
                foreach ($countryArray as $item) {
                    $countryDb = Country::firstOrNew(['name' => $item]);
                    $countryDb->name = $item;
                    if ($isUSA) {
                        $countryDb->is_usa = 1;
                    } else {
                        $countryDb->is_europe = 1;
                    }
                    $countryDb->save();
                }
            }

            if ($language) {
                $languageArray = explode(',', $genre);
                foreach ($languageArray as $item) {
                    $languageDb = Language::firstOrNew(['name' => $item]);
                    $languageDb->name = $item;
                    $languageDb->save();
                }
            }

            if ($genre) {
                $genreArray = explode(',', $genre);
                foreach ($genreArray as $item) {
                    $genreDb = Genre::firstOrNew(['name' => $item]);
                    $genreDb->name = $item;
                    $genreDb->save();
                }
            }

            $movie->save();

            if ($year < 1980) {
                $oldMovie = new OldMovies;
                $oldMovie->movie_id = $movie->id;
                $oldMovie->year = intval($year);
                $oldMovie->save();
            } else {
                $newMovie = new NewMovies;
                $newMovie->movie_id = $movie->id;
                $newMovie->year = intval($year);
                $newMovie->save();
            }
        }
    }
}
