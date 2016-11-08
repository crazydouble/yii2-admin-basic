<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AdminLog;
use common\models\Query;

/**
 * AdminLogSearch represents the model behind the search form about `backend\models\AdminLog`.
 */
class AdminLogSearch extends AdminLog
{
    public $admin_name;
    public function rules()
    {
        return [
            [['id', 'admin_id', 'status'], 'integer'],
            [['admin_ip', 'admin_agent', 'controller', 'action', 'details', 'created_at', 'updated_at', 'admin_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AdminLog::find();

        // add conditions that should always apply here
        $query->joinWith(['admins']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        // 设置排序规则
        $dataProvider->sort->attributes['admin_name'] = [
            'asc' => ['admin.nickname' => SORT_ASC],
            'desc' => ['admin.nickname' => SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            $this->tableName() . '.id' => $this->id,
            'admin_id' => $this->admin_id,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
            $this->tableName() . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'admin_ip', $this->admin_ip])
            ->andFilterWhere(['like', 'admin_agent', $this->admin_agent])
            ->andFilterWhere(['like', 'controller', $this->controller])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'details', $this->details])
            ->andFilterWhere(['like', 'admin.nickname', $this->admin_name]);

        $query = Query::andWhereTime($query, $this);

        return $dataProvider;
    }
}
