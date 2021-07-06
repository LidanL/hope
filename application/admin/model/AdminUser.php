<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class AdminUser extends Model
{
  protected $pk = 'id';

  /**
   * @todo create default  admin user count
   * @return void
   * @author lidan <2364752564@email.com>
   */
  protected function createDefaultAdminUser()
  {
  }

  /**
   * @todo create rbac table
   * @author lidan <2364752564@email.com>
   * @return void
   */
  public function createRbacTable()
  {
    echo "初始化rbac.....";
    self::transaction(function () {
      echo '创建rbac数据表....';
      // 创建表
      self::execute(
        "CREATE TABLE IF NOT EXISTS `hope_admin_user` (
          `id`  int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID' ,
          `name`  char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录名称' ,
          `real_name`  char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '真实姓名' ,
          `email`  char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
          `phone`  int(11) UNSIGNED NOT NULL ,
          `password`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户密码' ,
          `salt`  char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '加密盐' ,
          `create_time`  timestamp NULL ,
          `edit_time`  timestamp NULL ON UPDATE CURRENT_TIMESTAMP ,
          `is_active`  tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否有效 默认1(有效) 2无效' ,
          `deleted`  tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否删除 默认1(未删除) 2已删除' ,
          PRIMARY KEY (`id`)
          )
          ENGINE=InnoDB 
          DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
          COMMENT='后台用户表';"
      );


      self::execute(
        "CREATE TABLE IF NOT EXISTS `hope_admin_role` (
        `id`  int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID' ,
        `name`  char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '角色名称' ,
        `create_time`  timestamp NULL ,
        `edit_time`  timestamp NULL ON UPDATE CURRENT_TIMESTAMP ,
        `deleted`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否删除 默认 1(未删除) 2删除' ,
        PRIMARY KEY (`id`)
        )
        ENGINE=InnoDB
        DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
        COMMENT='后台用户角色表'
        ;"
      );

      self::execute(
        "CREATE TABLE IF NOT EXISTS `hope_admin_menu` (
        `id`  int UNSIGNED NOT NULL AUTO_INCREMENT ,
        `pid`  int UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级ID' ,
        `name`  char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '菜单名称' ,
        `icon`  varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '菜单图标' ,
        `module`  char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '模块' ,
        `controller`  char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '控制器' ,
        `action`  char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '操作方法' ,
        `create_time`  timestamp NULL ,
        `edit_time`  timestamp NULL ON UPDATE CURRENT_TIMESTAMP ,
        `status`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否展示 默认1(展示) 2(不展示)' ,
        `deleted`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否删除 默认1 (未删除) 2已删除' ,
        PRIMARY KEY (`id`)
        )
        ENGINE=InnoDB
        DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
        COMMENT='后台菜单表'
        ;"
      );

      self::execute(
        "CREATE TABLE IF NOT EXISTS `hope_admin_user_role` (
        `id`  int UNSIGNED NOT NULL AUTO_INCREMENT ,
        `user_id`  int UNSIGNED NOT NULL COMMENT '用户ID' ,
        `role_id`  int UNSIGNED NOT NULL COMMENT '角色ID' ,
        PRIMARY KEY (`id`)
        )
        ENGINE=InnoDB
        DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
        COMMENT='后台用户与角色关联表'
        ;"
      );

      self::execute(
        "CREATE TABLE IF NOT EXISTS `hope_admin_role_menu` (
        `id`  int UNSIGNED NOT NULL AUTO_INCREMENT ,
        `menu_id`  int UNSIGNED NOT NULL COMMENT '菜单ID' ,
        `role_id`  int UNSIGNED NOT NULL COMMENT '角色ID' ,
        PRIMARY KEY (`id`)
        )
        ENGINE=InnoDB
        DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci
        COMMENT='后台角色与菜单关联表'
        ;"
      );

      echo '插入一条后台用户....';
      $passwordHash = password_hash("123456", PASSWORD_DEFAULT);
      $data = array('name' => 'lidan', 'password' => $passwordHash, 'salt' => '', 'is_active' => 1);
      self::name('admin_user')->insert($data);
    });
  }

  public function getAdmimUserInfo($adminName)
  {
    return $this->where('name', $adminName)->find();
  }
}
