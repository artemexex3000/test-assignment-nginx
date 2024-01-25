<?php

namespace App\Services;

use Illuminate\Support\Str;
use function Tinify\fromFile;
use function Tinify\setKey;

class StoreImageUserService
{
    public function crop(string $src)
    {
        setKey(env('TINIFY_API_KEY'));

        $hashName = Str::uuid()->toString();

        $source = fromFile($src);
        $source->resize([
            "method" => "cover",
            "width" => 70,
            "height" => 70,
        ])->toFile("/var/www/html/storage/app/public/".$hashName.".jpg");

        return "/var/www/html/storage/app/public/".$hashName.".jpg";
    }
}
