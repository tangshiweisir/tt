<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Mail;
class IoginController extends Controller
{
    public function login ()
    {
    	return view('index/login');
    } 
    public function login_do ()
    {
    	$data=request()->input();
    	// dd($data);
    	$u_name=$data['u_name'];
    	$password=$data['password'];
    	$password=md5($password);
    	// DD($password);
    	$find=DB::table('tp_user')->where('u_email',$u_name)->first();
    	// dump(["$find->password"][0]);
    	// DD($password);
        $find=json_encode($find);
        $find=json_decode($find,true);
        $now=time();
        $u_id=$find['u_id'];
        $u_email=$find['u_email'];
        // dd($now);
        $where=[
            'u_id'=>$find['u_id']
        ];
       $last_error_time=$find['error_time'];
       $error_num=$find['error_num'];
        // print_r($error_num);die;
    	if($find){
    		if($password==$find['password']){
            //登录判断
            if($error_num>=5&&$now-$last_error_time<=3600){
                $secnd=60-ceil((time()-$last_error_time)/60);
                // dd($secnd);
                return "<script>alert('账号已锁定请于 $secnd 分钟后登陆');location.href='login'</script>";die;
            }
          //浏览历史记录      
        session(['username'=>$find['u_email'],'u_id'=>$find['u_id']]);
         if(!empty(request()->cookie('history'))){
           $str=request()->cookie('history');

            $historyInfo=$this->getBase64Info($str);
             
             foreach ($historyInfo as $k => $v) {
                // dd($v['goods_id']['goods_id']);
                $historyInfo[$k]['goods_id']=$v['goods_id']['goods_id'];
            }
            // print_r($historyInfo);exit;
            foreach ($historyInfo as $k => $v) {
                $historyInfo[$k]['user_id']=request()->session()->get('u_id');
            }
            // print_r($historyInfo);exit;
           $res= Db::table('tp_history')->insert($historyInfo);
           // dd($res);
            // Cookie::forget('history');
            Cookie::queue('history', null,1);

        }
                cache(['u_email'=>$u_email],60*24);
                // $res=cache('u_email');
                // dd($res);

                $dataInfo=[
                    'error_num'=>0,
                    'error_time'=>null,
                ];
                DB::table('tp_user')->where($where)->update($dataInfo);
    		 return "<script>alert('登录成功');location.href='user'</script>";
    		}else{
                if($now-$last_error_time>36000){
                    $updateInfo=[
                        'error_num'=>1,
                        'error_time'=>$now,
                    ];
                    $res=DB::table('tp_user')->where($where)->update($updateInfo);
                    if($res){
                    return "<script>alert('您还有五次机会');location.href='login'</script>";
                   }
                }
                if($error_num>=5){
                    $secnd=60-ceil((time()-$last_error_time)/60);
                // dd($secnd);
                return "<script>alert('账号已锁定请于 $secnd 分钟后登陆');location.href='login'</script>";die;
                }else{
                    $updateInfo=[
                        'error_num'=>$find['error_num']+1,
                        'error_time'=>$now,
                    ];
                    $res=DB::table('tp_user')->where($where)->update($updateInfo);
                    $find1=DB::table('tp_user')->where('u_email',$u_name)->first();
                    $find1=json_encode($find1);
                    $find1=json_decode($find1,true);
                    $num=6-$find1['error_num'];
                    // dd($num);
                    if($res){
                        return "<script>alert('您还有 $num 次机会');location.href='login'</script>";
                    }
                }

    			return "<script>alert('登录失败');location.href='login'</script>";
    		}

    	}
    }
     public function reg ()
    {
    	// if(request()->session()->all()){
     // 	 // dd($code);
    	// 	$code=request()->session()->get('code');
    	// 	// dd($code);
    	// 	dd($code);
    	// }
    	
 
    	return view('index/reg');
    } 
    public function send2 ()
    {
    	$code = rand(10000,999999);
    	$username=request()->all();
    	// dd($username);
    	if($username['code']!=null){
            $time=request()->session()->get('time');
            // dd($time);
            $time1=60*60*5;
            if(time()-$time>$time1){
                return 12;
            }
	    	$code=request()->session()->get('code1');
	    	$code1=$username['code'];
	    	if($code1!=$code){
	    		return 1;
	    		die;
	    	}
    	}
    	if($username['username']!=null){
            // $res=DB::table('user');

            // if($)
    	$username=$username['username'];
    		// dd($username);
    	$host = "http://dingxin.market.alicloudapi.com";
        $path = "/dx/sendSms";
        $method = "POST";
        $appcode = "b35ce2df25c64c94a14717d7cdf74e31";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "mobile=".$username."&param=code%3A".$code."&tpl_id=TP1711063";
        session(['code1'=>$code,'time'=>time()]);
        $bodys = "";
        $url = $host . $path . "?" . $querys;
// dd($url);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

       }
        $send=curl_exec($curl);
        return $send;
       
        }

    }
    public function send ()
    {
    	// $long = '1234567890abcdefghijklmnopqrstuvwxyz';
	    $code = rand(10000,999999);
    	$username=request()->all();
    	// dd($username);
    	if($username['code']!=null){
	    	$code=request()->session()->get('code');
	    	$code1=$username['code'];
	    	if($code1!=$code){
	    		return ;
	    		die;
	    	}
    	}
    	if($username['username']!=null){
	    	$username=$username['username'];
	    	// dd($username);
	    	if($username){
	    		session(['code'=>$code,'time'=>time()]);
	    	 	$res= Mail::send('index/emailcon',['code'=>$code],function($message)use($username){
	    			$message->subject("注册");
	    			$message->to($username);
	    		});
	    	}
            // dd($res);
	    	if($res===null){
	    		return 1;
	    	}else{
	    		return 2;
	    	}
	    }

    }
    public function reg_do ()
    {
    	$data=request()->all();
    	// dd($data);
    	unset($data['_token']);
        $username=$data['u_email'];
        // dd($username);
    	$data['password']=md5($data['password']);
    	$res=DB::table('tp_user')->insert($data);
    	if($res){
    		return "<script>alert('注册成功');location.href='login'</script>";
    	}
    }


      //加密
    public function createBase64Str($historyInfo){
      return base64_encode(serialize($historyInfo));
    }
    //解密
    public function getBase64Info($str){
      return unserialize(base64_decode($str));
    }


    public function loginaout ()
    {
       $res=request()->session()->flush();
       // dd($res);
       if($res===null){
        echo "<script>alert('退出成功');location.href='login'</script>";

       }
    }

}
