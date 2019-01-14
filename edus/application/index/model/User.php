<?php

namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;

class User extends Model
{
//软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';
//    写入自动完成
    protected $auto = [
        "delete_time" => Null,
        "is_delete" => 1 //1允许删除，0不允许
    ];
    protected $insert = [
        "login_time" => Null,
        "login_count" => 0
    ];
//设置时间戳，自动写入create_time和update_time字段
    protected $autoWriteTimestamp = true;
//获取器
    public function getStatusAttr($value)
    {
        $status = [
            0=>'已停用',
            1=>'已启用'
        ];
        return $status[$value];
    }
    public function getRoleAttr($value)
    {
        $status = [
            0=>'管理员',
            1=>'超级管理员'
        ];
        return $status[$value];
    }
    public function getLoginTimeAttr($value)
    {
        return date("Y/m/d H:i",$value);
    }
//修改器
    public function setPasswordAttr($value)
    {
        return md5($value);
    }


}