<?php

namespace common\models;

use Yii;
use backend\models\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class City extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%city}}';
    }

    public function rules()
    {
        return [
            [['pid', 'name'], 'required'],
            [['pid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pid' => Yii::t('app', '父ID'),
            'name' => Yii::t('app', '所在地'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', '状态'),
        ];
    }

    public static function getCityList($pid)
    {
        $model = static::findAll(['pid' => $pid, 'status' => self::STATUS_ACTIVE]);
        return ArrayHelper::map($model, 'id', 'name');
    }
}
