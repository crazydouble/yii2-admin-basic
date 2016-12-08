<?php

namespace backend\controllers;

use Yii;
use backend\models\Rbac;
use backend\models\RbacSearch;
use yii\web\NotFoundHttpException;

/**
 * PermissionController implements the CRUD actions for Rbac model.
 */
class PermissionController extends Controller
{
    /**
     * Lists all Rbac models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RbacSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Rbac::TYPE_PERMISSION);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rbac model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Rbac model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rbac();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $auth = Yii::$app->authManager;

            $permission = $auth->createPermission($model->name);
            $permission->description = $model->description;
            
            if($auth->add($permission)){
                return $this->redirect(['view', 'id' => $model->name]);
            }
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Rbac model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Rbac model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->updateStatus()){
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Rbac model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Rbac the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rbac::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
