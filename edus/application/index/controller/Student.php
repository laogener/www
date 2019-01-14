<?php
namespace app\index\controller;

use think\Request;
use think\Db;
use app\index\model\Student as StudentModel;

class Student extends Base{
    //    管理员列表
    public function studentList(){
        $this -> assign('title', '学生列表');
        $this -> assign('keywords', '学生列表');
        $this -> assign('desc', '学生列表');
        $this -> assign('count', StudentModel::count());


        $date=StudentModel::all();

        foreach ($date as $value){
            $list1=[
                "id"=>$value->id,
                "name"=>$value->name,
                "sex"=>$value->sex,
                "age"=>$value->age,
                "tel"=>$value->tel,
                "email"=>$value->email,
                "start_time"=>$value->start_time,
                "status"=>$value->status,
                "grade"=>isset($value->grade->name)?($value->grade->name):'<span style="color:red;">未分配</span>',

            ];
            $list[] = $list1;
        }
//        halt($list);
        $this -> assign('list', $list);

        return view("student_list");
    }
    public function setStatus(Request $request){
        $id=$request->param("id");

        $result=StudentModel::get($id)->getData("status");

        if($result===1){
            StudentModel::update(["status"=>0],["id"=>$id]);
        }else{
//            halt($result);
            StudentModel::update(["status"=>1],["id"=>$id]);
//            Db::table('teacher')->update(['status' => 1,'id'=>$id]);
        }
    }
    //    软删除
    public function delStudent(Request $request){
        $id=$request->param();
        StudentModel::destroy($id);
    }
//    恢复删除
    public function unDel(){
        StudentModel::update(["delete_time"=>Null],["is_delete"=>1]);
    }
    //    编辑界面
    public function studentEdit(Request $request){
        $id=$request->param();
        $list=StudentModel::get($id)->toArray();
        $this->assign("list",$list);
        $this->assign("gradeList",\app\index\model\Grade::all());
        $this->view->assign('title','编辑学生信息');
        $this->view->assign('keywords','PHP中文教学管理系统');
        $this->view->assign('desc','PHP中文教学管理系统');
//        halt($list);
        return view("student_edit");
    }
//修改教师信息
    public function editStudent(Request $request){
        $param=$request->param();
//halt($param);
        $userUp=StudentModel::update($param,['id'=>$param['id']]);

        if ($userUp) {
            return ['status'=>1, 'message'=>'更新成功'];
        } else {
            return ['status'=>0, 'message'=>'更新失败,请检查'];
        }
    }
    //    添加界面
    public function studentAdd(){

        $this->view->assign('title','添加学生');
        $this->view->assign('keywords','PHP中文教学管理系统');
        $this->view->assign('desc','PHP中文教学管理系统');
        $this->assign("gradeList",\app\index\model\Grade::all());

        return view("student_add");
    }
    //    添加管理员
    public function addStudent(Request $request){
        $data=$request->param();
//        halt($data);
        $status=1;
        $message="添加成功";
        $result=StudentModel::create($data);
        if(!$result){
            $status = 0;
            $message = '添加失败~~';
        }
        return ['status'=>$status, 'message'=>$message];

    }
}
