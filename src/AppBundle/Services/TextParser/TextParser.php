<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 30.01.17
 * Time: 20:39
 */

namespace AppBundle\Services\TextParser;


interface TextParser
{
    public function parse($string);
}