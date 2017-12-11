<?php

namespace klisl\languages;

class Module extends \yii\base\Module
{

    public $controllerNamespace = 'klisl\languages\controllers';

    public $languages; //Языки используемые в приложении

    public $default_language; //основной язык (по-умолчанию)

    public $show_default; //показывать в URL основной язык

}
