<?php

use yii\db\Migration;

class m160517_081005_user extends Migration
{
    const TBL_NAME = '{{%user}}';

    /**
     * 创建表选项
     * @var string
     */
    public $tableOptions = null;

    /**
     * 是否创建为事务表
     * @var bool
     */
    public $useTransaction = true;
    
    public function safeUp()
    {
        //Mysql 表选项
        if ($this->db->driverName === 'mysql') {
            $engine = $this->useTransaction ? 'InnoDB' : 'MyISAM';
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=' . $engine;
        }

        $this->execute($this->delTable());
        //创建用户表
        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),  
            'phone_number' => $this->string(11)->comment('手机号'),
            'email' => $this->string(32)->comment('邮箱'),
            'nickname' => $this->string(32)->notNull()->comment('昵称'),
            'gender' => $this->smallInteger()->comment('性别'),
            'province' => $this->smallInteger()->comment('省'),
            'city' => $this->smallInteger()->comment('市'),
            'avatar' => $this->string(200)->comment('个人头像'),
            'description' => $this->text()->comment('个人简介'),
            'open_id' => $this->string(100)->comment('OpenID'),
            'source' => $this->smallInteger()->notNull()->defaultValue(10)->comment('来源'),
            
            'auth_key' => $this->string(32)->notNull()->comment('认证密钥'),
            'password_hash' => $this->string(100)->comment('密码'),
            'password_reset_token' => $this->string(100)->unique()->comment('密码重置Token'),
            'access_token' => $this->string(32)->unique()->comment('访问令牌'),

            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('状态'),
        ], $this->tableOptions);
    }

    private function delTable()
    {
        return "DROP TABLE IF EXISTS ".self::TBL_NAME.";";
    }

    public function safeDown()
    {
        $this->dropTable(self::TBL_NAME);
    }
}
