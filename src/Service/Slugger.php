<?php

namespace App\Service;

class Slugger
{
    public function slugify(string $string)
    {
        $string = strtolower($string);

        return preg_replace('/\W+/', '-', trim(strip_tags($string)));

        // L'art de louer plus facilement
        // l-art-de-louer-plus-facilement

        // La liberté d'évoluer sans soucis
        // la-libert-d-voluer-sans-soucis

        // Once Upon a time… in Hollywood
        // once-upon-a-time-in-hollywood
    }
}