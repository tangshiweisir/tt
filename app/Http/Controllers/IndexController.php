<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
    public function index ()
    {
    	// DB::connection()->enableQueryLog();
        $data=cache('data');
        // dd($data);
        if(!$data){
            // echo 12312;
    	$data=DB::table('tp_goods')->orderBy('goods_id','desc')->paginate(6);
        cache(['data'=>$data],60*24);
        }
        // dd($data);
    	// $logs = DB::getQueryLog();
// dd($logs);
    	if(request()->session()->get('u_id')){
    		$historyInfo=$this->gethishtoryDB();
    	}else{
    		$historyInfo=[];
    	 	$historyInfo=$this->gethistoryCookie();
    	}
    	// dd($historyInfo);
    	return view('index/index',compact('data','historyInfo'));
    }
    public function proinfo ()
    {
    	$goods_id=request()->all();
    	if(request()->session()->get('u_id')){
    		$historyInfo=$this->historyDB($goods_id);
    	}else{
    		 // $this->historycookie($goods_id);
    		 $str=request()->cookie('history');
           //判断cookie是否有值
           if (!empty($str)) {
                //调用方法解密
               $historyInfo=$this->getBase64Info($str);
               $historyInfo[]=['goods_id'=>$goods_id,'look_time'=>time()];
           }else{
            //往数组中增加新的记录
            // dd($goods_id);
                $historyInfo=[
                    ['goods_id'=>$goods_id,'look_time'=>time()],
                ];
           }
           //存cookie并且加密
           $historyStr=$this->createBase64Str($historyInfo);
           // $aa= Cookie::make('historyYYY', $history,60);
          Cookie::queue('history', $historyStr, 60);
         // return response::make()->withcookie($aa);
    	}
        $goods_id=$goods_id['goods_id'];
        $row=cache('row_'.$goods_id);
        // dd($row);
        if(!$row){
            echo 123123;
            $row=DB::table('tp_goods')->where('goods_id',$goods_id)->first();
            // dd($row);
            cache(['row_'.$goods_id=>$row],60*24);
        }
        // dd($row);
    	// $this->historyDB($goods_id);
    	// $row=DB::table('tp_goods')->where('goods_id',$goods_id)->first();
    	// dd($data);
    	return view('index/proinfo',['row'=>$row]);
    }
    public function historyDB ($goods_id)
    {

    	$u_id=request()->session()->get('u_id');
    	// dd($u_id);
    	// dd($goods_id['goods_id']);
    	$info=[
    		'user_id'=>$u_id,
    		'look_time'=>time(),
    		'goods_id'=>$goods_id['goods_id']
    	];
    	$res=DB::table('tp_history')->insert($info);
    	// dd($res);
    }
    public function gethishtoryDB ()
    {
    	$u_id=request()->session()->get('u_id');
    	// dd($u_id);
    	$id=DB::table('tp_history')->where('user_id',$u_id)->orderBy('look_time','desc')->select('goods_id')->get()->toArray();
    	$goodsID=array_column($id,'goods_id');
    	// dd($goodsID);
       if($goodsID){
	        $goods_id=array_slice(array_unique($goodsID),0,4);//去重d
	        // dd($goods_id);
	  		$historyInfo=DB::table('tp_goods')->whereIn('goods_id',$goods_id)->get();
	  		// dd($historyInfo);
	        return $historyInfo;
	    }else{
	        return false;
	    }
    }
    
    public function gethistoryCookie ()
    {
    	 $str=request()->cookie('history');
    	 if(!empty($str)){
            $historyInfo=$this->getBase64Info($str);//取值
            // dump($historyInfo);die;
            if(strlen($str)>4000){
                array_shift($historyInfo);
            }
            $goods_id=[];
            //循环查找ID值
            foreach ($historyInfo as $k => $v) {
                $goods_id[]=$v['goods_id'];
            }
            $goods_id=array_column($goods_id,'goods_id');
            // dump($goods_id);die;
            //去掉重复的id
            $goods_id=array_slice(array_unique($goods_id),0,4);//去重
            // dd($goods_id);	
            $historyInfo=DB::table('tp_goods')->whereIn('goods_id',$goods_id)->get();
            // dd($historyInfo);
            return $historyInfo;
        }else{
            return false;
        }
    }


    
    public function okby ()
    {
    	$str = request()->cookie('history');
    	dd($str);
    	$historyInfo=$this->getBase64Info($str);
    	dd($historyInfo);
    }
    //加密
    public function createBase64Str($historyInfo){
      return base64_encode(serialize($historyInfo));
    }
    //解密
    public function getBase64Info($str){
      return unserialize(base64_decode($str));
    }
    public function user ()
    {
        if(!request()->session()->get('u_id')){
            echo "<script>alert('您还没登录');location.href='/login'</script>";
        }
    $u_email=cache('u_email');
    // dd($u_email);
        return view('index/user',['u_email'=>$u_email]);
    }
}
