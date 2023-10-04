<?php

namespace App\Util\Helper;
use Illuminate\Support\Str;


class HelperService implements HelperServiceInterface
{
    public function getSlug($string)
    {
        return Str::slug($string, '_');
    }
}
