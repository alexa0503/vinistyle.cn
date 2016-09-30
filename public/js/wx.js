var wxData = {};
$('document').ready(function () {
    $.ajax({
        url: '/wx/share',
        dataType: 'json',
        jsonp: 'callback',
        data: {url: location.href},
        success: function (json) {
            wxData = $.extend(wxData,json);
            wx.config({
                debug: wxData.debug || false,
                appId: wxData.appId,
                timestamp: wxData.timestamp,
                nonceStr: wxData.nonceStr,
                signature: wxData.signature,
                jsApiList: [
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                    'onMenuShareQQ'
                ]
            });
        },
        error: function () {
            if( wxData.debug ){
                alert('请求微信分享接口失败~');
            }
            console.log('请求微信分享接口失败~');
        }
    })
})
function wxShare(data){
    wxData = $.extend(wxData,data);
    wx.ready(function () {
        wx.onMenuShareAppMessage({
            title: wxData.title,
            desc: wxData.desc,
            link: wxData.link,
            imgUrl: wxData.imgUrl,
            trigger: function (res) {},
            success: function (res) {
                $.post('/share',function(json){
                    if(json && json.ret == 0 && wxData.shared == 1){
                        lottery();
                    }
                },"JSON");
            },
            cancel: function (res) {},
            fail: function (res) {}
        });
        wx.onMenuShareTimeline({
            title: wxData.title_timeline,
            link: wxData.link,
            imgUrl: wxData.imgUrl,
            trigger: function (res) {},
            success: function (res) {
                $.post('/share',function(json){
                    if(json && json.ret == 0 && wxData.shared == 1){
                        lottery();
                    }
                },"JSON");
            },
            cancel: function (res) {},
            fail: function (res) {}
        });
        wx.onMenuShareQQ({
            title: wxData.title,
            desc: wxData.desc,
            link: wxData.link,
            imgUrl: wxData.imgUrl,
            success: function () {},
            cancel: function () {}
        });
    });
}
