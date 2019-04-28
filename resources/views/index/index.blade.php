@extends('layouts.shop')
@section('content')
  <body>
    <div class="maincont">
     <div class="head-top">
      <img src="/shop/images/head.jpg" />
      <dl>
       <dt><a href="user.html"><img src="/shop/images/touxiang.jpg" /></a></dt>
       <dd>
        <h1 class="username">三级分销终身荣誉会员</h1>
        <ul>
         <li><a href="prolist.html"><strong>34</strong><p>全部商品</p></a></li>
         <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
         <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
         <div class="clearfix"></div>
        </ul>
       </dd>
       <div class="clearfix"></div>
      </dl>
     </div><!--head-top/-->
     <form action="#" method="get" class="search">
      <input type="text" class="seaText fl" />
      <input type="submit" value="搜索" class="seaSub fr" />
     </form><!--search/-->
     @if(request()->session()->get('u_id'))
        <ul class="reg-login-click">
          欢迎--{{request()->session()->get('username')}}--登录本商城       <a href="loginaout">退出</a>
        </ul>
        <ul class="reg-login-click">
          <b color='red'><a href="youhui">这里是优惠的商品点击即去</a></b>
        </ul>
     @else
      <ul class="reg-login-click">
      <li><a href="login">登录</a></li>
      <li><a href="reg" class="rlbg">注册</a></li>
      <div class="clearfix"></div>
     </ul><!--reg-login-click/-->
     @endif
     <div id="sliderA" class="slider">
      <img src="/shop/images/image1.jpg" />
      <img src="/shop/images/image2.jpg" />
      <img src="/shop/images/image3.jpg" />
      <img src="/shop/images/image4.jpg" />
      <img src="/shop/images/image5.jpg" />
     </div><!--sliderA/-->
     <ul class="pronav">
      <li><a href="prolist.html">晋恩干红</a></li>
      <li><a href="prolist.html">万能手链</a></li>
      <li><a href="prolist.html">高级手镯</a></li>
      <li><a href="prolist.html">特异戒指</a></li>
      <div class="clearfix"></div>
     </ul><!--pronav/-->
     <div class="index-pro1">
     @foreach($data as $k=>$v)
      <div class="index-pro1-list">
       <dl>
        <dt><a href="proinfo?goods_id={{$v->goods_id}}"><img src="/shop/images1/{{$v->goods_img}}"  width="293" height="187"/></a></dt>
        <dd class="ip-text"><a href="proinfo.html">{{$v->goods_name}}</a><span>已售：488</span></dd><br><br>
        <dd class="ip-price"><strong>¥299</strong> <span>¥599</span></dd>
       </dl>

      </div>
      @endforeach
    {{$data->links()}}
     
    
      
      <div class="clearfix"></div>
     </div><!--index-pro1/-->
     <div class="prolist">
     @if($historyInfo)
        @foreach($historyInfo as $k=>$v )
      <dl>
       <dt><a href="proinfo.html"><img src="/shop/images1/{{$v->goods_img}}"  width="293" height="187"/></a></dt>
       <dd>
        <h3><a href="proinfo.html">{{$v->goods_name}}</a></h3>
        <div class="prolist-price"><strong>价格：{{$v->shop_price}}</div>
        <div class="prolist-price"><strong>库存:{{$v->goods_number}}</div>
       </dd>

       <div class="clearfix"></div>
      </dl>
      @endforeach
      @else
          <h1>浏览记录暂无数据暂无数据</h1>
      @endif
  
     </div><!--prolist/-->
     <div class="joins"><a href="fenxiao.html"><img src="/shop/images/jrwm.jpg" /></a></div>
     <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>
     
     <div class="height1"></div>
      @include('public/footre')
    @endsection
   