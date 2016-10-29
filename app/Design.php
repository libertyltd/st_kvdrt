<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = ['name', 'lead_description', 'description', 'price', 'status', 'show_in_main'];

    public $timestamps = false;

    public static function formatPrice ($price) {
        $fraction = ($price*100)%100;
        $integer = explode('.', $price);
        $integer = $integer[0];

        $lengthOfInteger = strlen($integer);
        if ($lengthOfInteger > 0) {
            $lengthOfInteger--;
        }

        $row = [];
        for (; $lengthOfInteger >= 0; $lengthOfInteger--) {
            $row[] = $integer[$lengthOfInteger];
            if ($lengthOfInteger%3 == 0) {
                $row[] = ' ';
            }
        }

        $lengthOfInteger = count($row);
        if ($lengthOfInteger > 0) {
            $lengthOfInteger--;
        }
        $integer = '';
        for (; $lengthOfInteger >= 0; $lengthOfInteger--) {
            $integer = $integer.$row[$lengthOfInteger];
        }

        if ($fraction > 0) {
            if ($fraction < 10) {
                $fraction = '0'.$fraction;
            }

            $integer = $integer.','.$fraction;
        }

        return $integer;
    }

    public function CategoryDesigns () {
        return $this->hasMany('App\CategoryDesign');
    }
}
