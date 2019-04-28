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
   
     @foreach($data as $k=>$v)
      <div class="index-pro1-list">
       <dl>
        <dt><a href="proinfo?goods_id={{$v->goods_id}}"><img src="/shop/images1/{{$v->goods_img}}"  width="293" height="187"/></a></dt>
        <dd class="ip-text"><a href="proinfo.html">{{$v->goods_name}}</a><span>已售：488</span></dd><br><br>
        <dd class="ip-price"><strong>价格：{{$v->shop_price}}</strong></dd>
       </dl>

      </div>
      @endforeach
     
    
      
      <div class="clearfix"></div>
     </div><!--index-pro1/-->
     <div class="prolist">
     
  
     </div><!--prolist/-->
     <div class="joins"><a href="fenxiao.html"><img src="/shop/images/jrwm.jpg" /></a></div>
     <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>
     
     <div class="height1"></div>
      @include('public/footre')
    @endsection
   