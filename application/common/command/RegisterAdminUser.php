<?php

namespace app\common\command;

use app\admin\model\AdminUser;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class RegisterAdminUser extends Command
{
  protected function configure()
  {
    $this->setName('rbac');
  }
  /**
   * Undocumented function
   * @return void
   * @todo create  rbac  table
   * @author lidan <2364752564@email.com>
   */
  protected function execute(Input $input, Output $output)
  {
    $adminUser = new AdminUser();
    $adminUser->createRbacTable();
  }
}
