@extends('layouts.shop')
@section('content')
  <script src="{{asset('shop/js/jquery-3.3.1.min.js')}}"></script>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员登录</h1>
      </div> 
     </header>
     <div class="head-top">
      <img src="/shop/images/head.jpg" />
     </div><!--head-top/-->
     <form action="login_do" method="post" class="reg-login">
     @csrf
      <h3>还没有三级分销账号？点此<a class="orange" href="reg">注册</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name ="u_name" id="u_name" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList"><input type="password" name="password" id="pwd" placeholder="输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" id="tijiao" value="立即登录" />
      </div>
     </form><!--reg-login/-->
     <div class="height1"></div>
     <div class="footNav">
      <dl>
       <a href="index.html">
        <dt><span class="glyphicon glyphicon-home"></span></dt>
        <dd>微店</dd>
       </a>
      </dl>
      <dl>
       <a href="prolist.html">
        <dt><span class="glyphicon glyphicon-th"></span></dt>
        <dd>所有商品</dd>
       </a>
      </dl> 
      <dl>
       <a href="car.html">
        <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
        <dd>购物车 </dd>
       </a>
      </dl>
      <dl>
       <a href="user.html">
        <dt><span class="glyphicon glyphicon-user"></span></dt>
        <dd>我的</dd>
       </a>
      </dl>
      <div class="clearfix"></div>
     </div><!--footNav/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/style.js"></script>
  </body>
</html>
<script>
  $('#u_name').blur(function(){
    // alert(123)
    var _this=$(this).val();
    if(_this==''){
      alert('必填');
      return false;
    }
  });
  $('#pwd').blur(function(){
    var _this=$(this).val();
    if(_this==''){
      alert('必填');
      return false;
    }
  });
  $('#tijiao').click(function(){
    // alert(123123)
    //用户名
    var _this=$('#username').val();
        if(_this==''){
          alert('必填');
          return false;
        }
    //密码
    var _this=$('#pwd').val();
    if(_this==''){
      alert('必填');
      return false;
    }
    $('form').submit();
  });
</script>
@endsection