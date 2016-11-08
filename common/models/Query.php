<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Format;

class Query extends Model
{
    static public function concatValue($table, $value, $reveal_all = false, $start = 0, $len = 50){
        $model = $table::findAll(['id' => Format::explodeValue($value), 'status' => $table::STATUS_ACTIVE]);
        foreach ($model as $value) {
            $name[] = $value->name;
        }
        $name = Format::implodeValue($name);
        return Format::mb_substr($name, $reveal_all, $start, $len);
    }

    static public function searchConcatValue($data, $search, $table, $field){
        foreach ($data as $value) {
            $name_str = '';
            $name = [];
            $model = $table::findAll(['id' => explode(',', $value->$field)]);
            foreach ($model as $v) {
                $name[] = $v->name;
            }
            $name_str = Format::implodeValue($name);
            if(strstr($name_str, $search)){
                $ids[] = $value->id;
            }
        }
        return $ids;
    }
    
	static public function andWhereTime($query, $model)
    {
        if ($model->created_at) {
            $query->andWhere(self::whereTimeSql($model, 'created_at'));
        }
        if ($model->updated_at) {
            $query->andWhere(self::whereTimeSql($model, 'updated_at'));
        }
        return $query;
	}

    static private function whereTimeSql($model, $field)
    {
        $start = strtotime($model->$field);

        $end = $start + 24 * 3600;
        
        return $model->tableName() . ".{$field} >= {$start} AND ". $model->tableName() . ".{$field} <= {$end}";
    }
    static public function concatErrors($model)
    {
        foreach ($model->getErrors() as $value) {
            $message .= $value[0];
        }
        return $message;
    }
}
