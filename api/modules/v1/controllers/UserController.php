<?php
namespace api\modules\v1\controllers;

use yii\data\ActiveDataProvider;

class UserController extends MainController
{
    public $modelClass = 'api\modules\v1\models\user';
	
	public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $query = $modelClass::find();
        return new ActiveDataProvider([
            'query' => $query
        ]);
    }
}