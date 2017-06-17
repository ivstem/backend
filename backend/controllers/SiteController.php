<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
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
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'doc' => [
                'class' => 'light\swagger\SwaggerAction',
                'restUrl' => \yii\helpers\Url::to(['/site/doc'], true),
            ],
            //The resultUrl action.
            'api' => [
                'class' => 'light\swagger\SwaggerApiAction',
                //The scan directories, you should use real path there.
                'scanDir' => [
                    // Yii::getAlias('@api/modules/v1/swagger'),
                    // Yii::getAlias('@api/modules/v1/controllers'),
                    Yii::getAlias('@app/modules/api/controllers'),
                    // Yii::getAlias('@api/modules/v1/models'),
                    // Yii::getAlias('@api/models'),
                ],
                //The security key
                'api_key' => 'balbalbal',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            '_login' => !Yii::$app->user->isGuest,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /*Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => '_login',
                'value' => 1,
                'httpOnly' => false,
            ]));*/
            Yii::$app->session->setFlash('_login', 1);
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionFromfront()
    {
        if (Yii::$app->user->isGuest) {
            // Yii::$app->response->cookies->remove('_login');
            return $this->redirect(['login']);
        } else {
            return $this->goHome();
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        // Yii::$app->response->cookies->remove('_login');
        
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
