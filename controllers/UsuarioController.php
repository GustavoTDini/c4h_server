<?php

namespace app\controllers;

use yii\base\DynamicModel;

class UsuarioController extends \yii\rest\ActiveController{

    public $modelClass = 'app\models\Usuario';

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'attributeMap' => [
                'cpf' => 'vl_cpf',
                'login'=> 'nm_login',
                'cnpj'=> 'vl_cnpj'
            ],
            'searchModel' => (new DynamicModel(['cpf', 'login', 'cnpj']))->addRule(['cpf', 'login', 'cnpj'], 'string', ['min' => 1]),
        ];

        return $actions;
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        // remove authentication filter necessary because we need to
        // add CORS filter, and it should be added after the CORS
        //unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => '\yii\filters\Cors',
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

//        // re-add authentication filter of your choce
//        $behaviors['authenticator'] = [
//            'class' => yii\filters\auth\HttpBasicAuth::class
//        ];

//        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
//        $behaviors['authenticator']['except'] = ['options'];
        return $behaviors;
    }

}
