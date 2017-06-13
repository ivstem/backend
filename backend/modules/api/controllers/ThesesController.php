<?php

namespace app\modules\api\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rest\ActiveController;

class ThesesController extends ActiveController
{
    public $modelClass = 'app\models\Theses';
    
    public function behaviors1()
    {
        // var_dump(Yii::$app->user->isGuest); die();
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                // 'only' => ['index', 'view'],
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
            /*'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }
    
    public function actions1()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
        /*return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];*/
    }

    /*public function actionCreate()
    {
        print_r(Yii::$app->request->post());
        // return $this->render('index');
    }*/
}
