<?php

use yii\db\Migration;

class m160420_074708_admin extends Migration
{
    const TBL_NAME = '{{%admin}}';

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
        //创建管理员表
        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),  
            'username' => $this->string(32)->notNull()->unique()->comment('管理员账号'),
            'nickname' => $this->string(32)->notNull()->unique()->comment('昵称'),
            'email' => $this->string(32)->notNull()->unique()->comment('邮箱'),
            'auth_key' => $this->string(32)->notNull()->comment('认证密钥'),
            'password_hash' => $this->string(100)->notNull()->comment('密码'),
            'password_reset_token' => $this->string(100)->unique()->comment('密码重置Token'),

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
