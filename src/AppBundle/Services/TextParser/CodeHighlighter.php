<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 30.01.17
 * Time: 20:42
 */

namespace AppBundle\Services\TextParser;

use GeSHi;

class CodeHighlighter implements TextParser
{
    private $regex = '/\[code( +language=\"([\w\+\-\_]+)\")?](.*?)\[\/code\]/ims';

    const   DEFAULT_LANGUAGE = 'html';

    const   INDEX_FULL_SEARCH   = 0,
            INDEX_LANGUAGE      = 1,
            INDEX_LANGUAGE_NAME = 2,
            INDEX_CONTENT       = 3;

    public function parse($string)
    {
        $string = preg_replace_callback($this->regex, [$this, 'parseFunction'], $string);
        return $string;
    }

    public function parseFunction($matches)
    {
        if (!isset($matches[self::INDEX_LANGUAGE])) {
            $language = self::DEFAULT_LANGUAGE;
        } else {
            $language = $matches[self::INDEX_LANGUAGE_NAME];
        }

        $geshi = new GeSHi($matches[self::INDEX_CONTENT], $language);

        return $geshi->parse_code();
    }
}