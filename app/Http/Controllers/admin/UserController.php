<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class UserController extends Controller
{
    public function  re(Request $request){
        header("Access-control-Allow-Origin:*");
        $data=$request->input();
//       return $data;
        if($data['password']!=$data['password_confirm']){
            $font='两次密码不一致';
            $this->fail($font);
        }
        $where=[
            'name'=>$data['name']
        ];
        $res=\DB::table('users')->where($where)->first();
        if(!empty($res)){
            $font='用户名已经存在';
            $this->fail($font);
        }
        unset($data['password_confirm']);
        $res1=\DB::table('users')->insert($data);
        if($res1){
            $font='注册成功';
            $this->successly($font);
        }else{
            $font='注册失败';
            $this->fail($font);
        }

    }

    public function lo(){
        header("Access-control-Allow-Origin:*");
        $data=request()->input();
        $where=[
            'name'=>$data['name']
        ];
        $res=\DB::table('users')->where($where)->first();
        if(!empty($res)){
            if($data['password']!=$res->password){
                $font="密码账号不正确";
                $this->fail($font);
            }else{
                $font='登录成功';
                $this->successly($font);
            }
        }else{
            $font="密码账号不正确";
            $this->fail($font);
        }
    }

    public function successly($font=''){
        $message=[
            'font'=>$font,
            'code'=>1
        ];
        $data=json_encode($message);
        echo $data;
    }

    public function fail($font=''){
        $message=[
            'font'=>$font,
            'code'=>2
        ];
        $data=json_encode($message);
        echo $data;
    }
}
