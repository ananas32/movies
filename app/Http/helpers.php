<?php
function this_or_other_field($string, $findString)
{
    if (strripos($string, $findString) !== false) {
        return 1;
    }
    return 0;
}
