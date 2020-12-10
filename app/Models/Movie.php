<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

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
