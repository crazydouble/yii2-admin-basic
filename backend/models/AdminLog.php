<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use backend\models\Admin;

/**
 * This is the model class for table "{{%admin_log}}".
 *
 * @property integer $id
 * @property integer $admin_id
 * @property string $admin_ip
 * @property string $admin_agent
 * @property string $controller
 * @property string $action
 * @property integer $tid
 * @property string $details
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class AdminLog extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }

    public function behaviors()
    {
        return [
            //自动填充指定的属性与当前时间戳
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //特殊需求
            [['admin_id', 'admin_ip', 'admin_agent', 'controller', 'action', 'tid', 'created_at', 'updated_at'], 'required'],
            //字段规范
            ['status', 'default', 'value' => self::STATUS_ACTIVE], 
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            //字段类型
            [['admin_id', 'tid', 'created_at', 'updated_at', 'status'], 'integer'],
            [['details'], 'string'],
            [['admin_ip', 'admin_agent', 'controller', 'action'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'admin_id' => Yii::t('app', '管理员'),
            'admin_ip' => Yii::t('app', 'IP'),
            'admin_agent' => Yii::t('app', '浏览器'),
            'controller' => Yii::t('app', '控制器'),
            'action' => Yii::t('app', '动作'),
            'tid' => Yii::t('app', '表ID'),
            'details' => Yii::t('app', '详情'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', '状态'),
        ];
    }

    public static function saveLog($model){
        if(Yii::$app->controller->module->id == 'app-backend'){
            $log = new self;

            $log->admin_id = Yii::$app->user->identity->id;
            $log->admin_ip = Yii::$app->request->userIP;
            $headers = Yii::$app->request->headers;
            if ($headers->has('User-Agent')) {
                $log->admin_agent = $headers->get('User-Agent');
            }

            $log->controller = Yii::$app->controller->id;
            $log->action = Yii::$app->controller->action->id;
            $log->tid = $model->attributes['id'];

            foreach ($model->attributes as $key => $value) {
                $log->details .= $key .' : '. $value . "\r\n";
            }
            $log->save(false);
        }
    }

    /**
     * @param bool $status
     * @return array|mixed
     */
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

    public function getAdmins()
    {
        return $this->hasOne(Admin::className(), ['id' => 'admin_id']);
    }
}
