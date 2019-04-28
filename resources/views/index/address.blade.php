@extends('layouts.shop')
@section('content')

  <body>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="/shop/layui/css/layui.css" rel="stylesheet" type="text/css">
   <script src="/shop/layui/layui.js"></script>
   <script src="/shop//shop/js/jquery-3.3.1.min.js"></script>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>收货地址</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/shop/images/head.jpg" />
     </div><!--head-top/-->
     <form action="login.html" method="get" class="reg-login">
      <div class="lrBox">
       <div class="lrList"><input type="text" id="address_name" placeholder="收货人" /></div>
       <div class="lrList"><input id="address_detail" type="text" placeholder="详细地址" /></div>
       
        <select id="province" class="changearea">
         <option>请选择</option>
          @foreach($data as $k=>$v)
         <option value="{{$v->id}}">{{$v->name}}</option>
         @endforeach
        </select>
      
        <select   id="city" class="changearea">
         <option value="0" selected="selected">请选择...</option>
        </select>
        <select  id="area">
          <option value="0" selected="selected" class="changearea">请选择...</option>

        </select>
       
       <div class="lrList"><input type="text" id="address_tel" placeholder="手机" /></div>
       <b color="red">是否设为默认</b> 是<input type="radio"  id="is_default"/>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" value="保存" id="add" />
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
      <dl class="ftnavCur">
       <a href="user.html">
        <dt><span class="glyphicon glyphicon-user"></span></dt>
        <dd>我的</dd>
       </a>
      </dl>
      <div class="clearfix"></div>
     </div><!--footNav/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/shop/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/shop/js/bootstrap.min.js"></script>
    <script src="/shop/js/style.js"></script>
    <!--jq加减-->
    <script src="/shop/js/jquery.spinner.js"></script>
   <script>
	$('.spinnerExample').spinner({});
   </script>
  </body>
</html>
<script>
  $(document).on('change','.changearea',function(){
    var _this=$(this);
    var _option="<option value='0' selected='selected'>请选择...</option>"
    _this.nextAll('select').html(_option)
    var id=_this.val();
    // console.log(id)
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(
        "/getarea",
        {id:id},
        function(res){
          // console.log(res);
           _option="<option value='0' selected='selected'>请选择...</option>"
          for(var i in res){
            _option+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>"

          }
          // console.log(_option);
          // console.log(_this);
          _this.next('select').html(_option);
        },
        'json',
      );
  });




  $('#add').click(function(){
    // alert('123');return false
    var obj={};
    obj.province=$('#province').val();
    obj.city=$('#city').val();
    obj.area=$('#area').val();
    obj.address_name=$('#address_name').val();
    obj.address_detail=$('#address_detail').val();
    obj.address_tel=$('#address_tel').val();
    var is_default=$('#is_default').prop('checked');
    // console.log(obj);return false
    if(is_default===true){
      obj.is_default=1;
    }else{
      obj.is_default=2;
    }
    $.post(
        "address_add",
        obj,
        function(res){
           if(res==1){
            alert('添加成功')
          // window.location.reload();
          location.href="cartList";
        }
        }
      );


});
</script>