<?php
namespace app\index\controller;

use think\Request;
use app\index\model\Grade as GradeModel;

class Grade extends Base{
    //    管理员列表
    public function gradeList(){
        $this -> assign('title', '班级列表');
        $this -> assign('keywords', '班级列表');
        $this -> assign('desc', '班级列表');
        $this -> assign('count', GradeModel::count());


        $date=GradeModel::all();

        foreach ($date as $value){
            $list1=[
                "id"=>$value->id,
                "name"=>$value->name,
                "length"=>$value->length,
                "price"=>$value->price,
                "create_time"=>$value->create_time,
                "status"=>$value->status,
                "teacher"=>isset($value->teacher->name)?($value->teacher->name):'<span style="color:red;">未分配</span>',

            ];
            $list[] = $list1;
        }
//        halt($list);
        $this -> assign('list', $list);

        return view("grade_list");
    }
    public function setStatus(Request $request){
        $id=$request->param("id");
        $result=GradeModel::get($id)->getData("status");
        if($result===1){
            GradeModel::update(["status"=>0],["id"=>$id]);
        }else{
            GradeModel::update(["status"=>1],["id"=>$id]);
        }
    }
    //    软删除
    public function delUser(Request $request){
        $id=$request->param();
        GradeModel::destroy($id);
    }
//    恢复删除
    public function unDel(){
        GradeModel::update(["delete_time"=>Null],["is_delete"=>1]);
    }
    //    编辑界面
    public function gradeEdit(Request $request){
        $id=$request->param();
        $list=GradeModel::get($id)->getData();
        $this->assign("list",$list);
        $this->view->assign('title','编辑班级信息');
        $this->view->assign('keywords','PHP中文教学管理系统');
        $this->view->assign('desc','PHP中文教学管理系统');
//        halt($list);
        return view("grade_edit");
    }
//修改班级信息
    public function editGrade(Request $request){
        $param=$request->except("teacher");

        $userUp=GradeModel::update($param,['id'=>$param['id']]);

        if ($userUp) {
            return ['status'=>1, 'message'=>'更新成功'];
        } else {
            return ['status'=>0, 'message'=>'更新失败,请检查'];
        }
    }
    //    添加界面
    public function gradeAdd(){

        $this->view->assign('title','添加班级');
        $this->view->assign('keywords','PHP中文教学管理系统');
        $this->view->assign('desc','PHP中文教学管理系统');
        return view("grade_add");
    }
    //    添加管理员
    public function addGrade(Request $request){
        $data=$request->param();
        $status=1;
        $message="添加成功";
        $result=GradeModel::create($data);
        if(!$result){
            $status = 0;
            $message = '添加失败~~';
        }
        return ['status'=>$status, 'message'=>$message];

    }
}
