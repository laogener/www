<?php
namespace app\index\controller;

use think\Request;
use think\Db;
use app\index\model\Teacher as TeacherModel;

class Teacher extends Base{
    //    管理员列表
    public function teacherList(){
        $this -> assign('title', '教师列表');
        $this -> assign('keywords', '教师列表');
        $this -> assign('desc', '教师列表');
        $this -> assign('count', TeacherModel::count());


        $date=TeacherModel::all();

        foreach ($date as $value){
            $list1=[
                "id"=>$value->id,
                "name"=>$value->name,
                "education"=>$value->education,
                "school"=>$value->school,
                "tel"=>$value->tel,
                "hire_time"=>$value->hire_time,
                "status"=>$value->status,
                "grade"=>isset($value->grade->name)?($value->grade->name):'<span style="color:red;">未分配</span>',

            ];
            $list[] = $list1;
        }
//        halt($list);
        $this -> assign('list', $list);

        return view("teacher_list");
    }
    public function setStatus(Request $request){
        $id=$request->param("id");

        $result=TeacherModel::get($id)->getData("status");

        if($result===1){
            TeacherModel::update(["status"=>0],["id"=>$id]);
        }else{
//            halt($result);
//            TeacherModel::update(["status"=>1],["id"=>$id]);
            Db::table('teacher')->update(['status' => 1,'id'=>$id]);
        }
    }
    //    软删除
    public function delTeacher(Request $request){
        $id=$request->param();
        TeacherModel::destroy($id);
    }
//    恢复删除
    public function unDel(){
        TeacherModel::update(["delete_time"=>Null],["is_delete"=>1]);
    }
    //    编辑界面
    public function teacherEdit(Request $request){
        $id=$request->param();
        $list=TeacherModel::get($id)->toArray();
        $this->assign("list",$list);
        $this->assign("gradeList",\app\index\model\Grade::all());
        $this->view->assign('title','编辑教师信息');
        $this->view->assign('keywords','PHP中文教学管理系统');
        $this->view->assign('desc','PHP中文教学管理系统');
//        halt($list);
        return view("teacher_edit");
    }
//修改教师信息
    public function editTeacher(Request $request){
        $param=$request->param();

        $userUp=TeacherModel::update($param,['id'=>$param['id']]);

        if ($userUp) {
            return ['status'=>1, 'message'=>'更新成功'];
        } else {
            return ['status'=>0, 'message'=>'更新失败,请检查'];
        }
    }
    //    添加界面
    public function teacherAdd(){

        $this->view->assign('title','添加教师');
        $this->view->assign('keywords','PHP中文教学管理系统');
        $this->view->assign('desc','PHP中文教学管理系统');
        $this->assign("gradeList",\app\index\model\Grade::all());

        return view("teacher_add");
    }
    //    添加管理员
    public function addTeacher(Request $request){
        $data=$request->param();
//        halt($data);
        $status=1;
        $message="添加成功";
        $result=TeacherModel::create($data);
        if(!$result){
            $status = 0;
            $message = '添加失败~~';
        }
        return ['status'=>$status, 'message'=>$message];

    }
}
