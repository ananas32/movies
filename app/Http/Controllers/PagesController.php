<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $decades = Movie::select(\DB::raw("((year div 10) * 10) as decade"))
            ->where('year', '>', 1910)
            ->groupBy('decade')
            ->get();

        $votes = 500;
        $sql = '';
        $lastYear = $decades->sortDesc()->first()->decade;

        foreach ($decades as $item) {
            $y1 = $item->decade;
            $y2 = $item->decade+10;
            $sql .= '(select * from movies where (votes > '. $votes .' and year > '. $y1 .' and year < '. $y2 .' and is_usa = 1) order by avg_vote desc limit 5)';
            if($lastYear != $item->decade) {
                $sql .= 'union';
            }
        }

        $bestMovies = \DB::select($sql);
        return view('home', compact('bestMovies'));
    }
}


