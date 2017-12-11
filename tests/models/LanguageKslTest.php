<?php

namespace klisl\languages\tests\models;

use klisl\languages\models\LanguageKsl;
use klisl\languages\tests\TestCase;


class LanguageKslTest extends TestCase
{
    public function testparsingUrlWithAnotherLang()
    {
        $res = LanguageKsl::parsingUrl('uk', 'http://site.com/en');
        $this->assertEquals($res, 'http://site.com/uk');
    }
}