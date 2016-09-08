<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>华瑞银行</title>
<link rel="stylesheet" href="css/main.css" />
<link rel="stylesheet" href="css/animate.css" />
<script src="js/jquery-2.2.0.min.js"></script>
<script src="js/easeljs-0.8.2.min.js"></script>
<script src="js/preloadjs-0.6.2.min.js"></script>
<script src="js/common.js"></script>
<script src="js/luckDraw.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="js/wx.js"></script>
<!--移动端版本兼容 -->
<script type="text/javascript">
    var phoneWidth = parseInt(window.screen.width);
    var phoneScale = phoneWidth / 640;
    var ua = navigator.userAgent;
    if (/Android (\d+\.\d+)/.test(ua)) {
        var version = parseFloat(RegExp.$1);
        if (version > 2.3) {
            //document.write('<meta name="viewport" content="width=640, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi">');
			document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
        } else {
            document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
        }
    } else {
        document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
    }
</script>
<!--移动端版本兼容 end -->
</head>

<body>
<div class="wrap">

  <!--首页-->
  <div class="p1">
    <div class="bgimg" style="width:640px; height:1039px; background:url(images/noBox-bg.jpg) no-repeat;"></div>
    <div class="fix-height">
      <div class="relative">

        <div class="p1-img1"></div>
        <div class="p1-img2"></div>

        <!--预加载层-->
        <div class="preload-pop">
          <img class="p1-goldShade" src="images/p1-goldshade.png" />
          <div class="p1-goldBox"></div>
          <div class="p1-piont"></div>
          <p class="p1-percent"></p>
        </div>
        <!--预加载层-->

        <!--首页按钮-->
        <div class="btn-group">
          <div class="innerDiv">
          <div class="p1-btn1"></div>
          <div class="p1-btn2"></div>
          <div class="p1-btn3"></div>
          <img class="btn-piont" src="images/btn-piont.png" />
          </div>
        </div>
        <!--首页按钮-->

        <img class="p1-logo" src="images/p1-logo.png" />
        <img class="p1-img3" src="images/p1-img3.png" />

      </div>
    </div>
  </div>
  <!--首页结束-->

  <!--榜单loading-->
  <div class="p2">
    <div class="bgimg" style="width:640px; height:1039px; background:url(images/sload-bg.jpg) no-repeat;"></div>
    <div class="fix-height">
      <div class="relative">

      	<img class="p2-gold" src="images/p2-gold.png" />
        <img class="p2-piont" src="images/p2-piont.png" />
        <img class="p2-img1" src="images/p2-img1.png" />
        <img class="p2-d1" src="images/11.png" />
        <img class="p2-d2" src="images/11.png" />
        <img class="p2-d3" src="images/11.png" />

    	</div>
    </div>
  </div>
  <!--榜单loading-->

  <!--榜单-->
  <div class="p3">
    <div class="bgimg" style="width:640px; height:1039px; background:url(images/noBox-bg.jpg) no-repeat;"></div>
    <div class="fix-height">
      <div class="relative">

        <div class="p3-img1"></div>
        <div class="p3-box">

        </div>

        <div class="p3-btn1">
          <div class="innerDiv">
            <img class="p3-piont1" src="images/p3-piont.png" />
            <img class="p3-piont2" src="images/p3-piont.png" />
          </div>
        </div>

        <div class="p3-group">
          <div class="p3-btn2">
            <img src="images/p3-btn2.png" />
          </div>
          <div class="p3-btn3">
            <img src="images/p3-btn3.png" />
          </div>
        </div>

        <img class="p3-img2 animated swing infinite" src="images/p3-img2.png" />

        <img class="p1-img3" src="images/p1-img3.png" />

      </div>
    </div>
  </div>
  <!--榜单-->

  <!--九宫格抽奖-->
  <div class="p4">
    <div class="bgimg" style="width:640px; height:1039px; background:url(images/box-bg.jpg) no-repeat;"></div>
    <div class="fix-height">
      <div class="relative">

        <div class="p4-img1"></div>
        <div class="myBox">
          <ul class="cj1">
            <li></li>
          </ul>
        </div>

        <img class="p4-light1 p4Light1" src="images/p4-light1.png" />
        <img class="p4-light2" src="images/p4-light2.png" />

        <div class="bt1">
          <div class="innerDiv">
            <img src="images/p4-start.png" />
          </div>
        </div>

        <img class="p1-img3" src="images/p1-img3.png" />

      </div>
    </div>
  </div>
  <!--九宫格抽奖-->

  <!--一等奖-->
  <div class="p5">
  	<div class="bgimg" style="width:640px; height:1039px; background:url(images/p5-bg.jpg) no-repeat;"></div>
    <div class="fix-height">
      <div class="relative">

      	<img class="p5-img1" src="images/p5-img1.png" />
        <input class="name" type="text" />
        <input class="mobil" type="tel" maxlength="11" />
        <input class="adress" type="text" />
        <div class="ma">
        	<img src="images/ma.png" />
        </div>
        <a class="p5-btn" href="javascript:;"></a>

      </div>
    </div>
  </div>
  <!--一等奖-->

  <!--二等奖-->
  <div class="p6">
  	<div class="bgimg" style="width:640px; height:1039px; background:url(images/p6-bg.jpg) no-repeat;"></div>
    <div class="fix-height">
      <div class="relative">

        <p class="p6-info">格瓦拉电影票兑换码</p>
        <p class="p6-num">1240694003759234</p>
      	<div class="ma">
        	<img src="images/ma.png" />
        </div>
        <a class="p6-btn" href="javascript:;"></a>

      </div>
    </div>
  </div>
  <!--二等奖-->

  <!--三等奖-->
  <div class="p8">
  	<div class="bgimg" style="width:640px; height:1039px; background:url(images/p8-bg.jpg) no-repeat;"></div>
    <div class="fix-height">
      <div class="relative">

        <p class="p8-info">优酷7天会员资格</p>
        <p class="p8-num">1240694003759234</p>
      	<div class="ma">
        	<img src="images/ma.png" />
        </div>
        <a class="p6-btn" href="javascript:;"></a>

      </div>
    </div>
  </div>
  <!--三等奖-->

  <!--未中奖-->
  <div class="p7">
  	<div class="bgimg" style="width:640px; height:1039px; background:url(images/p7-bg.jpg) no-repeat;"></div>
    <div class="fix-height">
      <div class="relative">

      	<div class="ma">
        	<img src="images/ma.png" />
        </div>
        <a class="p6-btn" href="javascript:;"></a>

      </div>
    </div>
  </div>
  <!--未中奖-->

  <!--规则-->
  <div class="p9">
    <div class="bgimg" style="width:640px; height:1039px; background:url(images/p9-bg.jpg) no-repeat;"></div>
      <div class="fix-height">
        <div class="relative">

        	<div class="p9-box">
          	<div class="p9-rule"></div>
          </div>

          <div class="p9-close"><img src="images/p9-close.png" /></div>

          <img class="p9-down" src="images/p9-down.png" />

        </div>
      </div>
  </div>
  <!--规则-->


