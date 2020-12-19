<?php

namespace App\Models;
use App\Traits\Parser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use Parser;

    protected $parseFieldsCsv = [
        "imdb_name_id",
        "name",
        "birth_name",
        "height",
        "bio",
        "birth_details",
        "date_of_birth",
        "place_of_birth",
        "death_details",
        "date_of_death",
        "place_of_death",
        "reason_of_death",
        "spouses_string",
        "spouses",
        "divorces",
        "spouses_with_children",
        "children",
    ];

    use HasFactory;

    protected $fillable = ['*'];

    public function saveParseRow($thisObj, $row)
    {
        $titleRow = $this->parseFieldsCsv;
        $placeOfBirth = $row[array_search('place_of_birth', $titleRow)];
        $thisObj->imdb_name_id = $row[array_search('imdb_name_id', $titleRow)];
        $thisObj->name = $row[array_search('name', $titleRow)];
        $thisObj->height = $row[array_search('height', $titleRow)];
        $thisObj->bio = $row[array_search('bio', $titleRow)];
        $thisObj->date_of_birth = $row[array_search('date_of_birth', $titleRow)];
        $thisObj->place_of_birth = $placeOfBirth;
        $thisObj->children = $row[array_search('children', $titleRow)];
        $thisObj->is_usa = this_or_other_field($placeOfBirth, 'USA');
        $thisObj->is_europe = this_or_other_field($placeOfBirth, 'USA');
        $thisObj->save();
    }
}
