<?php
namespace app\index\controller;

use think\Request;
use think\Session;
use think\Loader;
use app\index\model\User as UserModel;


class User extends Base{
//    登录界面
    public function login(){
        $this->alerdyLogin();
        $this->assign("title","登录界面");
        $this->assign("keywords","PHP中文教学管理系统");
        $this->assign("desc","PHP中文教学管理系统");
        return view();
    }
//    登录验证
    public function checkLogin(Request $request){
        $status=0;
        $result="验证失败，请重新登录";

        $data=$request->param();
        $validate = Loader::validate('User');
        $result = $validate->check($data);
        if($result){
           $map=[
               "name"=>$data["name"],
               "password"=>md5($data["password"]),
           ];
           $user=UserModel::get($map);

            if (!$user) {
                $result = '没有该用户,请检查';
            } else {
                $status = 1;
                $result = '验证通过';
               Session::set("user_info",$user->toArray());
               $user->setInc("login_count");
           }
        }else{
            $result=$validate->getError();
        }
        return ["status"=>$status,"message"=>$result];
    }
//    退出登录
    public function loginOut(){
        UserModel::update(["login_time"=>time()],["id"=>session("user_info.id")]);
        session(null, 'user_info');
        $this->success("注销登录，正在返回",url('user/login'));
    }
//    管理员列表
    public function adminList(){
        $this -> assign('title', '管理员列表');
        $this -> assign('keywords', '管理员列表');
        $this -> assign('desc', '管理员列表');
        $this -> assign('count', UserModel::count());


        $userName=session("user_info.name");
        if($userName==="admin"){
            $list=UserModel::paginate(3);
        }else{
            $list=UserModel::all(["name"=>$userName]);
        }
//        halt($list);
        $this -> assign('list', $list);



        return view("admin_list");
    }
//管理员状态
    public function setStatus(Request $request){
        $id=$request->param("id");
        $result=UserModel::get($id)->getData("status");
        if($result===1){
            UserModel::update(["status"=>0],["id"=>$id]);
        }else{
            UserModel::update(["status"=>1],["id"=>$id]);
        }
    }
//    软删除
    public function delUser(Request $request){
        $id=$request->param();
        UserModel::destroy($id);
    }
//    恢复删除
    public function unDel(){
        UserModel::update(["delete_time"=>Null],["is_delete"=>1]);
    }
//    编辑界面
    public function adminEdit(Request $request){
        $id=$request->param();
        $list=UserModel::get($id)->getData();
        $this->assign("list",$list);
        $this->view->assign('title','编辑管理员信息');
        $this->view->assign('keywords','PHP中文教学管理系统');
        $this->view->assign('desc','PHP中文教学管理系统');
//        halt($list);
        return view("admin_edit");
    }
//修改管理员信息
    public function editUser(Request $request){
        $param=$request->param();
        foreach ($param as $key => $value){
            if (!empty($value)){
                $data[$key] = $value;
            }
        }

        $userUp=UserModel::update($data,['id'=>$data['id']]);

        if(Session::get("user_info.name")===$data['name']){
            Session::set("user_info",$data);

        }
        if ($userUp) {
            return ['status'=>1, 'message'=>'更新成功'];
        } else {
            return ['status'=>0, 'message'=>'更新失败,请检查'];
        }
    }
//    添加界面
    public function adminAdd(){

        $this->view->assign('title','添加管理员');
        $this->view->assign('keywords','PHP中文教学管理系统');
        $this->view->assign('desc','PHP中文教学管理系统');
        return view("admin_add");
    }
    //检测用户名是否可用
    public function checkUserName(Request $request)
    {
        $userName = trim($request -> param('name'));
        $status = 1;
        $message = '用户名可用';
        if (UserModel::get(['name'=> $userName])) {
            //如果在表中查询到该用户名
            $status = 0;
            $message = '用户名重复,请重新输入~~';
        }
        return ['status'=>$status, 'message'=>$message];
    }

    //检测用户邮箱是否可用
    public function checkUserEmail(Request $request)
    {
        $userEmail = trim($request -> param('email'));
        $status = 1;
        $message = '邮箱可用';
        if (UserModel::get(['email'=> $userEmail])) {
            //查询表中找到了该邮箱,修改返回值
            $status = 0;
            $message = '邮箱重复,请重新输入~~';
        }
        return ['status'=>$status, 'message'=>$message];
    }
//    添加管理员
    public function addUser(Request $request){
        $data=$request->param();
        $validate = Loader::validate('AddUser');
        $status=1;
        $message="添加成功";

        if($validate->check($data)){
            $result=UserModel::create($data);
            if(!$result){
                $status = 0;
                $message = '添加失败~~';
            }
        }
        return ['status'=>$status, 'message'=>$message];

    }
}
