<?php

namespace app\modules\api\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use app\models\Check;
use app\models\Theses;

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

    public function actionSetcheck()
    {
        $_post = Yii::$app->request->post();
        $doc = $_post['doc'];
        if (!$doc) {
            return [];
        }
        $id = $_post['id'];
        if ($id) {
            $ch = Check::findOne($id);
            $ch->doc = $doc;
            $ch->body = Theses::_doc2body($doc);
        } else {
            $ch = new Check([
                'doc' => $doc,
                'body' => Theses::_doc2body($doc), 
                'created' => time(),
            ]);
        }
        $ch->save();
        return $ch;
    }

    public function actionGetcheck()
    {
        $_post = Yii::$app->request->post();
        $text = Check::findOne($_post['id']);
        return [
            'doc' => $text->doc,
        ];
    }
    
    public function actionGetall($check=true)
    {
        $_all = Theses::find()
            ->select('id, body')
            ->all();
        $all = [];
        foreach ($_all as $th) {
            if ($th->canCheck()) {
                $all[] = $th->id;
            }
        }
        return $all;
    }
}
