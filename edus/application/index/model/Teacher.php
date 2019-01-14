<?php
namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;

class Teacher extends Model{
//软删除
    use SoftDelete;

    //设置当前表默认日期时间显示格式
    protected $dateFormat = 'Y/m/d';
    protected $deleteTime = 'delete_time';

//    写入自动完成
    protected $auto = [
        "delete_time" => Null,
        "is_delete" => 1 //1允许删除，0不允许
    ];
    //设置时间戳，自动写入create_time和update_time字段
    protected $autoWriteTimestamp = true;
    protected $type = [
        'hire_time'=>'timestamp'
    ];
    // 定义自动完成的属性
    protected $insert = ['status' => 1];
    //获取器
    public function getStatusAttr($value)
    {
        $status = [
            0=>'已停用',
            1=>'已启用'
        ];
        return $status[$value];
    }
    public function getEducationAttr($value)
    {
        $degree = [
            1=>'专科',
            2=>'本科',
            3=>'研究生'
        ];
        //根据表中数据返回对应值
        return $degree[$value];
    }
//    定义关联字段
    public function grade(){
        return $this->belongsTo("Grade");
    }

}
