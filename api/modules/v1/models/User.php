<?php

namespace api\modules\v1\models;

use components\Oss;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;
//use backend\models\Admin;
//use common\models\City;

class User extends \common\models\User implements Linkable
{

    public function fields()
	{
	    $fields = parent::fields();

	    $fields['avatar'] = function () {
            return empty($this->avatar) ? '' : Oss::getUrl('user', 'avatar', $this->avatar);
        };

	    // 删除一些包含敏感信息的字段
	    unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);

	    return $fields;
	}

	public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
        ];
    }

	/*
	public function getAdmin()
    {
        // 客户和订单通过 Order.customer_id -> id 关联建立一对多关系
        return $this->hasMany(Admin::className(), ['id' => 'id']);
    }

	public function getCitys()
    {
        // 客户和订单通过 Order.customer_id -> id 关联建立一对多关系
        return $this->hasMany(City::className(), ['id' => 'id']);
    }
	*/
	
    /*
	public function extraFields()
    {
        return ['admin','citys'];
    }
    */
}
