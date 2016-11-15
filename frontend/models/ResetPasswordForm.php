<?php
namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;


/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $password_hash;
    public $verify_password;

    private $_user;

    public function rules()
    {
        return [
            //修改密码
            [['password', 'password_hash', 'verify_password'], 'required'],
            [['password', 'password_hash', 'verify_password'],'string', 'min' => 6],
            ['password', 'validatePassword'],
            ['password_hash', 'compare', 'compareAttribute' => 'password', 'operator' => '!=', 'message' => '新密码不能与原密码相同'],
            ['verify_password', 'compare', 'compareAttribute' => 'password_hash', 'message' => '两次输入的新密码必须一致'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => '原密码',
            'password_hash' => '新密码',
            'verify_password' => '确认新密码'
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
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '原密码不正确');
            }
        }
    }

    /**
     * 查询用户
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $uid = Yii::$app->user->identity->id;
            $this->_user = User::findOne($uid);
        }

        return $this->_user;
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->password_hash = $this->password_hash;
            return $user->save();
        }
    }
}
