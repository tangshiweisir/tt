@extends('layouts.shop')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
 <link href="/shop/layui/css/layui.css" rel="stylesheet" type="text/css">
 <script src="/shop/layui/layui.js"></script>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>产品详情</h1>
      </div>
     </header>
     <div id="sliderA" class="slider">
      <img src="/shop/images/image1.jpg" />
      <img src="/shop/images/image2.jpg" />
      <img src="/shop/images/image3.jpg" />
      <img src="/shop/images/image4.jpg" />
      <img src="/shop/images/image5.jpg" />
     </div><!--sliderA/-->
     <table class="jia-len">
      <tr>
       <th><strong class="orange">{{$row->shop_price}}</strong></th>
       <td>

        <input type="text" value="1" id="buy_number" name="" class="n_ipt" />
         <input type="button" value="+"  class="add" /> 
         <input type="button" value="-"  class="less" />  
       </td>
      </tr>
      <tr>
       <td>
        <strong>{{$row->goods_name}}</strong>
        <p class="hui">{{$row->keywords}}</p>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty" id="like"></span></a>
       </td>
      </tr>
     </table>
     <div class="height2"></div>
     
     
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
      <img src="/shop/images1/{{$row->goods_img}}" width="400" height="250" />
     </div><!--proinfoList/-->
     <div class="proinfoList">
      <table border>
          <tr>
            <td>商品名称</td>
            <td>商品价格</td>
            <td>商品图片</td>
            <td>商品库存</td>
            <td>商品关键字</td>
          </tr>
          <tr>
          <input type="hidden" id="g_id" value="{{$row->goods_id}}">
            <td>{{$row->goods_name}}</td>
            <td>{{$row->shop_price}}</td>
            <td><img src="/shop/images1/{{$row->goods_img}}" width="100" height="100" /></td>
            <td><span id="goods_number">{{$row->goods_number}}</span></td>
            <td>{{$row->keywords}}</td>
          </tr>
      </table>

     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息......
     </div><!--proinfoList/-->
     <table class="jrgwc">
      <tr>
       <th>
        <a href="index.html"><span class="glyphicon glyphicon-home" id="like"></span></a>
       </th>
       <td><a href="javascript:void(0)" id="addcart">加入购物车</a></td>
      </tr>
     </table>
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/shop/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/shop/js/bootstrap.min.js"></script>
    <script src="/shop/js/jquery-3.3.1.min.js"></script>
    <script src="/shop/js/style.js"></script>
    <!--焦点轮换-->
    <script src="/shop/js/jquery.excoloSlider.js"></script>
    <script>
    $(function () {
     $("#sliderA").excoloSlider();
    });
  </script>
     <!--jq加减-->
    <script src="/shop/js/jquery.spinner.js"></script>
   <script>
    

    $(function(){
            layui.use(['layer'],function(){
                var layer=layui.layer;
            //收藏
            $('#like').click(function(){
            // alert('21321312');
            var _this=$(this);
            var g_id=$('#g_id').val();
            // alert(g_id)
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
            method:"post",
            url:"like",
            data:{goods_id:g_id},
            }).done(function(msg){
            if(msg==1){
            alert('收藏成功');
            }else if(msg==2){
            alert('请先登录');
            location.href="/login";            
            }else{
              alert('您已收藏过此商品了');
            }

            });
            });



              //加减号
                var goods_number=$('#goods_number').text();
                $(".add").click(function(){
                    // alert('213123')
                    var _this=$(this);
                    var buy_number=parseInt($("#buy_number").val());
                    // console.log(buy_number);
                    if(buy_number>=goods_number){
                        _this.prop("disabled",true);
                    }else{
                        buy_number=buy_number+1;
                        $("#buy_number").val(buy_number);
                        _this.next('input').prop('disabled',false);
                    }
                })
                $(".less").click(function(){
                    // alert('12312');
                    var _this=$(this);
                    // console.log(_this);
                    var buy_number=parseInt($("#buy_number").val());
                    // console.log(buy_number);
                    if(buy_number<=1){
                       _this.prop("disabled",true);
                    }else{
                        // alert('21');
                        buy_number=buy_number-1;
                        $("#buy_number").val(buy_number);
                        _this.prev('input').prop('disabled',false);
                    }
                });
                $("#buy_number").blur(function(){
                    // alert('12312');
                     var _this=$(this);
                    var buy_number=_this.val();
                    var reg=/^\d{1,}$/;
                    if(buy_number==''||buy_number<=1||!reg.test(buy_number)){
                        _this.val(1)
                    }else if(parseInt(buy_number)>parseInt(goods_number)){
                        _this.val(goods_number);
                    }else{
                        _this.val(parseInt(buy_number));
                    }
                   
                });



                //加入购物车
                   $("#addcart").click(function(){
                    // alert('213123');
                    var buy_number=$("#buy_number").val();
                    // console.log(buy_number);
                    var goods_id=$('#g_id').val();
                    // console.log(goods_id);
                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post(
                        "addcart",
                        // return false;
                        {goods_id:goods_id,buy_number:buy_number},
                     function(result){
                            layer.msg(result.font,{icon:result.code,time:2000},function(){
                                if (result.code==1) {
                                    layer.open({
                                        type:0,
                                        content:'加入购物车成功,购物车列表?',
                                        btn:['确定','继续添加'],
                                        yes:function(index,layero)
                                        {
                                            location.href= "/cartList";
                                        },
                                        btn2:function(index,layero){
                                            location.href= "/proinfo?goods_id="+goods_id;
                                        },
                                    });
                                }
                            });
                        },
                        'json'
                        ); 

                });
    });
});
  </script>
  </body>
</html>