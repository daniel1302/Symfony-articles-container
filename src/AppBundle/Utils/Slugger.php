<?php
namespace AppBundle\Utils;


class Slugger
{
    public static function slugify($text)
    {
        return strtolower(preg_replace('/[^\w]+/i', '-', $text));
    }
}