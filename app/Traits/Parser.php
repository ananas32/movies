<?php

namespace App\Traits;

trait Parser
{
    abstract public function saveParseRow($obj, $row);
}
