<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function index ()
    {
    	$data=DB::table('tp_coupon as c')
    			->join('tp_goods','c.goods_id','=','tp_goods.goods_id')
    			->get();
    			// dd($data);
    	return view('index/discount',['data'=>$data]);
    }
}
