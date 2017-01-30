<?php
namespace AppBundle\Services;


use AppBundle\Services\TextParser\TextParser;

class ArticleParser
{
    private $parsers = [];

    public function __construct()
    {

    }

    public function addParser(TextParser $parser)
    {
        $this->parsers[] = $parser;
    }

    public function parse($string)
    {
        foreach ($this->parsers as $parser) {
            $string = $parser->parse($string);
        }

        return $string;
    }
}