<?php

namespace app\controllers;

use Yii;
use app\models\UsersGii;
use app\models\UsersGiiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersGiiController implements the CRUD actions for UsersGii model.
 */
class UsersGiiController extends Controller
{
    protected $dataViewId='gii';

    /**
     * {@inheritdoc}
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
        ];
    }

    /**
     * Lists all UsersGii models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersGiiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder=['surname'=>SORT_ASC,'first_name'=>SORT_ASC,'patronymic'=>SORT_ASC];
        $this->view->registerCssFile('css/blocks/buttons/text-button/text-button.css');
        $this->view->registerCssFile('css/blocks/view-changer/view-changer.css');
        $this->view->registerCssFile('css/admin.css');
        $this->view->registerJsFile('js/users-gii/UsersGiiController.js');
        $this->view->registerJsFile('js/users-gii/UsersGiiModel.js');
        $this->view->registerJsFile('js/users-gii/UsersGiiView.js');
        $this->view->registerJs('UsersGii.Model.dataViewId="' .str_replace('"','\"',$this->dataViewId) .'"');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsersGii model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UsersGii model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UsersGii();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UsersGii model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UsersGii model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UsersGii model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UsersGii the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsersGii::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
