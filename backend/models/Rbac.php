<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%auth_item}}".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Rbac extends ActiveRecord
{
    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;
    public $permission;

    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    public function rules()
    {
        return [
            //特殊需求
            [['name', 'description'], 'required'],
            [['name', 'description'], 'unique'],
            [['permission'], 'required', 'on' => 'role'],
            //字段规范
            ['status', 'default', 'value' => self::STATUS_ACTIVE], 
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            //字段类型
            [['type', 'created_at', 'updated_at', 'status'], 'integer'],
            [['data'], 'string'],
            [['name', 'description', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', '名称'),
            'type' => Yii::t('app', '类型'),
            'permission' => Yii::t('app', '权限'),
            'description' => Yii::t('app', '描述'),
            'rule_name' => Yii::t('app', '规则名称'),
            'data' => Yii::t('app', '数据'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', '状态'),
        ];
    }

    /**
     * 获取权限列表
     */
    public static function getPermissionList()
    {
        $model = static::findAll(['type' => 2 , 'status' => self::STATUS_ACTIVE]);
        return ArrayHelper::map($model, 'name', 'description');
    }
}
