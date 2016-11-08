<?php

namespace common\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $phone_number;
    public $password_hash;
    public $rememberMe = true;

    private $_user;

    public function rules()
    {
        return [
            [['phone_number', 'password_hash'], 'required'],
            ['rememberMe', 'boolean'],
            ['password_hash', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone_number' => '手机号',
            'password_hash' => '密码',
            'rememberMe' => '记住密码'
        ];
    }
    /**
     * 验证密码
     *
     * @param string $attribute 目前验证的属性
     * @param array $params 额外的名称-值对给定的规则
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password_hash)) {
                $this->addError($attribute, '账号或密码不正确');
            }
        }
    }

    /**
     * 使用提供的用户用户名和密码登录
     *
     * @return boolean 用户是否登录成功
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * 查询用户 [[phone_number]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByPhoneNumber($this->phone_number);
        }

        return $this->_user;
    }
}
