<?php

namespace klisl\languages;

use Yii;
use common\models\Lang;
use yii\web\NotFoundHttpException;

class Bootstrap implements \yii\base\BootstrapInterface
{
    //Метод, который вызывается автоматически при каждом запросе
    public function bootstrap($app)
    {
        if(YII_ENV == 'test') return; //для тестового приложения отключаем.

        /*
         * Включаем перевод сообщений
         */
        $app->i18n->translations['app'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            //'forceTranslation' => true,
            'basePath' => '@app/common/messages',
        ];

        $this->run($app);
    }

    public function run($app){
        $url = $app->request->url;

        //Получаем список языков в виде строки
        $string_languages = '';
        foreach (Lang::getLangs() as $lang) {
            $string_languages .= $lang->iso_code . '|';
        }

        preg_match("#^/($string_languages)(.*)#", $url, $match_arr);

        //Если URL содержит указатель языка - сохраняем его в параметрах приложения и используем
        if (isset($match_arr[1]) && $match_arr[1] != '/' && $match_arr[1] != ''){
            Lang::setCurrent($match_arr[1]);

            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'lang',
                'value' => Lang::getCurrent()->id_lang,
            ]));

            $app->language = $match_arr[1];
            $app->formatter->locale = $match_arr[1];
            $app->homeUrl = '/'.$match_arr[1];

            /*
             * Если URL не содержит указатель языка
             */
        } else {
            $url = $app->request->absoluteUrl; //Возвращает абсолютную ссылку

            $lang = Lang::getCurrent()->iso_code;

            $app->response->redirect(['languages/default/index', 'lang' => $lang, 'url' => $url], 301);
        }
    }
}
