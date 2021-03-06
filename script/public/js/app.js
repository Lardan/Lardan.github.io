var socket = io.connect(':2020', {secure: true});
socket
    .on('connect', function () {
        $('#loader').hide();
    })
    .on('disconnect', function () {
        $('#loader').show();
    })
    .on('online', function (data) {
        $('#online').text(Math.abs(data));
    })
    .on('stats', function (data) {
        $('.cardals').text(data.maxgame);
        $('.maxuser').text(data.maxuser);
        $('.maxcovert').text(data.maxcovert);
        $('.maxknife').text(data.maxknife);
    })
    .on('infocase', function (data) {
        for (var i = 0; i < data.length; i++) {
            var cases = data[i];

            if (cases.counstitem > 0) {
                $('.bilets').find('#case_' + cases.id + ' .details.close').css("opacity", "0");
                $('.bilets').find('#case_' + cases.id + ' .details.open').css("opacity", "1");
            } else {
                $('.bilets').find('#case_' + cases.id + ' .details.close').css("opacity", "1");
                $('.bilets').find('#case_' + cases.id + ' .details.open').css("opacity", "0");
            }
        }


    })
    .on('new.winner', function (data) {
        data = JSON.parse(data);
        var lastWinners = $('#lastWinners')

            var el = $(
                ' <a href="/user/' + data.user_id + '" onclick="Page.Go(this.href); return false;" class="item-history block ' + data.type + '" title="' + replaceLogin(data.userName) + '">' +
                '<img src="' + data.caseimage + '" alt="milspec" class="case-image" style="opacity: 0;">' +
                '<img  class="drop-image" src="//steamcommunity-a.akamaihd.net/economy/image/class/730/' + data.classid + '/56fx42f" alt="" title="">' +
                '<div>' + data.firstName + '</div>' +
                '</a>'
            )

            function getRandomArbitary(min, max) {
                return Math.random() * (max - min) + min;
            }

            var stavka = new Audio();
            stavka.src = '/sounds/roulette-start-' + Math.round(getRandomArbitary(1, 11)) + '.mp3';
            stavka.volume = 0.1;
            stavka.play();
            el.hide().addClass('item' + data.id);
            lastWinners.prepend(el)
            el.fadeIn(1000)
            caseitem();

        lastWinners.find(".item-history:nth-of-type(9)").remove();

    })
$(document).ready(function () {
    $('.profile .avatar').each(function(){
        $(this).attr("title", replaceLogin($(this).attr("original-title")));
    });
    $('header .bottom .block').each(function(){
        $(this).attr("title", replaceLogin($(this).attr("title")));
    });
    $('.top-users .block .name a').each(function(){
        $(this).text(replaceLogin($(this).text()));
    });
    $('.profile-u .left .name').each(function(){
        $(this).text(replaceLogin($(this).text()));
    });
    CARD.init();
    caseitem();
});


$(document).ready(function () {
    $("#unitsum").on('change', function() {
        $("#unitcnt").val($(this).val() / 5);
    });

    $('.refill').click(function (e) {
        e.preventDefault();
        $('#refill_block').modal();
    });


});
$(document).on('click', '.faq-cat', function (e) {
    var that = $(this);
    var priced = that.data('cat');
    $('.faq-block').hide('');
    if (that.is('.active')) {
        that.removeClass('active')
        $('.faq-block').hide('');
    }
    else {
        $('.faq-block.' + priced).show('');
        $('.faq-cat').removeClass('active')
        that.addClass('active')
    }
})

$(document).on('click', '.faq-q', function (e) {
    var that = $(this);
    if (that.is('.active')) {
        that.removeClass('active').next(".faq-a").slideToggle()
    }
    else {
        that.addClass('active').next(".faq-a").slideToggle(300)
    }
})

function updateBalance(data) {
    $('.profile .balance div').text(data+'Р');
	$('.profile-u .left .pay').html(data+'Р<a href="javascript://" onclick="$("#balance").arcticmodal()"></a>');
}


