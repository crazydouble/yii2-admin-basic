<?php

use yii\db\Migration;

class m160722_071858_admin_log extends Migration
{
    const TBL_NAME = '{{%admin_log}}';

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
        //创建管理员日志
        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'admin_id' => $this->integer()->notNull()->comment('管理员ID'),
            'admin_ip' => $this->string(200)->notNull()->comment('管理员IP'),
            'admin_agent' => $this->string(200)->notNull()->comment('管理员浏览器'),
            'controller' => $this->string(200)->notNull()->comment('控制器'),
            'action' => $this->string(200)->notNull()->comment('动作'),
            'details' => $this->text()->comment('详情'),

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
