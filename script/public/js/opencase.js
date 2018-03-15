$(document).ready(function () {
    CARD.init();
});

function getName(name) {
    var arr = name.split('|');
    return (arr.length == 1) ? name : arr[1];
}
Array.prototype.shuffle = function () {
    var o = this;
    for (var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
    return o;
}
Array.prototype.mul = function (k) {
    var res = []
    for (var i = 0; i < k; ++i) res = res.concat(this.slice(0))
    return res
}
Math.rand = function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


$(function () {
    var openingCase = false;

    function fillCarusel() {
        var casesCarusel = $('#casesCarusel');

        var a1 = cases.filter(function (weapon) {
            return weapon[2] == 'milspec'
        }).slice(0).mul(5).shuffle()
        var a2 = cases.filter(function (weapon) {
            return weapon[2] == 'restricted'
        }).slice(0).mul(5).shuffle()
        var a3 = cases.filter(function (weapon) {
            return weapon[2] == 'classified'
        }).slice(0).mul(4).shuffle()
        var a4 = cases.filter(function (weapon) {
            return weapon[2] == 'covert'
        }).slice(0).mul(4).shuffle()
        var a5 = cases.filter(function (weapon) {
            return weapon[2] == 'rare'
        }).slice(0).mul(2).shuffle()

        var arr = a1.concat(a2, a3, a4, a5).shuffle().shuffle().shuffle()


        //  var arr = cases.slice(0).shuffle();
        var el = ''
        arr.forEach(function (item, i, arr) {

            el += '<div class="itm ' + item[2] + '">' +
                '<img src="' + getImage(item[3], 125, 125) + '" alt="" title=""/> <div class="name"> <div>' + getName(item[0]) + '</div> ' + getName(item[1]) + '</div> </div>'


        });
        casesCarusel.css("margin-left", "0px")
        casesCarusel.html(el)
    }

    fillCarusel();

    var caseCloseAudio = new Audio();
    caseCloseAudio.src = "/sounds/close.wav";
    caseCloseAudio.volume = 0.2;


    $('.go-next').click(function () {
        fillCarusel()
        $('#gogame').click();



    })


    $('#gogame').click(function () {

        var opencaseaudio = new Audio();
        opencaseaudio.src = "/sounds/open.wav";
        opencaseaudio.volume = 0.2;


        openingCase = true

        $.ajax({
            url: '/newgame',
            type: 'POST',
            dataType: 'json',
            data: {

                'case': currentCase,
                action: 'openCase',
                'upchancePrice': 0
            },
            success: function(data) {
                if (data.status == 'success') {
   updateBalance(data.balance);
                    $(".game .bilet .win").fadeOut(500)
                    var weapon = data.weapon



                    $('.slider .itm:nth-child(21)').removeClass('milspec restricted classified covert rare').addClass(weapon.type)
                    $('.slider .itm:nth-child(21) .name').html('<div>'+weapon.fullname+'</div>'+weapon.spacename)
                    $('.slider .itm:nth-child(21)').find('img').attr('src', getImage(weapon.classid, 100, 100))
                    var currentCase = data.currentCase
                    var upchancePrice = data.game
                    var id_item = data.item_id
                    var game_id = data.game_id

                    $(".game .bilet .play").fadeOut(500)
                    var a = 1331 + 16 * 124;
                    $('#casesCarusel').animate({marginLeft: -1 * Math.rand(a, a + 109)}, {
                        duration: 10000,
                        easing: 'swing',
                        //easing: 'easeInSine',
                        start: function () {
                            opencaseaudio.play()
                        },
                        complete: function () {
                            openingCase = false;
                            caseCloseAudio.play()
                            additem(currentCase, upchancePrice, id_item, game_id);

                            setTimeout(function () {



                                $('.win').fadeIn(300);
                                $('.game .bilet .win .name').html(weapon.fullname + ' | ' + weapon.spacename)
                                $('.game .bilet .win img').attr('src', getImage(weapon.classid, 383, 383))
                            }, 1000)

                        }
                    })


                }
                if (data.status == 'error_game') {
                    noty({
                        text: '<div><div><strong>Ошибка</strong><br>' + data.msg + '</div></div>',
                        layout: 'topRight',
                        type: 'error',
                        theme: 'relax',
                        timeout: 8000,
                        closeWith: ['click'],
                        animation: {
                            open: 'animated flipInX',
                            close: 'animated flipOutX'
                        }
                    });


                }
                if (data.status == 'error_steam') {
                    noty({
                        text: '<div><div><strong>Ошибка</strong><br>' + data.msg + '</div></div>',
                        layout: 'topRight',
                        type: 'error',
                        theme: 'relax',
                        timeout: 8000,
                        closeWith: ['click'],
                        animation: {
                            open: 'animated flipInX',
                            close: 'animated flipOutX'
                        }
                    });

                }
                if (data.status == 'error_bot') {
                    noty({
                        text: '<div><div><strong>Ошибка</strong><br>'+data.msg+'</div></div>',
                        layout: 'topRight',
                        type: 'error',
                        theme: 'relax',
                        timeout: 8000,
                        closeWith: ['click'],
                        animation: {
                            open: 'animated flipInX',
                            close: 'animated flipOutX'
                        }
                    });


                }
            }
        })
    })


    function additem(currentCase, upchancePrice, id_item, game_id) {
        $.ajax({
            url: '/select/aj_random_thing',
            type: 'POST',
            dataType: 'json',
            data: {

                'case': currentCase,
                action: 'openCase',
                'id_item': id_item,
                'game_id': game_id,
                'upchancePrice': upchancePrice
            }, success: function (data) {
                var weapon = data.weapon
                if (data.status == 'success') {
                    $(".btn-sell-item span").text(weapon.price);
                    $(".btn-sell-item").data('bsh', data.bsh);
                    $(".btn-sell-item").data('bsh', data.bsh);
                    $(".btn-sell-item").data('order', weapon.id);
                    $('.btn-sell-item').show();
                    $('.btn-takeit').show();
                    $('.game .bilet .win .buttons a:nth-of-type(1)').show();
                }

            }
        })
    }


    $(document).on('click', ".btn-sell-item", function (e) {
        var that = $(this);
        var type = that.is(".sellBotBtn") ? 'sell' : 'wai';
        $('.box-modal_close').show();
        $.ajax({
            url: '/select/aj_sell_or_wait',
            type: 'POST',
            dataType: 'json',
            data: {
                act: 'sellORwait',
                action: 'sellORwait', type: type, bsh: that.data('bsh'), order_id: that.data('order')
            },
            success: function (data) {
                $("#aftersellBlock1").show();
                if (data.status == 'success') {
                    $('.btn-sell-item').hide();
                    $('.btn-takeit').hide();
                    $('.game .bilet .win .buttons a:nth-of-type(1)').hide();
					   updateBalance(data.balance);
                } else {
                }
            },
            error: function (data) {
                alert('Произошла ошибка. Попробуйте еще раз')
            }
        });
    });


})

function getImage(str, w, h) {
    w = w || 384;
    h = h || 384;
    return '//steamcommunity-a.akamaihd.net/economy/image/class/730/' + str + '/' + w + 'fx' + h + 'f';
}
function getImagesq(str, w, h) {
    w = w || 384;
    h = h || 384;
    return '//steamcommunity-a.akamaihd.net/economy/image/class/730/' + str + '/' + w + 'fx' + h + 'f';
}
function getImages(str, w, h) {
    w = w || 384;
    h = h || 384;
    return '//steamcommunity-a.akamaihd.net/economy/image/class/730/' + str + '/' + w + 'fx' + h + 'f';
}
function getImagess(str, w, h) {
    w = w || 384;
    h = h || 384;
    return '//steamcommunity-a.akamaihd.net/economy/image/class/730/' + str + '';

}

