<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IsController extends Controller
{
   	public function login ()
   	{
   		if(request()->session()->get('u_id')){
   			successly('正在为您跳转');
   		}else{
   			fail('您还没登录，请先登录');
   		}
   	}
}
