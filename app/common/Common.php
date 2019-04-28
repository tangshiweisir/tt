<?php 
use Illuminate\Support\Facades\DB;

	function checkNum($goods_id,$buy_number,$number=0){
        // $goods_moel=model('Goods');
        $goods_number=DB::table('tp_goods')->where('goods_id',$goods_id)->get()->toArray();
        // dd($goods_number);
        $goods_number=array_column($goods_number,'goods_number');
        // dump($goods_number);die;
        $goods_number=$goods_number[0];
        // dd($goods_number);
        if(($buy_number+$number)>$goods_number){
            return $goods_number;
        }else{
            return true;
        }
	}

		function successly($font=''){
			$message=[
			'font'=>$font,
			'code'=>1
			];
			echo json_encode($message);
		}

		function fail($font=''){
			$message=[
			'font'=>$font,
			'code'=>2
			];
			echo json_encode($message);exit;
		}
		 //加密
    function createBase64Str($historyInfo){
      return base64_encode(serialize($historyInfo));
    }
    //解密
    function getBase64Info($str){
      return unserialize(base64_decode($str));
    }
     
?>