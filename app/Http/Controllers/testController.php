<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redis;

use Illuminate\Http\Request;

class testController extends Controller
{
    
	public function index(){
		$value = request()->cookie('cartStr');
		$history=$this->getBase64Info($value);
		dd($history);
		// return $history;
		// return $this->aa();

		
	}
	public function aa(){
		return response('欢迎来到 Laravel 学院')->cookie(
		 'gg', '学院君', 30
		);
	}

 //加密
    public function createBase64Str($historyInfo){
      return base64_encode(serialize($historyInfo));
    }
    //解密
    public function getBase64Info($str){
      return unserialize(base64_decode($str));
    }

}
