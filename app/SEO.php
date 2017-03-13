<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class SEO extends Model
{
    protected $table = 's_e_os';

    public $timestamps = false;

    public static function getCurrentSEO() {
        $SEOraw = Session::get('SEO');
        if (!$SEOraw) {
            return null;
        }

        $SEO = new SEO();
        $SEO->id = $SEOraw['id'];
        $SEO->original_url = $SEOraw['original_url'];
        $SEO->alias_url = $SEOraw['alias_url'];
        $SEO->title = $SEOraw['title'];
        $SEO->keywords = $SEOraw['keywords'];
        $SEO->description = $SEOraw['description'];

        return $SEO;
    }

    public static function saveCurrentSEO(SEO $SEO) {
        Session::put('SEO', $SEO->toArray());
    }
}
