<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index ()
    {
    	if(request()->session()->get('u_id')){
    		$user_id=request()->session()->get('u_id');
    		$goods_id=request()->all()['goods_id'];
            $res=DB::table('like')->where('goods_id',$goods_id)->first();
            if($res){
                return 3;
            }
    		// dd($goods_id);
    		$arr=[
    			'goods_id'=>$goods_id,
    			'user_id'=>$user_id,
    			'creat_time'=>time(),
    		];
    		$res=DB::table('like')->insert($arr);
    		if($res){
    			return 1;
    		}
    	}else{
    		return 2;
    	}
    }
    public function shoucang ()
    {
            $user_id=request()->session()->get('u_id');
            $where=[
                        ['user_id','=',$user_id],
                    ];
            $info=DB::table('like as c')
                    ->where($where)
                    ->join('tp_goods', 'c.goods_id', '=', 'tp_goods.goods_id')
                    ->get();
                    // dd($info);
        return view('index/shoucang',['info'=>$info]);
    }
}
