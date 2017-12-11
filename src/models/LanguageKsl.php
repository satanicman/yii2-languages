<?php

namespace klisl\languages\models;

use Yii;

class LanguageKsl
{
    /**
    * Создает URL с меткой языка
    * Разбивает URL на подмассив $match_arr
    * 0. http://site.loc/ru/contact
    * 1. http://site.loc
    * 2. ru или uk или en
    * 3. остальная часть
    */
    public static function parsingUrl($language, $url_referrer)
    {
        //Получаем список языков в виде строки
        $string_languages = '';
        foreach (Lang::getLangs() as $lang) {
            $string_languages .= $lang->iso_code . '|';
        }
        $string_languages = preg_replace('/\|$/', '', $string_languages);

        $host = Yii::$app->request->hostInfo;

        preg_match("#^($host)/($string_languages)(.*)#", $url_referrer, $match_arr);

        //добавляем разделитель
        if (isset($match_arr[3]) && !empty($match_arr[3]) && !preg_match('#^\/#', $match_arr[3])){
            $separator = '/';
        } else {
            $separator = '';
        }

        $match_arr[2] = '/'.$language.$separator;

        // создание нового URL
        $url = $match_arr[1].$match_arr[2].$match_arr[3];
        return $url;
    }
}