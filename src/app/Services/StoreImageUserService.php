<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function Tinify\fromFile;
use function Tinify\setKey;

class StoreImageUserService
{
    public function crop(string $src)
    {
        setKey(env('TINIFY_API_KEY'));

        $hashName = Str::uuid()->toString() . ".jpg";
        $source = fromFile($src);

        Storage::put($hashName, $source->resize([
            "method" => "cover",
            "width" => 70,
            "height" => 70,
        ])->toBuffer());

        return $hashName;
    }
}
