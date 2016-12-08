<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $nickname
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const AUTH_KEY = '134679';

    public static function tableName()
    {
        return '{{%admin}}';
    }

    public function behaviors()
    {
        return [
            //自动填充指定的属性与当前时间戳
            TimestampBehavior::className(),
        ];
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->setPassword($this->password_hash);
                $this->generateAuthKey();
            }else{
                if($this->password_hash != $this->getOldAttribute('password_hash')){
                    $this->setPassword($this->password_hash);
                }
            }
            
            \backend\models\AdminLog::saveLog($this);

            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            //特殊需求
            [['username', 'password_hash'],'required'],
            [['nickname', 'email'], 'required','on' => ['create','update']],
            [['username', 'nickname', 'email', 'password_reset_token'], 'unique','on' => ['create','update']],
            //字段规范
            ['username', 'match', 'pattern' => '/^[A-Za-z0-9_-]+$/','message' => '账号只能输入数字、字母 下划线'], 
            ['username','string', 'min' => 3],
            ['password_hash','string', 'min' => 6],
            ['email','email'],
            ['auth_key', 'default', 'value' => self::AUTH_KEY], 
            ['status', 'default', 'value' => self::STATUS_ACTIVE], 
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            //字段类型
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'nickname', 'email', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', '账号'),
            'nickname' => Yii::t('app', '昵称'),
            'email' => Yii::t('app', '邮箱'),
            'auth_key' => Yii::t('app', '认证密钥'),
            'password_hash' => Yii::t('app', '密码'),
            'password_reset_token' => Yii::t('app', '密码重置Token'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', '状态'),
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            if($this->save()){
                return $this;
            }
        }
        return false;
    }

    /**
     * 根据ID查询用户
     *
     * @param string|integer $id 被查询的ID
     * @return IdentityInterface|null 通过ID匹配到的用户对象
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * 根据 token 查询用户 RESTFUL认证使用
     *
     * @param string $token 被查询的 token
     * @return IdentityInterface|null 通过 token 得到的用户对象
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * 根据用户名查询用户
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * 根据 token 查询用户
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * 判断 token 是否有效
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @return int|string 当前用户ID
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string 当前用户的（cookie）认证密钥
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * 验证登录密钥
     * 
     * @param string $authKey
     * @return boolean 如果当前用户身份验证的密钥是有效的
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 密码验证
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * 生成并设置密码
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 生成 记住我 的认证密钥
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * 生成 密码重置token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * 删除 密码重置token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
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
}
