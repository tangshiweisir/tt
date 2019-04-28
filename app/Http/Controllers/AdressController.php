<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdressController extends Controller
{
   	public function index ()
   	{
   		// $this->getarea($pid);
   		$data=DB::table('tp_area')->where('pid',0)->get();
   		return view('index/address',['data'=>$data]);
   	}
   	public function getarea ()
   	{
   		// $id=input('post.id','');
   		$id=request()->all()['id'];
   		$where=[
   		  'pid'=>$id
   		];
        $areaInfo=DB::table('tp_area')->where($where)->get();
        // dd($areaInfo);
        echo json_encode($areaInfo);
   	}
   	public function address_add ()
   	{
   		$data=request()->all();
   		// dd($data);
   		$user_id=request()->session()->get('u_id');
   		// dd($user_id);
   		if($data['is_default']==1){
            
            $res=DB::table('tp_address')->where('user_id',$user_id)->update(['is_default'=>2]);
            // dump($res);die;
        }
        $data['user_id']=$user_id;
        $data['create_time']=time();
        $data['update_time']=time();
        $res=DB::table('tp_address')->insert($data);
        // dd($res);
        if($res){
        	return 1;
        }else{
        	return 2;
        }
   	}
   	public function success ()
   	{
   		$ddh=date('Ymd').rand(100000,999999);
   		// dd($ddh);
   		return view('index/success',['ddh'=>$ddh]);
   	}
   	public function successok ()
   	{
  		$config=config('pay');
  		// echo app_path('alipay/pagepay/service/AlipayTradeService.php');die;
      require_once app_path('libs/alipay/pagepay/service/AlipayTradeService.php');//类
       
      
      require_once app_path('libs/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');//类
// die;
    //商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = date('Ymd').rand(100000,999999);

    //订单名称，必填
    $subject = '你买的东西';

    //付款金额，必填
    $total_amount = '100';

    //商品描述，可空
    $body = '不错哦';

  //构造参数
  $payRequestBuilder = new \AlipayTradePagePayContentBuilder();

  $payRequestBuilder->setBody($body);
  $payRequestBuilder->setSubject($subject);
  $payRequestBuilder->setTotalAmount($total_amount);
  $payRequestBuilder->setOutTradeNo($out_trade_no);

  $aop = new \AlipayTradeService($config);
  // dump($aop);die;
  /**
   * pagePay 电脑网站支付请求
   * @param $builder 业务参数，使用buildmodel中的对象生成。
   * @param $return_url 同步跳转地址，公网可以访问
   * @param $notify_url 异步通知地址，公网可以访问
   * @return $response 支付宝返回的信息
  */
  $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);

  //输出表单
  var_dump($response);
   	}
    public function ok ()
    {
      $config=config('pay');
      require_once app_path('libs\alipay\pagepay\service\AlipayTradeService.php');


      $arr=$_GET;
      // dd($arr);
      $alipaySevice = new \AlipayTradeService($config); 

      $result = $alipaySevice->check($arr);
      // dd($result);

      /* 实际验证过程建议商户添加以下校验。
      1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
      2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
      3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
      4、验证app_id是否为该商户本身。
      */
      if($result) {//验证成功
      /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      //请在这里加上商户的业务逻辑程序代码

      //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
      //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

      //商户订单号
      $out_trade_no = htmlspecialchars($_GET['out_trade_no']);

      //支付宝交易号
      $trade_no = htmlspecialchars($_GET['trade_no']);


      Log::channel('alpay')->info("验证成功<br />支付宝交易号：".$trade_no);

     return redirect('/');
      //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

      /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      }else{
      //验证失败
      echo "验证失败";
      }
    }
    public function add_address ()
    {
      $user_id=request()->session()->get('u_id');
      $where=[
        'user_id'=>$user_id,
      ];
      $data=DB::table('tp_address')->where($where)->get();
      // dd($data);
      $data=json_encode($data);
      $data=json_decode($data,true);
      foreach ($data as $k=>$v){
      $data[$k]['province']=DB::table('tp_area')->where('id',$v['province'])->value('name');
      $data[$k]['city']=DB::table('tp_area')->where('id',$v['city'])->value('name');
      $data[$k]['area']=DB::table('tp_area')->where('id',$v['area'])->value('name');
}
 //dd($data);
      return view('index/add_address',['data'=>$data]);
    }
    public function countTotal ()
    {
        $goods_id=request()->all();
        // dd($goods_id);
        // echo $goods_id;
             if(empty($goods_id)){
                // fali('请至少选择一件商品');
            }
            $user_id=request()->session()->get('u_id');
            // dump($user_id);die;
            $where=[
                  'user_id'=>$user_id,
            ];
            // dd($where);
            $info=DB::table('tp_cart as c')
            ->whereIn('c.goods_id',$goods_id)
            ->where($where)
            ->join('tp_goods', 'c.goods_id', '=', 'tp_goods.goods_id')
            ->get();
            //dd($info);
            $info=json_encode($info);
            $info=json_decode($info,true);
            $count=0;
            foreach ($info as $key => $value) {
                $count+=$value['shop_price']*$value['buy_number'];
            }
            // echo $count;die;
            $arr=[
               'font'=>'修改购买数量成功',
               'code'=>1,
               'count'=>$count
            ];

            echo json_encode($arr);
           
    }
    public function changeBuyNumber ()
    {
      $goods_id=request()->all()['goods_id'];
        $buy_number=request()->all()['buy_number'];
        if(empty($goods_id)){
            fail('请至少选择一件商品');

        }
        if(empty($buy_number)){
            fail('请选择要购买的数量');
        }
        $res=checkNum($goods_id,$buy_number);
        dd($res);
       if($res===true){
            $where=[
                'goods_id'=>$goods_id,
                'user_id'=>session('userInfo.u_id')
            ];
            $updata=[
                'buy_number'=>$buy_number,
                'uptate_time'=>time()
            ];
            $cart_model=model('Cart');
            $result=$cart_model->save($updata,$where);
            // echo $cart_model->getLastSql();
            // dump($result);die;
            if($result){
                successly('修改购买数量成功');
            }else{
                fail('可能由于网络原因，你未能修改购买数量成功');
            }
       }else{
        fail('已超过库存数量,最多'.$res.'个');
       }

    }
    public function okyes ()
    {
      $config=config('pay');
      dd($config);
      require_once app_path('libs\alipay\pagepay\service\AlipayTradeService.php');

      $arr=$_POST;
      // dd($arr);
      $alipaySevice = new \AlipayTradeService($config); 
      $alipaySevice->writeLog(var_export($_POST,true));
      $result = $alipaySevice->check($arr);

      
      if($result) {//验证成功
      $out_trade_no = $_POST['out_trade_no'];

      //支付宝交易号

      $trade_no = $_POST['trade_no'];
      
      //交易状态
      $trade_status = $_POST['trade_status'];
      if($_POST['trade_status'] == 'TRADE_FINISHED') {

      }
      else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
      }
      Log::channel('alpay')->info("异步ok<br />支付宝交易号：".$trade_no);
      echo "success"; //请不要修改或删除
      }else {
      echo "fail";

      }
      }
}
