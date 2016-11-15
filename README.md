Yii2 高级模板，后台配置
===============================

### 作者微博

[http://weibo.com/CraZyDoubLe](http://weibo.com/CraZyDoubLe)

### 简介
后台基于Yii2框架开发,拥有登录,用户管理,管理员管理,操作日志等通用功能.功能正在不断完善中~

### 功能

1. 基础功能：登录，登出，密码修改等常见的功能

2. 用户管理：包含前台用户的一些基本属性（手机号,邮箱,昵称,性别,省,市,头像,个人简介等）

3. 权限机制：角色、权限增删改查，以及给用户赋予角色权限

4. 操作日志：记录管理员所执行的所有操作（昵称,IP,浏览器,执行动作,修改项,修改时间等）

5. 二次开发：完全可以基于该系统做二次开发，开发一套适合自己的后台管理系统，节约权限控制以及部分基础功能开发的时间成本，后台系统开发的不二之选

###安装


#### 1. 初始化
---

```
./init
```

#### 2. 安装Composer 
---
不会用Composer,点[这里](http://docs.phpcomposer.com/)
```
composer install
```

#### 3. 导入表结构(migration)
---

需先修改数据库配置信息(common/config/main-local.php -> db)

- 导入数据库表

```
yii migrate 
```

#### 4. 重定向
---
因项目设置了urlManager,需设置虚拟主机并开启重定向,否则可能会出现无法访问等情况
```
RewriteEngine on
# If a directory or a file exists, use the request directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
# Otherwise forward the request to index.php
RewriteRule . index.php
```
#### 5. 网站前台
---
目前只开发了注册／登录功能,可根据自己的需求进行二次开发


#### 6. 第三方功能配置
---
- [阿里大鱼](http://www.alidayu.com/) 短信平台 (配置文件:common/config/params.php -> alidayu)
- [QQ](https://connect.qq.com/) 
  [微信](https://open.weixin.qq.com/) 
  [微博](http://open.weibo.com/) 第三方登录 
  (配置文件:frontend/config/main.php -> authClientCollection)
- [阿里云OSS](https://www.aliyun.com/product/oss/) (配置文件:common/config/params.php -> oss)

#### 7. 如有任何问题 请发邮件到：crazydouble@sina.com