<?php
namespace app\index\controller;

class Index extends Base
{
    public function index()
    {
        $this->isLogin();
        $this->assign("title","PHP中文教学管理系统");
        return view();
    }
}
