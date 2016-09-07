//tips   
window.onresize = function(){
  windowWH(); 
}
//windowWH
function windowWH(){
  var ww = $(window).width();
  var wh =  $(window).height();
  var bghei = 1039;
  var autohei = 1008;
  var ftop = (wh - autohei)/2;
  var bgauto1 = -(bghei-wh)/2;
  var bgauto2 = -(bghei-autohei)/2;
  
  if(ww < wh && wh >= autohei){
	  $(".bgimg").css({"top":bgauto1+"px"});
	  $(".wrap").css({height:wh+"px"});
	  $(".fix-height").css({"padding-top":ftop+"px"});
	  $(".swiper-container").css({height:wh+"px"});
  }else if(ww < wh && wh < autohei){
	  $(".bgimg").css({"top":bgauto2+"px"});
	  $(".wrap").css({height:autohei+"px"});
	  $(".fix-height").css({"padding-top":"0"});    
	  $(".swiper-container").css({height:autohei+"px"});  
  }
}