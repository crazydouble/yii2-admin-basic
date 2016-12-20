<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

/**
 * Initializes RBAC tables
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.0
 */
class m140506_102106_rbac_init extends \yii\db\Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }

    /**
     * @return bool
     */
    protected function isMSSQL()
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($authManager->ruleTable, [
            'name' => $this->string(64)->notNull()->comment('名称'),
            'data' => $this->text()->comment('数据'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('状态'),
            'PRIMARY KEY (name)',
        ], $tableOptions);

        $this->createTable($authManager->itemTable, [
            'name' => $this->string(64)->notNull()->unique()->comment('名称'),
            'type' => $this->integer()->notNull()->comment('类型'),
            'description' => $this->string(64)->notNull()->unique()->comment('描述'),
            'rule_name' => $this->string(64)->comment('规则名称'),
            'data' => $this->text()->comment('数据'),

            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('状态'),

            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . $authManager->ruleTable . ' (name)'.
                ($this->isMSSQL() ? '' : ' ON DELETE SET NULL ON UPDATE CASCADE'),
        ], $tableOptions);
        $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');

        $this->createTable($authManager->itemChildTable, [
            'parent' => $this->string(64)->notNull()->comment('父类'),
            'child' => $this->string(64)->notNull()->comment('子类'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('状态'),
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . $authManager->itemTable . ' (name)'.
                ($this->isMSSQL() ? '' : ' ON DELETE CASCADE ON UPDATE CASCADE'),
            'FOREIGN KEY (child) REFERENCES ' . $authManager->itemTable . ' (name)'.
                ($this->isMSSQL() ? '' : ' ON DELETE CASCADE ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable($authManager->assignmentTable, [
            'item_name' => $this->string(64)->notNull()->comment('角色'),
            'user_id' => $this->string(64)->notNull()->comment('管理员'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('状态'),
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        if ($this->isMSSQL()) {
            $this->execute("CREATE TRIGGER dbo.trigger_auth_item_child
            ON dbo.{$authManager->itemTable}
            INSTEAD OF DELETE, UPDATE
            AS
            DECLARE @old_name VARCHAR (64) = (SELECT name FROM deleted)
            DECLARE @new_name VARCHAR (64) = (SELECT name FROM inserted)
            BEGIN
            IF COLUMNS_UPDATED() > 0
                BEGIN
                    IF @old_name <> @new_name
                    BEGIN
                        ALTER TABLE auth_item_child NOCHECK CONSTRAINT FK__auth_item__child;
                        UPDATE auth_item_child SET child = @new_name WHERE child = @old_name;
                    END
                UPDATE auth_item
                SET name = (SELECT name FROM inserted),
                type = (SELECT type FROM inserted),
                description = (SELECT description FROM inserted),
                rule_name = (SELECT rule_name FROM inserted),
                data = (SELECT data FROM inserted),
                created_at = (SELECT created_at FROM inserted),
                updated_at = (SELECT updated_at FROM inserted)
                WHERE name IN (SELECT name FROM deleted)
                IF @old_name <> @new_name
                    BEGIN
                        ALTER TABLE auth_item_child CHECK CONSTRAINT FK__auth_item__child;
                    END
                END
                ELSE
                    BEGIN
                        DELETE FROM dbo.{$authManager->itemChildTable} WHERE parent IN (SELECT name FROM deleted) OR child IN (SELECT name FROM deleted);
                        DELETE FROM dbo.{$authManager->itemTable} WHERE name IN (SELECT name FROM deleted);
                    END
            END;");
        }
        //添加默认数据
        $this->execute($this->getItem());
        $this->execute($this->getItemChild());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        if ($this->isMSSQL()) {
            $this->execute('DROP TRIGGER dbo.trigger_auth_item_child;');
        }

        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
    }
    private function getItem()
    {
        return "INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`, `status`) VALUES
        ('administrator', 1, '超级管理员', NULL, NULL, 1481705512, 1481705512, 10),

        ('site', 2, '首页', NULL, NULL, 1481772377, 1481772377, 10),

        ('user', 2, '用户列表', NULL, NULL, 1481772386, 1481772386, 10),
        ('user/create', 2, '创建用户', NULL, NULL, 1481772919, 1481772919, 10),
        ('user/view', 2, '查看用户', NULL, NULL, 1481772933, 1481772933, 10),
        ('user/update', 2, '更新用户', NULL, NULL, 1481772933, 1481772933, 10),
        ('user/delete', 2, '删除用户', NULL, NULL, 1481792000, 1481792000, 10),

        ('admin', 2, '管理员列表', NULL, NULL, 1481772399, 1481772399, 10),
        ('admin/create', 2, '创建管理员', NULL, NULL, 1481772946, 1481772946, 10),
        ('admin/view', 2, '查看管理员', NULL, NULL, 1481772933, 1481772933, 10),
        ('admin/update', 2, '更新管理员', NULL, NULL, 1481792072, 1481792072, 10),
        ('admin/delete', 2, '删除管理员', NULL, NULL, 1481792124, 1481792124, 10),

        ('menu', 2, '菜单列表', NULL, NULL, 1481772410, 1481772410, 10),
        ('menu/create', 2, '创建菜单', NULL, NULL, 1481772946, 1481772946, 10),
        ('menu/view', 2, '查看菜单', NULL, NULL, 1481772933, 1481772933, 10),
        ('menu/update', 2, '更新菜单', NULL, NULL, 1481792072, 1481792072, 10),
        ('menu/delete', 2, '删除菜单', NULL, NULL, 1481792124, 1481792124, 10),
        
        ('permission', 2, '权限列表', NULL, NULL, 1481772444, 1481772444, 10),
        ('permission/create', 2, '创建权限', NULL, NULL, 1481772946, 1481772946, 10),
        ('permission/view', 2, '查看权限', NULL, NULL, 1481772933, 1481772933, 10),
        ('permission/update', 2, '更新权限', NULL, NULL, 1481792072, 1481792072, 10),
        ('permission/delete', 2, '删除权限', NULL, NULL, 1481792124, 1481792124, 10),

        ('role', 2, '角色列表', NULL, NULL, 1481791792, 1481791792, 10),
        ('role/create', 2, '创建角色', NULL, NULL, 1481772946, 1481772946, 10),
        ('role/view', 2, '查看角色', NULL, NULL, 1481772933, 1481772933, 10),
        ('role/update', 2, '更新角色', NULL, NULL, 1481792072, 1481792072, 10),
        ('role/delete', 2, '删除角色', NULL, NULL, 1481792124, 1481792124, 10),

        ('admin-log', 2, '操作日志', NULL, NULL, 1481791822, 1481791822, 10),
        ('admin-log/view', 2, '查看日志', NULL, NULL, 1481792072, 1481792072, 10);";
    }

    private function getItemChild()
    {
        return "INSERT INTO `auth_item_child` (`parent`, `child`, `status`) VALUES
        ('administrator', 'admin', 10),
        ('administrator', 'admin-log', 10),
        ('administrator', 'admin-log/view', 10),
        ('administrator', 'admin/create', 10),
        ('administrator', 'admin/delete', 10),
        ('administrator', 'admin/update', 10),
        ('administrator', 'admin/view', 10),
        ('administrator', 'menu', 10),
        ('administrator', 'menu/create', 10),
        ('administrator', 'menu/delete', 10),
        ('administrator', 'menu/update', 10),
        ('administrator', 'menu/view', 10),
        ('administrator', 'permission', 10),
        ('administrator', 'permission/create', 10),
        ('administrator', 'permission/delete', 10),
        ('administrator', 'permission/update', 10),
        ('administrator', 'permission/view', 10),
        ('administrator', 'role', 10),
        ('administrator', 'role/create', 10),
        ('administrator', 'role/delete', 10),
        ('administrator', 'role/update', 10),
        ('administrator', 'role/view', 10),
        ('administrator', 'site', 10),
        ('administrator', 'user', 10),
        ('administrator', 'user/create', 10),
        ('administrator', 'user/delete', 10),
        ('administrator', 'user/update', 10),
        ('administrator', 'user/view', 10);";
    }
}