<?php
namespace app\index\validate;
use think\Validate;
class AddUser extends Validate
{
    protected $rule = [
        'name|用户名' => "require|min:3|max:10",
        'password|密码' => "require|min:3|max:10",
        'email|邮箱' => 'require|email'
    ];
}
