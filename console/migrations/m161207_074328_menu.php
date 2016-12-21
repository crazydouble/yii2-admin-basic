<?php

use yii\db\Migration;

class m161207_074328_menu extends Migration
{
    const TBL_NAME = '{{%menu}}';

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
        //创建菜单
        $this->createTable(self::TBL_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'name' => $this->string(32)->notNull()->unique()->comment('名称'),
            'parent' => $this->integer()->notNull()->defaultValue(0)->comment('父类'),
            'route' => $this->string(32)->comment('路由'),
            'icon' => $this->string(32)->comment('图标'),
            'priority' => $this->integer()->notNull()->defaultValue(0)->comment('优先级'),

            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('状态'),
        ], $this->tableOptions);
        //添加默认菜单数据
        $this->execute($this->getMenuSql());
    }

    private function delTable()
    {
        return "DROP TABLE IF EXISTS ".self::TBL_NAME.";";
    }

    public function safeDown()
    {
        $this->dropTable(self::TBL_NAME);
    }
    
    private function getMenuSql()
    {
        return "INSERT INTO `menu` (`id`, `name`, `parent`, `route`, `icon`, `priority`, `created_at`, `updated_at`, `status`) VALUES
        (1, '仪表盘', 0, NULL, 'fa-tachometer', 1, 1481528304, 1481528304, 10),
        (2, '首页', 1, 'site', NULL, 1, 1481528378, 1481528378, 10),

        (3, '用户管理', 0, NULL, 'fa-user', 2, 1481528338, 1481528338, 10),
        (4, '用户列表', 3, 'user', NULL, 1, 1481529190, 1481529190, 10),

        (5, '系统管理', 0, NULL, 'fa-cog', 3, 1481529217, 1481529217, 10),
        (6, '管理员列表', 5, 'admin', NULL, 1, 1481529653, 1481529653, 10),
        (7, '菜单列表', 5, 'menu', NULL, 2, 1481529796, 1481529796, 10),
        (8, '权限列表', 5, 'permission', NULL, 3, 1481529867, 1481529867, 10),
        (9, '角色列表', 5, 'role', NULL, 4, 1481529888, 1481529888, 10),
        (10, '操作日志', 5, 'admin-log', NULL, 5, 1481529912, 1481529912, 10)";
    }
}
