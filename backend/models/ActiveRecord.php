<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class ActiveRecord extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public function behaviors()
    {
        return [
            //自动填充指定的属性与当前时间戳
            TimestampBehavior::className(),
        ];
    }
    
    public static function getValues($field, $value = false)
    {
        $values = [
            'status' => [
                self::STATUS_ACTIVE => Yii::t('common', 'Active'),
                self::STATUS_DELETED => Yii::t('common', 'Deleted'),
            ]
        ];

        return $value !== false ? ArrayHelper::getValue($values[$field], $value) : $values[$field];
    }
    
    public function updateStatus(){
        $this->status = ($this->status == self::STATUS_ACTIVE) ? self::STATUS_DELETED : self::STATUS_ACTIVE;
        if($this->save()){
            return true;
        }
        return false;
    }
}
