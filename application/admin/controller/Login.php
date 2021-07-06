<?php

namespace app\admin\controller;

use app\admin\model\AdminUser;
use think\Request;

class Login extends Base
{
  /**
   * @var \think\Request Request实例
   */
  protected $request;

  /**
   * 构造方法
   * @param Request $request Request对象
   * @access public
   */
  public function __construct(Request $request)
  {
    $this->request = $request;
  }
  public function login()
  {
    return $this->fetch();
  }

  /**
   * check password && name
   * @return void
   */
  public function doLogin()
  {
    $adminName = $this->request->param('name');
    $password = $this->request->param('password');
    if (empty($adminName) || empty($password)) {
      return '用户名或密码不能为空';
    }

    $adminUserModel = new AdminUser();
    $info = $adminUserModel->getAdmimUserInfo($adminName);

    if ($info == null) {
      return '用户名不存在';
    }

    $hashPassword =  $info->getData('password');

    if (!password_verify($password, $hashPassword)) {
      return '密码错误';
    }

    var_dump($info);

    return 'index';
  }
}
