<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent
 * @property string $route
 * @property string $icon
 * @property integer $priority
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Menu extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%menu}}';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(empty($this->parent)){
                $this->route = NULL;
            }else{
                $this->icon = NULL;
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        \backend\models\AdminLog::saveLog($this);
        return true; 
    }
    
    public function rules()
    {
        return [
            //特殊需求
            [['name', 'parent', 'priority'], 'required'],
            [['name'], 'unique'],
            //字段规范
            ['status', 'default', 'value' => self::STATUS_ACTIVE], 
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            //字段类型
            [['parent', 'priority', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name', 'route', 'icon'], 'string', 'max' => 32], 
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '名称'),
            'parent' => Yii::t('app', '父类'),
            'route' => Yii::t('app', '路由'),
            'icon' => Yii::t('app', '图标'),
            'priority' => Yii::t('app', '优先级'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', '状态'),
        ];
    }

    public function getMenuList()
    {
        $model = static::menuList();
        $res = ['根'];
        $res += ArrayHelper::map($model, 'id', 'name');
        return $res;
    }

    public static function menu()
    {
        $menus = "<ul class='menu'>";
        foreach (static::menuList() as $value) {
            $menu = '';
            $status = false;
            //判断是否有子菜单权限
            foreach (static::menuList($value->id) as $v) {
                if(Yii::$app->user->can($v->route)){
                    $status = true;
                    $menu .= "<ul class='dropdown-menu'><li>";
                    $menu .= Html::a(
                      "<i class='fa fa-caret-right'></i>{$v->name}",
                      Yii::$app->urlManager->createUrl([$v->route])
                    );
                    $menu .= "</li></ul>";
                }
            }
            if($status == true){
                $menus .= "<li class='dropdown'>";
                $menus .= Html::a(
                    "<i class='fa {$value->icon}'></i>{$value->name}<b class='fa fa-plus dropdown-plus'></b>",
                    'javascript:void(0);',
                    ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']
                );
                $menus .= $menu;
                $menus .= '</li>';
            }
        }
        $menus .= "</ul>";
        return $menus;
    }

    public static function menuList($parent = 0)
    {
        return static::find()
            ->where(['parent' => $parent, 'status' => self::STATUS_ACTIVE])
            ->orderBy('id, priority')
            ->all();
    }
}
