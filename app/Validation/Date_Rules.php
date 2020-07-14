<?php

namespace App\Validation;

class Date_Rules
{
    public function validate_date(string $str, string $field, array $data)
    {
        $date = (isset($data['video_date']) ? $data['video_date'] : $data['gallery_date'] );

        $month = intval(substr($date, -7, 2));
        $day = intval(substr($date, -10, 2));
        $year = intval(substr($date, -4));

        return checkdate($month, $day, $year);
    }
}
