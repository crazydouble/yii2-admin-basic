<?php

use yii\db\Migration;
use yii\helpers\Console;

class m160421_095304_create_admin extends Migration
{
    public function safeUp()
    {
        $this->createAdmin();
    }

    /**
     * 创建创始人数据
     */
    public function createAdmin()
    {
        Console::output("\n请先创建管理员账户:   ");

        $admin = $this->saveAdminData(new \backend\models\Admin(['scenario' => 'create']));

        $admin ? $admin->id : 1; // 用户创建成功则指定用户id,否则指定id为1的用户为创始人.

        Console::output("创始人创建" . ($admin ? '成功' : "失败,请手动创建创始人用户\n"));
    }

    /**
     * 管理员创建交互
     * @param $_model
     * @return mixed
     */
    private function saveAdminData($_model)
    {
        $model = clone $_model;
        $model->role = Console::prompt('请输入管理员角色', ['default' => 'administrator']);
        $model->username = Console::prompt('请输入管理员用户名', ['default' => 'admin']);
        $model->password_hash = Console::prompt('请输入密码', ['default' => '123456']);
        $model->nickname = Console::prompt('请输入昵称', ['default' => '超级管理员']);
        // 需根据项目修改
        $model->email = Console::prompt('请输入邮箱', ['default' => 'crazydouble@sina.com']);
        if (!$model->signup()) {
            Console::output(Console::ansiFormat("\n输入数据验证错误:", [Console::FG_RED]));
            foreach ($model->getErrors() as $value) {
                Console::output(Console::ansiFormat(implode("\n", $value), [Console::FG_RED]));
            }
            if (Console::confirm("\n是否重新创建管理员账户:")) {
                $model = $this->saveAdminData($_model);
            }
        }
        return $model;
    }
}