</div>
<script>
$().ready(function(){
    wxShare();
})
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var queue = new createjs.LoadQueue(false);
queue.loadManifest([
	{src:"images/box-bg.jpg", id:"jpg1"},
	{src:"images/sload-bg.jpg", id:"jpg2"},
	{src:"images/p5-bg.jpg", id:"jpg3"},
	{src:"images/p6-bg.jpg", id:"jpg4"},
	{src:"images/p7-bg.jpg", id:"jpg5"},
	{src:"images/p8-bg.jpg", id:"jpg6"},
	{src:"images/p9-bg.jpg", id:"jpg7"},
	{src:"images/p9-img1.png", id:"jpg8"}
]);
queue.on("progress", function(){
	$('.p1-percent').html((queue.progress * 100) + '%');
});
queue.on("complete", function(){
	setTimeout(function(){
		$('.preload-pop').fadeOut();
		$('.btn-group').fadeIn();
	},1500)
});

window.onload = function(){
	windowWH();
	p6fourSpace();
	p8fourSpace();
	timerPiont();

	//点击我的财富按钮，此处需要判断用户中了几等奖
	$('.p1-btn3, .p3-btn1').on('touchend',function(){
		//一等奖
		//$('.p5').fadeIn();
		//二等奖
		//$('.p6').fadeIn();
		//三等奖
		//$('.p8').fadeIn();
		//未中奖
		//$('.p7').fadeIn();
		//p8-info、p6-info、p8-num、p6-num需要后台传过来，分别是中奖项目和号码
	})
    $('.p3-btn1').on('touchend', function(){
        //$('.p2').fadeIn();
        $.post('lottery',function(json){
            var prize = 0;
            if(json && json.ret == 0){
                prize = json.prize;
            }
        	$('.cj1').myLuckDraw({
        		row : 3, //行
        		column : 3, //列
        		spacing: 1, //空隙
        		click : '.bt1', //点击触发
        		time: 1 ,//匀速运动的时间
        		end:function(e){
                    if(e == 1){
                        $('.p5').fadeIn();
                    }
                    else if(e == 2){
                        $('.p6').fadeIn();
                    }
                    else if(e == 3){
                        $('.p8').fadeIn();
                    }
                    else{
                        $('.p7').fadeIn();
                    }
        			//抽奖执行完毕的回调函数,参数e为获奖编号
        			//因为这里是指定的，所以e == 5
        			//$('.jg1 em').text(e);
        		}
        	},prize); //这里tar是确定想要抽奖的目标是几号
        },"JSON");
    });

	//点击进入抽奖页面
	$('.p3-btn1').on('touchend',function () {
        $('.p4').fadeIn();
    });

	//点击进入榜单按钮
	$('.p1-btn1').on('touchend',function(){
		$('.p2').fadeIn();
        $.get('rich/list',function(html){
            $('.p3-box').html(html);
            $('.p2').fadeOut();
            $('.p3').fadeIn();
        })
	})

	//点击进入财富说明
	$('.p1-btn2').on('touchend',function(){
		$('.p9').fadeIn();
	})
	//关闭财富说明
	$('.p9-close').on('touchend',function(){
		$('.p9').fadeOut();
	})

  //点击保存榜单按钮,这里需要后台保存榜单功能，保存的同时执行下面的show()方法
  $('.p3-btn2').on('touchend',function () {
    $('.p3-group').fadeOut();
    $('.p3-btn1').fadeIn();
  })

	//刷新榜单按钮，点击后需要出现一个假的loading画面，我做掉了，然后刷新页面里的table表单
	$('.p3-btn3').on('touchend',function(){
		$('.p3').fadeOut();
		$('.p2').fadeIn();
        $.get('rich/list',function(html){
            $('.p3-box').html(html);
            $('.p2').fadeOut();
            $('.p3').fadeIn();
        })
	});

	//点击出现朋友圈分享层
	$('.p5-btn, .p6-btn').on('touchend',function(){
		$('.share').fadeIn();
	})

	//点击朋友圈分享层关闭
	$('.share').on('touchend',function(){
		$('.share').fadeOut();
	})
}

//格式化方法
function p6fourSpace(){
	var str = $('.p6-num').html();
	str = str.replace(/(\d{4})/g,'$1 ').replace(/\s*$/,'');
	$('.p6-num').html(str);
}
function p8fourSpace(){
	var str = $('.p8-num').html();
	str = str.replace(/(\d{4})/g,'$1 ').replace(/\s*$/,'');
	$('.p8-num').html(str);
}

//数据加载省略号动画
var indexPiont = 1;
function timerPiont(){
	setInterval(function(){
		if(indexPiont <= 3){
			$('.p2-d'+indexPiont).show();
			indexPiont++;
		}else if(indexPiont > 3){
				$('.p2-d1, .p2-d2, .p2-d3').hide();
				indexPiont = 1;
			}
	},800);
}

</script>
</body>
</html>
