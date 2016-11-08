<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Query;

/**
 * UserSearch represents the model behind the search form about `\common\models\User`.
 */
class UserSearch extends User
{
    public $province_name;
    public $city_name;
    public function rules()
    {
        return [
            [['id', 'gender', 'province', 'city', 'source', 'status'], 'integer'],
            [['phone_number', 'email', 'nickname', 'avatar', 'description', 'open_id', 'auth_key', 'password_hash', 'password_reset_token', 'access_token', 'created_at', 'updated_at', 'province_name', 'city_name'], 'safe'],
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
        $query = User::find();

        // add conditions that should always apply here
        $query->joinWith(['provinces']);
        $query->joinWith(['citys']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        // 设置排序规则
        $dataProvider->sort->attributes['province_name'] = [
            'asc' => ['provinces.name' => SORT_ASC],
            'desc' => ['provinces.name' => SORT_DESC]
        ];
        $dataProvider->sort->attributes['city_name'] = [
            'asc' => ['citys.name' => SORT_ASC],
            'desc' => ['citys.name' => SORT_DESC]
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
            'gender' => $this->gender,
            //'province' => $this->province,
            //'city' => $this->city,
            'source' => $this->source,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
            $this->tableName() . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'open_id', $this->open_id])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'provinces.name', $this->province_name])
            ->andFilterWhere(['like', 'citys.name', $this->city_name]);

        $query = Query::andWhereTime($query, $this);

        return $dataProvider;
    }
}
