<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use components\Oss;
use common\models\City;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $phone_number
 * @property string $email
 * @property string $nickname
 * @property integer $gender
 * @property integer $province
 * @property integer $city
 * @property string $avatar
 * @property string $description
 * @property string $open_id
 * @property integer $source
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * $propetry string $access_token
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class User extends ActiveRecord implements IdentityInterface
{
    const GENDER_MALE = 10;
    const GENDER_FEMALE = 20;

    const SOURCE_PHONE = 10;
    const SOURCE_QQ = 20;
    const SOURCE_WEIXIN = 30;
    const SOURCE_WEIBO = 40;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const AUTH_KEY = '134679';

    public $phone_verify_code;
    public $username;
    public $password;
    public $verify_password;

    public static function tableName()
    {
        return '{{%user}}';
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
            //公共处理
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                $this->avatar = Oss::oauthUpload($this->avatar, 'user', 'avatar');
            }else{
                $this->avatar = Oss::upload($this, 'user', 'avatar');
            }
            //新数据插入
            if ($this->isNewRecord) {
                if ($this->password_hash) {
                    $this->setPassword($this->password_hash);
                }
                $this->generateAuthKey();
            }else{
                //数据更新
                if ($this->password_hash != $this->getOldAttribute('password_hash')) {
                    $this->setPassword($this->password_hash);
                }
                if ($this->avatar && $this->avatar != $this->getOldAttribute('avatar')) {
                    OSS::delFile('user', 'avatar', $this->getOldAttribute('avatar'));
                }else{
                    $this->avatar = $this->getOldAttribute('avatar');
                }
                //修改绑定手机时修改对应昵称
                if($this->phone_number != $this->getOldAttribute('phone_number') && $this->nickname == $this->getOldAttribute('phone_number')){
                    $this->nickname = $this->phone_number;
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
            ['nickname','required'],
            //普通注册
            [['phone_number', 'password_hash'],'required','on' => ['create','alidayu','update']],
            //手机验证码
            ['phone_verify_code','required','on' => ['alidayu']],
            ['phone_verify_code','getPhoneCodeRecord','on' => ['alidayu']],
            //第三方注册
            ['open_id','required','on' => ['oauth']],
            //绑定邮箱
            ['email','required','on' => ['bind']],
            //字段规范
            [['phone_number'], 'unique', 'message' => '该手机号已存在。'],
            [['email'], 'unique', 'message' => '该邮箱已存在。'],
            [['open_id', 'password_reset_token', 'access_token'], 'unique'],
            ['email','email'],
            ['phone_number','match','pattern'=>'/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/','message'=>'请填写有效手机号。'],
            [['password_hash'],'string', 'min' => 6],

            ['auth_key', 'default', 'value' => self::AUTH_KEY], 
            ['source', 'default', 'value' => self::SOURCE_PHONE],
            ['status', 'default', 'value' => self::STATUS_ACTIVE], 

            ['gender', 'in', 'range' => [self::GENDER_MALE, self::GENDER_FEMALE]],
            ['source', 'in', 'range' => [self::SOURCE_PHONE, self::SOURCE_QQ, self::SOURCE_WEIXIN, self::SOURCE_WEIBO]],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            //字段类型
            [['gender', 'province', 'city', 'source', 'status', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['phone_number'], 'string', 'max' => 11],
            [['email', 'nickname', 'auth_key', 'access_token'], 'string', 'max' => 32],
            [['open_id', 'password_hash', 'password_reset_token'], 'string', 'max' => 100],
            [['username'],'safe'],
            ['avatar', 'image', 
                'extensions' => 'jpg,jpeg,png',
                'maxSize' => 1024*500,
                'minWidth' => 150,
                'minHeight' => 150,
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone_number' => Yii::t('app', '手机号'),
            'phone_verify_code' => Yii::t('app', '验证码'),
            'email' => Yii::t('app', '邮箱'),
            'nickname' => Yii::t('app', '昵称'),
            'gender' => Yii::t('app', '性别'),
            'province' => Yii::t('app', '省'),
            'city' => Yii::t('app', '市'),
            'avatar' => Yii::t('app', '个人头像'),
            'description' => Yii::t('app', '个人简介'),
            'open_id' => Yii::t('app', 'OpenID'),
            'source' => Yii::t('app', '来源'),
            'auth_key' => Yii::t('app', '认证密钥'),
            'password_hash' => Yii::t('app', '密码'),
            'password_reset_token' => Yii::t('app', '密码重置Token'),
            'access_token' => Yii::t('app', '访问令牌'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'status' => Yii::t('app', '状态'),
        ];
    }


    public function signup()
    {
        //手机注册时,昵称为手机号
        if($this->phone_number && !$this->nickname){
            $this->nickname = $this->phone_number;
        }
        if ($this->validate()) {
            if($this->save()){
                return $this;
            }
        }
        return false;
    }

    public function oauthSignup($id, $openid, $userInfo)
    {
        $this->open_id = (string)$openid;
        switch ($id) {
            case 'qq':
                $this->nickname = $userInfo['nickname'];
                $this->avatar = $userInfo['figureurl_qq_2'];
                $this->source = User::SOURCE_QQ;
                break;
            
            case 'weixin':
                $this->source = User::SOURCE_WEIXIN;
                break;

            case 'weibo':
                $this->nickname = $userInfo['screen_name'];
                $this->avatar = $userInfo['avatar_large'];
                $this->source = User::SOURCE_WEIBO;
                break;
        }
        
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
     * 生成access_token RESTFUL认证使用
     */
    public function generateAccessToken()  
    {  
        $this->access_token = Yii::$app->security->generateRandomString();  
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
     * 根据OPEN_ID查询用户
     *
     * @param string $open_id
     * @return static|null
     */
    public static function findByOpenId($open_id)
    {
        return static::findOne(['open_id' => $open_id]);
    }

    /**
     * 根据手机号查询用户
     *
     * @param string $phone_number
     * @return static|null
     */
    public static function findByPhoneNumber($phone_number)
    {
        return static::findOne(['phone_number' => $phone_number, 'status' => self::STATUS_ACTIVE]);
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

    public static function getValues($field, $value = false)
    {
        $values = [
            'gender' => [
                self::GENDER_MALE => Yii::t('common', 'Male'),
                self::GENDER_FEMALE => Yii::t('common', 'Female'),
            ],
            'source' => [
                self::SOURCE_PHONE => Yii::t('common', 'Phone'),
                self::SOURCE_QQ => Yii::t('common', 'Qq'),
                self::SOURCE_WEIXIN => Yii::t('common', 'Wexin'),
                self::SOURCE_WEIBO => Yii::t('common', 'Weibo'),
            ],
            'status' => [
                self::STATUS_DELETED => Yii::t('common', 'Deleted'),
                self::STATUS_ACTIVE => Yii::t('common', 'Active'),
            ]
        ];

        return $value !== false ? ArrayHelper::getValue($values[$field], $value) : $values[$field];
    }

    //手机验证码验证
    public function getPhoneCodeRecord($attribute)
    {
        if($this->phone_number && $this->phone_verify_code) {
            $c = new \TopClient;
            $c->appkey = Yii::$app->params['alidayu']['appkey'];
            $c->secretKey = Yii::$app->params['alidayu']['secretKey'];
            $req = new \AlibabaAliqinFcSmsNumQueryRequest;
            //$req->setBizId("1234^1234");
            $req->setRecNum($this->phone_number);
            $req->setQueryDate(date('Ymd'));
            $req->setCurrentPage('1');
            $req->setPageSize('50');
            $resp = $c->execute($req);
            $obj = $resp->values;
            if($obj){
                foreach ($obj->fc_partner_sms_detail_dto as $value) {
                    if($value->extend == $this->phone_verify_code && $value->sms_status == 3){
                        $second = floor(strtotime(date('Y-m-d H:i:s')) - strtotime($value->sms_receiver_time));
                        if($second <= 300){
                            return;
                        }
                    }
                }
            }
            $this->addError('phone_verify_code', '无效的验证码');
        }
    }
    public function getProvinces()
    {
        return $this->hasOne(City::className(), ['id' => 'province'])->alias('provinces');
    }
    public function getCitys()
    {
        return $this->hasOne(City::className(), ['id' => 'city'])->alias('citys');
    }
    static public function getNickname(){
        $nickname = Yii::$app->user->identity->nickname;
        return (preg_match("/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/", $nickname)) ? substr_replace($nickname,'****',3,4) : $nickname;       
    }
    static public function getAvatar(){
        return (Yii::$app->user->identity->avatar) ? Oss::getUrl('user', 'avatar', Yii::$app->user->identity->avatar)."@1e_1c_0o_0l_256h_256w_90q.src" : Yii::$app->request->baseUrl . '/assets/images/avatar.png';
    }
}