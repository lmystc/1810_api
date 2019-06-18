<?php
namespace App\Http\Controllers\Text;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use DB;
use GuzzleHttp\Client;
class Textcotroller extends Controller{
    public function curl1(){
//        访问的地址
        $url='https://www.baidu.com';
//    1.  初始化
        $ch=curl_init($url);
//    2.  设置参数
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,0);//控制浏览器输出
//    3.  执行
        curl_exec($ch);
//    4.   关闭
        curl_close($ch);
    }
    public function curl2(){
        $appId='wxbfb91a5c4d763ba9';
        $secret='015ff2b0c0051ba263d4070984e17d27';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appId .'&secret='.$secret ;
        $ch=curl_init($url);
        //设置参数
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //执行会话
        $data=curl_exec($ch);
        //关闭会话
        curl_close($ch);
        //echo $data;
       $data=json_decode($data,true);
       //dd($data);
       return $arr=$data['access_token'];

    }
    public function curl3(){
        echo __FILE__;echo '<hr>';
        echo '<pre>';print_r($_POST);echo '</pre>';
    }
    public function form1(){
        return view('test.form1');
    }
    public function form1post(){
        echo __METHOD__;echo '</br>';
        echo '<pre>';print_r($_POST);echo '</pre>';
    }
    public function tet(){
        $access_token=$this->curl2();
        //调用微信菜单接口
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        //dd($url);

        $post_data = '{
		     "button":[
		      {    
		          "type":"click",
		          "name":"菜单1",
		          "key":"da"
		      },
		      {    
		          "type":"click",
		          "name":"菜单2",
		          "key":"che"
		      }	     
			]
		 }';
        $ch=curl_init($url);
//设置参数
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,false);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
//执行会话发送请求
        curl_exec($ch);
//获取错误信息
        $errno=curl_errno($ch);
        $errmsg=curl_error($ch);
        var_dump($errno);
        var_dump($errmsg);
//关闭会话
        curl_close($ch);
    }
    //上传文件
    public function curl4(Request $request){
        if($request->hasFile()){



        }

    }
    //上传图片
    public function upload(Request $request){

    }
    public function uploads($name){
        if (request()->file($name)->isValid()){
            $photo = request()->file($name);
            $extension = $photo->extension();
            $store_result = $photo->storeAs(date("Ymd"), date('Ymd') . rand(100, 999) . '.' . $extension);
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }
    //数据加密
    public function curl5(){
     $data='lmy';
     $enc_data=base64_encode($data);
//     dd($enc_data);
     //echo $enc_data;
     $client=new Client();
//     dd($client);
     $url="http://www.blog4.com/curl5";
//     dd($url);
     //post数据
        $r=$client->request('POST',$url,['body'=>$enc_data]);
        echo $r->getBody();
    }
    public function curl6(){
        $str="hello world";
        $key='password';
        $vi="asdfghjklqwertyu";//初始向量
        //使用对称加密
        $enc_data=openssl_encrypt($str,'AES-128-CBC',$key,OPENSSL_RAW_DATA,$vi);
        var_dump($enc_data);
        $client=new Client();
        //dd($client);
        $url="http://www.blog4.com/curl7";//接收端地址
        $response=$client->request('post',$url,['body'=>$enc_data]);
       // dd($response);
        echo $response->getBody();
    }
    public function curl7(){
        $data="我叫历明玉";
        //使用非对称加密  私钥加密数据
//        $private_key=openssl_get_privatekey("file://".public_path("keys/priv.pem"));
        $private_key=openssl_get_privatekey("file://".public_path("keys/m.pem"));
      // dd($private_key);
        openssl_private_encrypt($data,$enc_data,$private_key);
       // dd($enc_data);echo '<hr>';
        //发送数据
        $url='http://www.blog4.com/rsa';
        $client=new Client();
        //dd($client);
        $response=$client->request('post',$url,[
            'body'=>$enc_data
        ]);
        //dd($response);
        echo $response->getBody();
    }
    public function curl8(){
        $data=[
            'password'=>724893794,

        ];
        $key='password';
        $vi="asdfghjklqwertyu";//初始向量
        //使用对称加密
        $data1=openssl_encrypt($data,'AES-128-CBC',$key,OPENSSL_RAW_DATA,$vi);

        $private_key=openssl_get_privatekey("file://".public_path("keys/m.pem"));
        //生成私钥签名
        $open_sign=openssl_sign($data1,$signatrue,$private_key);
        $info=[
          'data'=>$data1,
          'body'=>$signatrue
        ];
        $info=serialize($info);
        $client=new Client();
        $url="http://www.blog4.com/sign";
        $response=$client->request('post',$url,[
            'body'=>$info
        ]);
        //dd($response);
        echo $response->getBody();
    }
    public function sign(){
        $data = [
            'order_id'			=> 123456,
            'order_amount'		=> 300,
            'add_time'			=> 123334535,
            'uid'				=> 2233
        ];
        //排序
        ksort($data);
        //拼接
        $str="";
        foreach ($data as $k=>$v){
            $str .= $k."=".$v."&";
        }
        //dd($str);
        $str1=rtrim($str,'&');
        //dd($str1);
       //私钥签名
        $private_key=openssl_get_privatekey("file://".public_path("keys/m.pem"));
        //dd($private_key);
        openssl_sign($str1,$signatrue0,$private_key);
        echo "sign:".$signatrue0;
        $signature=base64_encode($signatrue0);
        //发送数据
        $data['signatrue']=$signature;
       // dd($signature);
        echo "<hr>";
        echo '<pre>';print_r($data);echo '</pre>';
        $url='http://www.blog4.com/sign1';
        $client=new Client();
        //dd($client);
        $response=$client->request('POST',$url,[
            'form_params'=>$data
        ]);
        echo $response->getBody();
    }
    public  function alipay(){
        //支付宝
        $appid='';
        $ali_gateway='https://openapi.alipaydev.com/gateway.do';
        //请求参数
        $biz_cont=[
            'subject'=>'测试订单'.mt_rand(11111,99999).time(),
            'out_trade_no'=>'1810_'.mt_rand(11111,99999).time(),
        ];


    }


}



?>