<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
class CartController extends Controller
{
	public function index ()
	{
		$session=request()->session()->get('u_id');
		if(!$session){
			echo "<script>alert('请先登录');location.href='/login'</script>";
		}
		if($session){
		  $cartInfo=$this->getCartDb();
		}else{
		  $cartInfo=$this->getCartCookie();
		}
		// dd($cartInfo);
		return view('index/cartList',['cartInfo'=>$cartInfo]);
	}
   public function addcart ()
    {
    	$data=request()->all();
    	// dd($data);
        $goods_id=$data['goods_id'];
        $buy_number=$data['buy_number'];
        // dump($buy_number);
        // dump($goods_id);die;
       $session=request()->session()->get('u_id');
        // $session=session('?userInfo');
        // dump($session);die;
        $user_id=request()->session()->get('u_id');
        if ($session) {
            $where=[
                ['goods_id','=',$goods_id],
                ['user_id','=',$user_id],
                // ['is_del','=',1]
            ];
            $info=DB::table('tp_cart')->where($where)->first();
            // dump($info['buy_number']);die;
            // $info=array($info);
            $info=json_encode($info);
            $info=json_decode($info,true);
            // dd($info);
            // dd($info);		
            if($info){
                $res=checkNum($goods_id,$buy_number,$info['buy_number']);
                // dump($res);die;
                if($res===true){
                   $updataWhere=['buy_number'=>$info['buy_number']+$buy_number];
                   // dump($updataWhere);die;
                   $result=DB::table('tp_cart')->where($where)->update($updataWhere);
                   if($result){
                        successly('添加购物车成功');
                   }else{
                        fail('由于网络的原因，添加购物车失败');
                   }                 
                }else{
                    fail('已超过库存数量,最多'.$res.'个');
                }
            }else{
               $res=checkNum($goods_id,$buy_number);
               if($res===true){
                $info= ['goods_id'=>$goods_id,'buy_number'=>$buy_number,'user_id'=>$user_id];
                    $result=DB::table('tp_cart')->insert($info);
                    if($result){
                        successly('添加购物车成功');
                    }else{
                        fail('由于您网络的原因，添加购物车失败');
                    }
               }else{
                    fail('已超过库存数量最多'.$res.'个');
               }
            }
        }else{
            //未登录
            $str=request()->cookie('cartStr');
            // dd($str);
            if(!empty($str)){
                $cartInfo=getBase64Info($str);
                // dump($cartInfo);die;
                $flag=0;
                
                
                foreach ($cartInfo as $k => $v) {
                    // dump($v['goods_id']);die;
                    if($goods_id==$v['goods_id']){
                        $res=checkNum($goods_id,$buy_number,$v['buy_number']);
                            // dump($res);die;
                        if($res===true){
                          $cartInfo[$k]['buy_number']=$buy_number+$v['buy_number'];
	                      $cartStr=createBase64Str($cartInfo);
	                      Cookie::queue('cartStr', $cartStr, 60);
	                      successly('添加购物车成功');
                        // exit;
                    }else{
                      fail('已超过库存数量,最多'.$res.'个');
                    }
                }else{
                    $flag=1;
                }
            }
            if($flag==1){
                //直接添加
                $cartInfo[]=[
                    'goods_id'=>$goods_id,
                    'buy_number'=>$buy_number
                ];
                 $cartStr=createBase64Str($cartInfo);
                Cookie::queue('cartStr', $cartStr, 60);
                successly('添加购物车成功');
            }

            }else{
                // echo 1;die;
                $info[]=[
                    'goods_id'=>$goods_id,
                    'buy_number'=>$buy_number
                ];
                $cartStr=createBase64Str($info);
                Cookie::queue('cartStr', $cartStr, 60);
                successly('添加购物车成功');
            }
        }
    }
    public function getCartDb ()
    {
    $user_id=request()->session()->get('u_id');
    $info=cache('info_'.$user_id);
    if(!$info){
        echo 123213;
         $where=[
                ['user_id','=',$user_id],
                ['is_del','=',1]
            ];
    $info=DB::table('tp_cart as c')
            ->where($where)
            ->join('tp_goods', 'c.goods_id', '=', 'tp_goods.goods_id')
            ->get();
    cache(['info_'.$user_id=>$info],60*24);
    }
   
    // dd($info);
    return $info;
    } 
    public function getCartCookie ()
    {
    	 $str=request()->cookie('cartStr');
            if(!empty($str)){
                $goods_id=getBase64Info($str);
                // dump($cartInfo);die;
               $goods_id=array_column($goods_id,'goods_id');
               // dd($goods_id);
		          $info=DB::table('tp_goods as g')
		          ->whereIn('goods_id',$goods_id)
		          ->join('tp_cart as c', 'g.goods_id', '=', 'c.goods_id')
		          ->get();
				  dd($cartInfo);
				return $info;
            }else{
            return $info=[];
        }
    }
    public function ok123 ()
    {
        successly('正在为您跳转');
    }
    public function pay ()
    {
    	$goods_id=request()->all();
    	// dd($goods_id);
    	$data=DB::table('tp_goods')->whereIn('goods_id',$goods_id)->get();
    	// dd($data);
    	// print_r($data);die;
    	return view('index/pay',['data'=>$data]);
    }





    

}
