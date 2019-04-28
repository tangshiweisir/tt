@extends('layouts.shop')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="{{asset('shop/js/jquery-3.3.1.min.js')}}"></script>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/shop/images/head.jpg" />
     </div><!--head-top/-->
     <form action="reg_do" method="post" class="reg-login">
     @csrf
      <h3>已经有账号了？点此<a class="orange" href="login">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="u_email" placeholder="输入手机号码或者邮箱号" id="username" /></div>
       <div class="lrList2"><input type="text" name="u_code" placeholder="输入短信验证码" id="code" /></div>
       <div class="lrSub">
       <input type="button" value="点这获取验证码" id="sed" />
       </div>
       <div class="lrList"><input type="password" name="password" placeholder="设置新密码（6-18位数字或字母）" id="pwd" /></div>
       <div class="lrList"><input type="password" placeholder="再次输入密码" id="newpwd" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" value="立即注册" id="tijiao" />
      </div>
     </form><!--reg-login/-->
     <div class="height1"></div>
       <script>
        $('#username').blur(function(){
          // alert(12321);
          var _this=$(this).val();
          if(_this==''){
            alert('必填');
            return false;
          }
        });
        
      
        $('#sed').click(function(){
           // alert('123123123123123');
          var username=$('#username').val();
          if(username==''){
            alert('手机号或邮箱必填');
          }
            var reg_do=/^\d{11}$/;
            if(reg_do.test(username)){
              // alert(username);
               $.ajaxSetup({
               headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
              });
              $.ajax({
              method:"post",
              url:"send2",
              data:{username:username,code:''},
            }).done(function(msg){
              console.log(msg);
              // $('#username').next().remove();
              if(msg){
                alert('发送成功');
              }else{
                alert('发送失败')
              }

            });
            }else{
          
          $.ajaxSetup({
     headers: {
     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
    });
          $.ajax({
          method:"post",
          url:"send",
          data:{username:username,code:''},
        }).done(function(msg){
          if(msg==1){
            alert('发送成功');
          }else{
            alert('发送失败')
          }

        });
      }
    });
      
          $('#code').blur(function(){
            var username=$('#username').val();
            var reg_do=/^\d{11}$/;
            if(reg_do.test(username)){
           var _this=$(this).val();
           if(_this==''){
              alert('必填');
              return false;
           }
        $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
      });
          $.ajax({
          method:"post",
          url:"send2",
          data:{code:_this,username:''},
        }).done(function(msg){
          $('#username').next().remove();
          if(msg==1){
            alert('请保证验证码正确');
          }else if(msg==12){
            alert('验证码已过期');
          }

        });
      }else{
           $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
      });
          $.ajax({
          method:"post",
          url:"send",
          data:{code:_this,username:''},
        }).done(function(msg){
          $('#username').next().remove();
          if(msg==1){
            alert('请保证验证码正确');
          }

        });
      }
        })

          $('#pwd').blur(function(){
              // alert('12321');
              var _this=$(this).val();
              if(_this==''){
                alert('必填');
                return false;
              }
              var reg=/^\w{3,12}$/;
              if(!reg.test(_this)){
                alert('请填写3到12位密码');
                return false;
              }
          });
          $('#newpwd').blur(function(){
              var pwd=$('#pwd').val();
              var _this=$(this).val();
              if(pwd!=_this){
                alert('确认密码需要跟密码保持一致')
                return false;
              }
          });

         //用户名
        $('#tijiao').click(function(){
            // alert(123)
            var _this=$('#username').val();
             if(_this==''){
               alert('电话或邮箱必填');
               return false;
        }

          //验证码
            var _this=$('#code').val();
           if(_this==''){
              alert('必填');
              return false;
           }
        $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
      });
          $.ajax({
          method:"post",
          url:"send",
          data:{code:_this,username:''},
        }).done(function(msg){
          $('#username').next().remove();
          if(msg==1){
            alert('请保证验证码正确');
          }

        });
        //密码
          var _this=$('#pwd').val();
              if(_this==''){
                alert('必填');
                return false;
              }
              var reg=/^\w{3,12}$/;
              if(!reg.test(_this)){
                alert('请填写3到12位密码');
                return false;
              }
          //确认密码
             var pwd=$('#pwd').val();
              var _this=$('#newpwd').val();
              if(pwd!=_this){
                alert('确认密码需要跟密码保持一致')
                return false;
              }
                $('form').submit();
         });
    </script>
           @include('public/footre')
    @endsection
  