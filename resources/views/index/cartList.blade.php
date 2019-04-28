@extends('layouts.shop')
@section('content') 
  <body>
  <meta name="csrf-token" content="{{ csrf_token() }}">
   <link href="/shop/layui/css/layui.css" rel="stylesheet" type="text/css">
   <script src="/shop/layui/layui.js"></script>
   <script src="/shop/js/jquery-3.3.1.min.js"></script>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/shop/images/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">2</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(/shop/images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
     
     <div class="dingdanlist">
      <table>
       <tr>
        <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" name="1" id="all" /> 全选</a></td>
       </tr>
      </table>
     </div><!--dingdanlist/-->
     
     <div class="dingdanlist">
      <table>
      @foreach($cartInfo as $k=>$v)
   
       <tr goods_id="{{$v->goods_id}}" gooods_number="{{$v->goods_number}}">
        <td width="4%"><input type="checkbox" name="1" class="check" /></td>
        <td class="dingimg" width="15%"><img src="/shop/images1/{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>下单时间：{{$v->create_time}}</time>
        </td>
        <td >
                 <input type="button" value="-"  class="less" /> 
           <input type="text" value="{{$v->buy_number}}" id="buy_number" name="" class="n_ipt buy_numbers" />
         <input type="button" value="+"  class="add" />
 
        </td>
       </tr>
       <tr>
        <th colspan="4"><strong class="orange">¥36.60</strong></th>
       </tr>
       <tr>
        <td width="100%" colspan="4"><a class="del">删除</a></td>
       </tr>
       @endforeach
      </table>
     </div><!--dingdanlist/-->
     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange" id="count">¥0</strong></td>
       <td width="40%"><a href="javascript:void(0)" class="jiesuan" id="tj">去结算</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
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
    
    <script>
   $(function(){
        layui.use(['layer'],function(){
                var layer=layui.layer;
        // alert('123');
        $('#all').click(function(){
           var _this=$(this);
           var stutus=_this.prop('checked')
           // console.log(_this);
           $('.check').prop('checked',stutus);
           //总价
            countTotal()
        });
        //点击加号
        $(document).on("click",'.add',function(){
            var _this=$(this);
            // console.log(_this);
            var buy_number=parseInt(_this.prev('input').val());
            // console.log(buy_number);
            var goods_number=_this.parents("tr").attr("goods_number");
            // console.log(goods_number);
           if (buy_number >= goods_number) {
            // _this.prev('input').val(goods_number);
            _this.prop('disabled',true);

           }else{
            buy_number+=1;
            _this.prev('input').val(buy_number);
            _this.parents().children('input').first().prop('disabled',false);
           }
           var goods_id=_this.parents('tr').attr('goods_id');
           // console.log(goods_id)
             //更改数据库
            changeBuyNumber(goods_id,buy_number)
            //小计
            getSubTotal(goods_id,_this);
            //复选框
            boxCheck(_this);
          
              //总价
            countTotal();

        });
        //点击减号
        $(document).on("click",'.less',function(){
            // alert('12312');
            var _this=$(this);
            // console.log(_this);
            var buy_number=parseInt(_this.next('input').val());
            // alert(buy_number);
            var goods_number=_this.parents("tr").attr("goods_number");
           if (buy_number<=1) {
            // _this.prev('input').val(goods_number);
            _this.prop('disabled',true);

           }else{
            buy_number-=1;
            _this.next('input').val(buy_number);
            _this.parents().children('input').last().prop('disabled',false);
           }
           var goods_id=_this.parents('tr').attr('goods_id');
        
            //更改数据库
            changeBuyNumber(goods_id,buy_number)
               //小计
            getSubTotal(goods_id,_this);
            //复选框
            boxCheck(_this);
          
              //总价
            countTotal();

        });
        //失去焦点
        $(document).on("blur",'.buy_number',function(){
            // alert('123');
             var _this=$(this);

            var goods_number=_this.parents("tr").attr("goods_number");
           
            var buy_number=_this.val();
            var reg=/^\d{1,}$/;
            if(buy_number==''||buy_number<=1||!reg.test(buy_number)){
                _this.val(1)
            }else if(parseInt(buy_number)>parseInt(goods_number)){
                _this.val(goods_number);
            }else{
                _this.val(parseInt(buy_number));
            }
            var goods_id=_this.parents('tr').attr('goods_id');
            //计算小计
            getSubTotal(goods_id,_this);
            //更改数据库
            changeBuyNumber(goods_id,buy_number)
            
            //复选框
             boxCheck(_this);
             //总价
           countTotal();
        });
        //删除
        $('.del').click(function(){
          // alert('删除')
            var _this=$(this);
            var goods_id=_this.parents('tr').attr('goods_id');
            $.post(
                "{:url('cart/del')}",
                {goods_id:goods_id},
                function(res){
                    // console.log(res);
                    layer.msg(res.font,{icon:res.code});
                    if(res.code==1){
                        _this.parents("tr").remove();
                        countTotal();
                    }
                },
                'json'
            );
        });
        //获取复选框
        $(document).on("click",'.check',function(){
            // alert(12312);
            //计算总价
            countTotal()
        });
        //批量删除
        $('#alldel').click(function(){
            // alert(123)
            var _check=$('.check');
            // console.log(_check)
            var goods_id='';
            _check.each(function(index){
                if($(this).prop('checked')==true){
                    goods_id+=$(this).parents("tr").attr('goods_id')+',';
                    // console.log(goods_id);

                }
            });
            goods_id=goods_id.substr(0,goods_id.length-1);
            // console.log(goods_id);
            $.post(
                "{:url('cart/del')}",
                {goods_id:goods_id},
                function(res){
                    // console.log(res);
                    layer.msg(res.font,{icon:res.code});
                    if(res.code==1){
                        // _this.parents("tr").remove();
                        location.href="{:url('cart/cartlist')}";
                        countTotal();
                    }
                },
                'json',
            );

        });
        //提交
        $('#tj').click(function(){
            // alert(123)
            var _check=$('.check');

            // console.log(_check)
            var goods_id='';
            _check.each(function(index){
                if($(this).prop('checked')==true){
                    goods_id+=$(this).parents("tr").attr('goods_id')+',';
                    // console.log(goods_id);

                }
            });
            goods_id=goods_id.substr(0,goods_id.length-1);
           if(goods_id==''){
            layer.msg('请至少选择一个商品进行结算',{icon:2});
            return false;
           }else{
            $.get(
                "ok123",
                function(res){
                    // console.log(res);
                    if(res.code==1){
                        location.href="pay?goods_id="+goods_id;
                    }else{
                        layer.msg(res.font,{icon:res.code,time:2000},function(){
                            location.href="login";
                        });
                    }
                },
                'json'
            );
           }
        });
        //获取总价格
        function countTotal(){
            var _check=$('.check');
            // console.log(_check);
            var goods_id='';
            _check.each(function(index){
                if($(this).prop('checked')===true){
                    // console.log($(this));
                    goods_id+=$(this).parents('tr').attr("goods_id")+',';
                    // console.log(goods_id);
                }
            })
            goods_id=goods_id.substr(0,goods_id.length-1);
            // console.log(goods_id);
             $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
            $.post(
                    "countTotal",
                    {goods_id:goods_id},
                    function(res){
                    // alert('12312');
                        if(res.code==2){
                            // layer.msg(res.font,{icon:res.code});
                            // alert('12312');  
                        }else if(res.code==1){
                            // alert('12312');
                            // layer.msg(res.font,{icon.res.code});
                            $('#count').text(res.count)
                        }
                    },
                    'json',
                );
        }
        function boxCheck(_this){
            _this.parents("tr").find("input[class='check']").prop('checked',true); 
        }
        function changeBuyNumber(goods_id,buy_number){
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
            $.ajax({
                url: "changeBuyNumber",
                method:'post',
                data:{goods_id:goods_id,buy_number:buy_number},
                async:false,
                dataType:'json',
                success:function(res){
                  if(res.code==2){
                        layer.msg(res.font,{icon:res.code});
                    }else if(res.code==1){
                        layer.msg(res.font,{icon:res.code});
                    }
                }
            });
        }
        function getSubTotal(goods_id,_this){
            $.post(
                "{:url('cart/getSubTotal')}",
                {goods_id:goods_id},
                function(res){
                    console.log(res);
                    _this.parents('td').next('td').text(res);
                },
                'json'
            );

        }

    });
});
    </script>
    @endsection