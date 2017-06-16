<?php

namespace app\controllers;

use Yii;
use app\models\Theses;
// use app\models\Plagiat;
use app\models\ThesesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ThesesController implements the CRUD actions for Theses model.
 */
class ThesesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'delete', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'delete', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Theses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThesesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Theses model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'plagiat' => $model->plagiat()
        ]);
    }
    
    public function actionField($id, $field)
    {
        $model = $this->findModel($id);
        return $this->render('field', [
            'model' => $model,
            'field' => $field,
        ]);
    }

    /**
     * Creates a new Theses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Theses();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Theses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionGetbody($id)
    {
        $model = $this->findModel($id);

        if ($model && $model->doc2body() && $model->save()) {
            Yii::$app->session->setFlash('success', 'Set body!');
        } else {
            Yii::$app->session->setFlash('danger', "Error #987! Cant doc2body or save (ThesesID: {$model->id})!");
        }
        return $this->redirect(['view', 'id' => $model->id]);
    }
    public function actionGetbodyall()
    {
        $all_theses = Theses::find()->all();
        foreach ($all_theses as $these) {
            if ($these->doc2body()) {
                $these->save();
            } else {
                Yii::$app->session->setFlash('danger', "Error #988! (these.id: {$these->id})");
            }
        }
        Yii::$app->session->setFlash('success', 'All DOCS set BODY!');
        return $this->redirect(['index']);
    }
    
    public function actionCheckall($force=false)
    {
        $all_theses = Theses::find()->all();
        foreach ($all_theses as $key => $these) {
            if ($these->canCheck()) {
                $res = $these->checkWithGTid($force);
            } else {
                if (Yii::$app->session->hasFlash('danger')) {
                    $err = Yii::$app->session->getFlash('danger') . ", {$these->id}";
                } else {
                    $err = "Error #988! These.id: {$these->id}";
                }
                Yii::$app->session->setFlash('danger', $err);
            }
        }
        Yii::$app->session->setFlash('success', 'Готово!');
        return $this->redirect(['index']);
    }
    
    public function actionCheckbyid($id, $force=false) {
        $these = Theses::findOne($id);
        $res = $these->checkThese($force);
        return $this->redirect(['view', 'id'=>$id]);
    }
    
    public function actionUa($text) {
        // $text1 = Theses::_engUaWold($text);
        $text1 = Theses::_engUaWolds([$text]);
        var_dump($text);
        var_dump($text1);
        die();
    }
    
    public function actionEnd1($text) {
        $text1 = Theses::_doc2body($text);
        var_dump($text1);
    }
    
    public function actionEnd($text) {
        // $completions = "/[ок|ій|я|нь|нь|ой|а]\s/iu";
        $completions = '/(e|ю|а|и|і|о|й|у|я|ою|ой|ий|ом|ів|ій|ня|их|ах|еї|ею|єю|ою|ая|ові|еві|ем|єм|нь|ок)\s/iu';
        
        // Строка, в которой заменяем
        $string = 'Це рядок, в якій потрібно відрізати у слів закінчення, які вказані в масиві закінчень';
        
        var_dump($string);
        // Удаляем окончания
        $string = preg_replace($completions, " ", "$string ");
        
        var_dump($string);
        
        $text1 = Theses::_dropBackWords($text);
        var_dump($text);
        var_dump($text1);
        die();
    }

    /**
     * Deletes an existing Theses model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        $model->deletePlagiat();
        
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Theses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Theses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Theses::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
