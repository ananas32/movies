<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    protected $parseFieldsCsv = [
        "imdb_title_id",
        "title",
        "original_title",
        "year",
        "date_published",
        "genre",
        "duration",
        "country",
        "language",
        "director",
        "writer",
        "production_company",
        "actors",
        "description",
        "avg_vote",
        "votes",
        "budget",
        "usa_gross_income",
        "worlwide_gross_income",
        "metascore",
        "reviews_from_users",
        "reviews_from_critics",
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    public function saveParseRow($thisObj, $row)
    {
        $titleRow = $this->parseFieldsCsv;

        $year = $row[array_search('year', $titleRow)];
        $avgVote = $row[array_search('avg_vote', $titleRow)];

        $thisObj->imdb_title_id = $row[array_search('imdb_title_id', $titleRow)];
        $thisObj->title = $row[array_search('title', $titleRow)];
        $thisObj->year = $year;
        $thisObj->duration = $row[array_search('duration', $titleRow)];
        $thisObj->director = $row[array_search('director', $titleRow)];
        $thisObj->writer = $row[array_search('writer', $titleRow)];
        $thisObj->actors = $row[array_search('actors', $titleRow)];
        $thisObj->description = $row[array_search('description', $titleRow)];
        $thisObj->avg_vote = (double)$avgVote;
        $thisObj->votes = $row[array_search('votes', $titleRow)];
        $thisObj->reviews_from_users = $row[array_search('reviews_from_users', $titleRow)];
        $thisObj->reviews_from_critics = $row[array_search('reviews_from_critics', $titleRow)];


        $genre = $row[array_search('genre', $titleRow)];
        $country = $row[array_search('country', $titleRow)];
        $language = $row[array_search('language', $titleRow)];

        $thisObj->is_usa = this_or_other_field($country, 'USA');
        $thisObj->is_europe = this_or_other_field($country, 'USA');

        if ($avgVote >= 8) {
            $thisObj->is_top = 1;
        }

        $thisObj->save();

        $this->saveRelationsModel($thisObj, $genre, 'Genre', 'genres');
        $this->saveRelationsModel($thisObj, $language, 'Language', 'languages');
        $this->saveRelationsCountry($thisObj, $language, 'Country', 'countries');
        $this->newOrOldMovie($this->id, $year);
    }

    public function newOrOldMovie($id, $year)
    {
        if ($year < 1980) {
            $tmpMovie = new OldMovies;
        } else {
            $tmpMovie = new NewMovies;
        }

        $tmpMovie->movie_id = $id;
        $tmpMovie->year = intval($year);
        $tmpMovie->save();
    }

    public function saveRelationsModel($movieModel, $string, $modelSync, $relation)
    {
        if ($string) {
            $syncArray = [];
            $genreArray = explode(',', $string);
            foreach ($genreArray as $item) {
                $modelDb = ('\App\\Models\\' . $modelSync)::firstOrNew(['name' => $item]);
                $modelDb->name = $item;
                $modelDb->save();
                $syncArray[] = $modelDb->id;
            }
            $movieModel->{$relation}()->sync($syncArray);
        }
    }

    public function saveRelationsCountry($movieModel, $countries, $modelSync, $relation)
    {
        if ($countries) {
            $syncArray = [];
            $genreArray = explode(',', $countries);
            foreach ($genreArray as $item) {
                $modelDb = ('\App\\Models\\' . $modelSync)::firstOrNew(['name' => $item]);
                $modelDb->name = $item;
                $modelDb->is_usa = this_or_other_field($countries, 'USA');
                $modelDb->is_europe = this_or_other_field($countries, 'USA');
                $modelDb->save();
                $syncArray[] = $modelDb->id;
            }
            $movieModel->{$relation}()->sync($syncArray);
        }
    }

    public function makeQueryList($field)
    {
        $decades = Movie::select(\DB::raw("((year div 10) * 10) as decade"))
            ->where('year', '>', 1910)
            ->groupBy('decade')
            ->get();

        $bestMovies = Movie::whereId(null);

        foreach ($decades as $item) {
            $query = Movie::where([
                ['year', '>=', $item->decade],
                ['year', '<', $item->decade + 10],
                ['votes', '>', 500],
                [$field, '=', 1]
            ])->orderBy('avg_vote', 'desc')->take(5);
            $bestMovies->union($query);

        }

        return $bestMovies->get();
    }
}
