<?php

namespace App\Validation;

class Video_Rules
{
    public function validate_video(string $str, string $field, array $data)
    {
        $parts = parse_url($data['video_url']);
        if ($parts['host'] == 'www.youtube.com')
            return true;

        return false;
    }
}