function replaceLogin1(login) {
    var reg = new RegExp(BANNED_DOMAINS, 'i');
    return login.replace(reg, "");
}
function replaceLogin(login) {
    function replacer(match, p1, p2, p3, offset, string) {
        var links = ['awpking.com'];
        return links.indexOf(match.toLowerCase()) == -1 ? '' : match;
    }

    login = login.replace('сom', 'com').replace('cоm', 'com').replace('соm', 'com');
    var res = login.replace(/([а-яa-z0-9-]+) *\. *(ru|com|net|gl|su|red|ws|us|pro|one|tk)+/gi, replacer);
    if (!res.trim()) {

        var check = login.toLowerCase().split('awpking.com').length > 1;

        if (check) {
            res = login;
        }
        else {
            res = login.replace(/csgo/i, '').replace(/ *\. *ru/i, '').replace(/ *\. *com/i, '');
            if (!res.trim()) {
                res = 'UNKNOWN';
            }
        }
    }

    res = res.split('script').join('srcipt');
    return res;
}
var uagent = navigator.userAgent.toLowerCase();
var is_safari = ((uagent.indexOf('safari') != -1) || (navigator.vendor == "Apple Computer, Inc."));
var is_ie = ((uagent.indexOf('msie') != -1) && (!is_opera) && (!is_safari) && (!is_webtv));
var is_ie4 = ((is_ie) && (uagent.indexOf("msie 4.") != -1));
var is_moz = (navigator.product == 'Gecko');
var is_ns = ((uagent.indexOf('compatible') == -1) && (uagent.indexOf('mozilla') != -1) && (!is_opera) && (!is_webtv) && (!is_safari));
var is_ns4 = ((is_ns) && (parseInt(navigator.appVersion) == 4));
var is_opera = (uagent.indexOf('opera') != -1);
var is_kon = (uagent.indexOf('konqueror') != -1);
var is_webtv = (uagent.indexOf('webtv') != -1);
var is_win = ((uagent.indexOf("win") != -1) || (uagent.indexOf("16bit") != -1));
var is_mac = ((uagent.indexOf("mac") != -1) || (navigator.vendor == "Apple Computer, Inc."));
var is_chrome = (uagent.match(/Chrome\/\w+\.\w+/i));
if (is_chrome == 'null' || !is_chrome || is_chrome == 0) is_chrome = '';
var ua_vers = parseInt(navigator.appVersion);
var req_href = location.href;
var vii_interval = false;
var vii_interval_im = false;
var scrollTopForFirefox = 0;
var url_next_id = 1;

function caseitem() {
    $(document).ready(function () {
        $(".item-history").mouseover(function () {
            $(this).find(".drop-image").css("opacity", "0");
            $(this).find(".case-image").css("opacity", "1");
        }).mouseout(function () {
            $(this).find(".drop-image").css("opacity", "1");
            $(this).find(".case-image").css("opacity", "0");
        });
        $(".itm").mouseover(function () {
            $(this).find(".drop-image").css("opacity", "0");
            $(this).find(".case-image").css("opacity", "1");
        }).mouseout(function () {
            $(this).find(".drop-image").css("opacity", "1");
            $(this).find(".case-image").css("opacity", "0");
        });

    });

}


$(document).ready(function () {

    var mw = ($('html, body').width() - 800) / 2;
    if ($('.autowr').css('padding-left', mw + 'px').css('padding-right', mw + 'px')) {
        $('body').show();
        history.pushState({link: location.href}, '', location.href);
    }

    $(window).scroll(function () {
        if ($(document).scrollTop() > ($(window).height() / 2))
            $('.scroll_fix_bg').fadeIn(200);
        else
            $('.scroll_fix_bg').fadeOut(200);
    });
});


//AJAX PAGES
/*window.onload = function () {
 window.setTimeout(
 function () {
 window.addEventListener(
 "popstate",
 function (e) {
 e.preventDefault();


 Page.Prev(e.state.link);
 },
 false);
 },
 1);
 }

 var Page = {
 Go: function (h) {
 history.pushState({link: h}, null, h);
 $('.content').html('<div id="loading"><div class="pad_style"><div class="loadstyle"></div></div></div>');
 $('.content').load(h, function (data) {
 }).css('min-height', '0px');
 },
 Prev: function (h) {
 $('.content').load(h, function (data) {
 }).css('min-height', '0px');
 }
 }
 [
 '/js/opencase.js', '/js/scratch.min.js',
 '/js/cases.js'
 ].forEach(function(src) {
 var script = document.createElement('script');
 script.src = src;
 script.async = false;
 document.head.appendChild(script);
 });
 */


window.onload = function () {
    window.setTimeout(function () {
            window.addEventListener('popstate', function (e) {
                    e.preventDefault();
                    if (e.state && e.state.link) Page.Go(e.state.link, {no_change_link: 1});
                },
                false);
        },
        1);
}
var Page = {
    Go: function (h) {
        history.pushState({link: h}, null, h);
        $('.content').html('<div id="loading"><div class="pad_style"><div class="loadstyle"></div></div></div>');
        caseitem();
        $('.content').load(h, function (data) {
            caseitem();
        }).css('min-height', '0px');
    },
    Prev: function (h) {
        $('.content').load(h, function (data) {
            caseitem();
        }).css('min-height', '0px');
    }
}
