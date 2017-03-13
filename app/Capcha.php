<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Image;

class Capcha extends Model
{
    public static function getCapcha ($width, $height) {
        $image = ImageStorage::makeCanvas($width, $height, $fontFilePath=null);
        $code = rand(1000,9999);
        Session::put('capcha', $code);
        //create the image resource
        $im = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($im, 69, 87, 115); //background color
        $fg = imagecolorallocate($im, 255, 255, 255);//text color
        $ns = imagecolorallocate($im, 255, 255, 0);//noise color

        //fill the image resource with the bg color
        imagefill($im, 0, 0, $bg);

        //Add the random code of string to the image
        imagestring($im, 5, 10, 8,  $code, $fg);//imagestring

        // Add some noise to the image.
        for ($i = 0; $i < 15; $i++) {
            for ($j = 0; $j < 15; $j++) {
                imagesetpixel(
                    $im,
                    rand(0, $width),
                    rand(0, $height),//make sure the pixels are random and don't overflow out of the image
                    $ns
                );
            }
        }
        $img = Image::make($im);
        return $img->stream('data-url', 100);
    }

    public static function checkCapcha ($code) {
        $realCode = Session::get('capcha');
        if ($code == $realCode) {
            return true;
        }

        return false;
    }
}
