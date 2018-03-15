$(document).ready(function () {
    CARD.init();
});


$(function () {
    var caseItems = $('#caseItems')
    var casesCarusel = $('#casesCarusel')
    var itemmodal = $('#itemmodal')
    var currentCase = (parent.currentCase)
    var currentCasePrice;
    var upchancePrice = 0;
    ticket = 0;
    oneticket = '';
    twoticket = '';
    thereeticket = '';
    fourticket = '';
    shans = 0;
    currentCase = (parent.currentCase)
    caseimg = $(this).data('img')
    casekey = $(this).data('keyimg')
    namekey = $(this).data('namekey')
    currentCasePrice = $(this).data('price')
    upchancePrice = 0
    $('.upchance').removeClass('active')
    $('#currentCasePrice').text(currentCasePrice)
    $('#upchancePrice').text('')
    $('#curCaseName').text(currentCase)
    $('#caseimg').html('<img src=' + caseimg + '>')
    $('#casekey').html('<img src=' + casekey + '>')
    $('#namekey').text(namekey)
    $('#curCaseName_box').text(currentCase)
    $('.syserrbox').hide()


    $('.upchance').click(function () {
        var that = $(this)
        upchancePrice = that.data('price')
        $('#upchancePrice').text('')

        if (that.is('.active')) {
            that.removeClass('active')
        }
        else {
            $('.upchance').removeClass('active')
            that.addClass('active')
        }
    })
    $(document).on('click', '#extraerase', function (e) {
        var that = $(this);
        var prevHtml = that.html();
        that.text('Подождите...')
        var userPanelError = $('.userPanelError')
        userPanelError.text('')


        full_card++;
        full_card++;
        $('.card-extraerase').hide();
        $('.card-extraarrow-left').hide();
        $('.card-extraarrow-right').hide();
        $('#case-10').innerHTML = '';
        for (var i = 0, l = cardsArray.length; i < l; i++) {
            cardsArray[i].lock(false);
            cardsArray[i].className = 'scratchcase';
        }
        $('#case-10').removeClass('shake animated');
        $('.card-extra').css("opacity", "0.6");
        $('#case-10').addClass('disables');


    })


    $('#godemo').click(function () {
        var that = $(this)
        var prevHtml = that.html();
        that.text('Подождите...').attr('disabled', 'disabled');
        openingCase = true
        $(".game .bilet .play").fadeOut(500)
    })


})

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

function dump(obj) {
    var out = "";
    if (obj && typeof(obj) == "object") {
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }
    } else {
        out = obj;
    }
    alert(out);
}

function n2w(n, w) {
    n %= 100;
    if (n > 19) n %= 10;

    switch (n) {
        case 1:
            return w[0];
        case 2:
        case 3:
        case 4:
            return w[1];
        default:
            return w[2];
    }
}
function getName(name) {
    var arr = name.split('|')
    return (arr.length == 1) ? name : arr[1]
}
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


var caseItems = $('#caseItems')
var casesCarusel = $('#casesCarusel')
var itemmodal = $('#itemmodal')
var currentCase = (parent.currentCase)
var currentCasePrice;
var upchancePrice = 0;

currentCase = (parent.currentCase)
caseimg = $(this).data('img')
casekey = $(this).data('keyimg')
namekey = $(this).data('namekey')
currentCasePrice = $(this).data('price')
upchancePrice = 0
$('.upchance').removeClass('active')
$('#currentCasePrice').text(currentCasePrice)
$('#upchancePrice').text('')
$('#curCaseName').text(currentCase)
$('#caseimg').html('<img src=' + caseimg + '>')
$('#casekey').html('<img src=' + casekey + '>')
$('#namekey').text(namekey)
$('#curCaseName_box').text(currentCase)
$('.syserrbox').hide()

var cardSelected = false;
var cardsArray;
var garant_card;
var off_card;
var scratchcards;
var full_card = 0;

var win = '/images/empty.png';
var lose = '/images/empty.png';
var foreground = '/images/case.png';
var boreground = '/images/garanty.png';


$(document).on('click', ".go-next", function (e) {
    var that = $(this);
    that.text('Подождите...')
    window.location.href = '/login';
});


function loadscratc(id) {

    if (id == 'case-1') {
        ticket = ticket + 1;
        var weapon = cases[0];
    }

    if (id == 'case-2') {
        ticket = ticket + 1;
        var weapon = cases[1];
    }

    if (id == 'case-3') {
        ticket = ticket + 1;
        var weapon = cases[2];
    }

    if (id == 'case-4') {
        ticket = ticket + 1;
        var weapon = cases[3];
    }

    if (id == 'case-5') {
        ticket = ticket + 1;
        var weapon = cases[4];
    }

    if (id == 'case-6') {
        ticket = ticket + 1;
        var weapon = cases[5];
    }

    if (id == 'case-7') {
        ticket = ticket + 1;
        var weapon = cases[6];
    }

    if (id == 'case-8') {
        ticket = ticket + 1;
        var weapon = cases[7];
    }

    if (id == 'case-9') {
        ticket = ticket + 1;
        var weapon = cases[8];
    }
    if (id == 'case-10') {
        var weapon = cases[9];
    }

    var caseid = $('#' + id);

    $('.playcard canvas').css('width', '100%').css('height', '100%').css('position', 'relative');
    $('.descr').show();

    var el = $(
        '<div class="item-scratch ' + weapon[2] + '">' +
        '<div class="picture"><img src="' + getImage(weapon[3], 125, 125) + '"></div>' +
        '<div class="descr"><strong>' + weapon[0] + '</strong><span>' + weapon[1] + '</span></div>' +
        '</div>'
    );

    caseid.prepend(el);

    /* Если отгадал 3 без шанса начало */
    if (shans == 0 && oneticket != '' && id != 'case-10' && twoticket != '' && thereeticket != '' && oneticket.toString() == thereeticket.toString() && twoticket.toString() == thereeticket.toString() && oneticket.toString() == twoticket.toString()) {

        console.log(007);
        var caseItems_one = $('#case-1');
        var caseItems_two = $('#case-2');
        var caseItems_theree = $('#case-3');
        var caseItems_four = $('#case-4');
        var caseItems_five = $('#case-5');
        var caseItems_six = $('#case-6');
        var caseItems_seven = $('#case-7');
        var caseItems_eight = $('#case-8');
        var caseItems_nine = $('#case-9');

        $('#case-10').addClass('disables');
        $('#case-1').innerHTML = '';
        $('#case-2').innerHTML = '';
        $('#case-3').innerHTML = '';
        $('#case-4').innerHTML = '';
        $('#case-5').innerHTML = '';
        $('#case-6').innerHTML = '';
        $('#case-7').innerHTML = '';
        $('#case-8').innerHTML = '';
        $('#case-9').innerHTML = '';
        var el_one = $(
            '<div class="item-scratch ' + cases[0][2] + '">' +
            '<div class="picture"><img src="' + getImage(cases[0][3], 125, 125) + '"></div>' +
            '<div class="descr"><strong>' + cases[0][0] + '</strong><span>' + cases[0][1] + '</span></div>' +
            '</div>'
        );
        var el_two = $(
            '<div class="item-scratch ' + cases[1][2] + '">' +
            '<div class="picture"><img src="' + getImage(cases[1][3], 125, 125) + '"></div>' +
            '<div class="descr"><strong>' + cases[1][0] + '</strong><span>' + cases[1][1] + '</span></div>' +
            '</div>'
        );
        var el_theree = $(
            '<div class="item-scratch ' + cases[2][2] + '">' +
            '<div class="picture"><img src="' + getImage(cases[2][3], 125, 125) + '"></div>' +
            '<div class="descr"><strong>' + cases[2][0] + '</strong><span>' + cases[2][1] + '</span></div>' +
            '</div>'
        );
        var el_four = $(
            '<div class="item-scratch ' + cases[3][2] + '">' +
            '<div class="picture"><img src="' + getImage(cases[3][3], 125, 125) + '"></div>' +
            '<div class="descr"><strong>' + cases[3][0] + '</strong><span>' + cases[3][1] + '</span></div>' +
            '</div>'
        );
        var el_five = $(
            '<div class="item-scratch ' + cases[4][2] + '">' +
            '<div class="picture"><img src="' + getImage(cases[4][3], 125, 125) + '"></div>' +
            '<div class="descr"><strong>' + cases[4][0] + '</strong><span>' + cases[4][1] + '</span></div>' +
            '</div>'
        );
        var el_six = $(
            '<div class="item-scratch ' + cases[5][2] + '">' +
            '<div class="picture"><img src="' + getImage(cases[5][3], 125, 125) + '"></div>' +
            '<div class="descr"><strong>' + cases[5][0] + '</strong><span>' + cases[5][1] + '</span></div>' +
            '</div>'
        );
        var el_seven = $(
            '<div class="item-scratch ' + cases[6][2] + '">' +
            '<div class="picture"><img src="' + getImage(cases[6][3], 125, 125) + '"></div>' +
            '<div class="descr"><strong>' + cases[6][0] + '</strong><span>' + cases[6][1] + '</span></div>' +
            '</div>'
        );
        var el_eight = $(
            '<div class="item-scratch ' + cases[7][2] + '">' +
            '<div class="picture"><img src="' + getImage(cases[7][3], 125, 125) + '"></div>' +
            '<div class="descr"><strong>' + cases[7][0] + '</strong><span>' + cases[7][1] + '</span></div>' +
            '</div>'
        );
        var el_nine = $(
            '<div class="item-scratch ' + cases[8][2] + '">' +
            '<div class="picture"><img src="' + getImage(cases[8][3], 125, 125) + '"></div>' +
            '<div class="descr"><strong>' + cases[8][0] + '</strong><span>' + cases[8][1] + '</span></div>' +
            '</div>'
        );
        el_one.fadeIn(300);
        el_two.fadeIn(300);
        el_theree.fadeIn(300);
        el_four.fadeIn(300);
        el_five.fadeIn(300);
        el_six.fadeIn(300);
        el_seven.fadeIn(300);
        el_eight.fadeIn(300);
        el_nine.fadeIn(300);
        caseItems_one.html(el_one)
        caseItems_two.html(el_two)
        caseItems_theree.html(el_theree)
        caseItems_four.html(el_four)
        caseItems_five.html(el_five)
        caseItems_six.html(el_six)
        caseItems_seven.html(el_seven)
        caseItems_eight.html(el_eight)
        caseItems_nine.html(el_nine)

        setTimeout(function () {
            $('.win').show();
            $('.win img').attr('src', getImages(twoticket[3], 153, 153))
            $('.win .name').text(twoticket[0])
        }, 2000)
        $('.scratchcase').addClass('disables');
    }
    else if (shans == 0 && oneticket != '' && twoticket != '' && thereeticket != '' && id != 'case-10') {

        if (oneticket.toString() == thereeticket.toString()) {
            var weapon = thereeticket;
            for (var i = 0, l = cardsArray.length; i < l; i++) {
                cardsArray[i].lock(true);
                cardsArray[i].className = 'scratchcase disables';
                $('.scratchcard-Cursor').css("display", "none");
            }
            $('.game .arrows').show();
            $('#case-10').removeClass('offcard');
            $('.scratchcase').addClass('disables');
            $('.card-extra').addClass('shake animated');
            $('.card-extra').css("opacity", "1");
            $('.scratchcase').css("cursor", "default");
            $('#case-10').removeClass('disables');
            $('#possible_item').text(weapon[0] + ' | ' + weapon[1]);
            $('.extraPrice').text(0);
            $('.card-extraerase').show();
            $('.scratchcase').css("cursor", "default");
            shans = 1;
        } else if (oneticket.toString() == twoticket.toString()) {
            var weapon = twoticket;
            for (var i = 0, l = cardsArray.length; i < l; i++) {
                cardsArray[i].lock(true);
                cardsArray[i].className = 'scratchcase disables';
                $('.scratchcard-Cursor').css("display", "none");
            }
            $('.game .arrows').show();
            $('#case-10').removeClass('offcard');
            $('.scratchcase').addClass('disables');
            $('.card-extra').addClass('shake animated');
            $('.card-extra').css("opacity", "1");
            $('.scratchcase').css("cursor", "default");
            $('#case-10').removeClass('disables');
            $('#possible_item').text(weapon[0] + ' | ' + weapon[1]);
            $('.extraPrice').text(0);
            $('.card-extraerase').show();
            $('.scratchcase').css("cursor", "default");
            shans = 1;
        } else if (twoticket.toString() == thereeticket.toString()) {
            var weapon = twoticket;
            for (var i = 0, l = cardsArray.length; i < l; i++) {
                cardsArray[i].lock(true);
                cardsArray[i].className = 'scratchcase disables';
                $('.scratchcard-Cursor').css("display", "none");
            }
            $('.game .arrows').show();
            $('#case-10').removeClass('offcard');
            $('.scratchcase').addClass('disables');
            $('.card-extra').addClass('shake animated');
            $('.card-extra').css("opacity", "1");
            $('.scratchcase').css("cursor", "default");
            $('#case-10').removeClass('disables');
            $('#possible_item').text(weapon[0] + ' | ' + weapon[1]);
            $('.extraPrice').text(0);
            $('.card-extraerase').show();
            $('.scratchcase').css("cursor", "default");
            shans = 1;
        }else {


            full_card++;
            for (var i = 0, l = cardsArray.length; i < l; i++) {
                cardsArray[i].lock(true);
                cardsArray[i].className = 'scratchcase disables';
            }
            document.getElementById('arr2').style.backgroundPosition = '-48px';
            $('.game .arrows').show();
            $('.scratchcase').addClass('disables');
            $('#case-10').removeClass('offcard');
            $('#case-10').removeClass('disables');
            $('.card-extra').addClass('shake animated');
            $('.card-extra').css("opacity", "1");
            var weapon = cases[9]


            $('.scratchcase').css("cursor", "default");

            $('.card-extraarrow-right').show();


        }

    } else if (shans == 0  && oneticket != '' && id != 'case-10' && twoticket != '' && thereeticket != '' && fourticket != '') {
        if ((oneticket.toString() == fourticket.toString() && twoticket.toString() == fourticket.toString() && oneticket.toString() == twoticket.toString()) || (twoticket.toString() == fourticket.toString() && thereeticket.toString() == fourticket.toString() && twoticket.toString() == thereeticket.toString()) || (oneticket.toString() == fourticket.toString() && thereeticket.toString() == fourticket.toString() && oneticket.toString() == thereeticket.toString())) {
console.log(555)
            if (oneticket.toString() == fourticket.toString() && twoticket.toString() == fourticket.toString() &&  oneticket.toString() == twoticket.toString()) var swin  = oneticket;
            if (twoticket.toString() == fourticket.toString() && thereeticket.toString() ==  fourticket.toString() &&  twoticket.toString() ==  thereeticket.toString()) var swin  = thereeticket;
            if (oneticket.toString() == fourticket.toString() && thereeticket.toString() == fourticket.toString() && oneticket.toString() ==  thereeticket.toString()) {var swin = oneticket;}
            var caseItems_one = $('#case-1');
            var caseItems_two = $('#case-2');
            var caseItems_theree = $('#case-3');
            var caseItems_four = $('#case-4');
            var caseItems_five = $('#case-5');
            var caseItems_six = $('#case-6');
            var caseItems_seven = $('#case-7');
            var caseItems_eight = $('#case-8');
            var caseItems_nine = $('#case-9');

            $('#case-10').addClass('disables');
            $('#case-1').innerHTML = '';
            $('#case-2').innerHTML = '';
            $('#case-3').innerHTML = '';
            $('#case-4').innerHTML = '';
            $('#case-5').innerHTML = '';
            $('#case-6').innerHTML = '';
            $('#case-7').innerHTML = '';
            $('#case-8').innerHTML = '';
            $('#case-9').innerHTML = '';
            var el_one = $(
                '<div class="item-scratch ' + cases[0][2] + '">' +
                '<div class="picture"><img src="' + getImage(cases[0][3], 125, 125) + '"></div>' +
                '<div class="descr"><strong>' + cases[0][0] + '</strong><span>' + cases[0][1] + '</span></div>' +
                '</div>'
            );
            var el_two = $(
                '<div class="item-scratch ' + cases[1][2] + '">' +
                '<div class="picture"><img src="' + getImage(cases[1][3], 125, 125) + '"></div>' +
                '<div class="descr"><strong>' + cases[1][0] + '</strong><span>' + cases[1][1] + '</span></div>' +
                '</div>'
            );
            var el_theree = $(
                '<div class="item-scratch ' + cases[2][2] + '">' +
                '<div class="picture"><img src="' + getImage(cases[2][3], 125, 125) + '"></div>' +
                '<div class="descr"><strong>' + cases[2][0] + '</strong><span>' + cases[2][1] + '</span></div>' +
                '</div>'
            );
            var el_four = $(
                '<div class="item-scratch ' + cases[3][2] + '">' +
                '<div class="picture"><img src="' + getImage(cases[3][3], 125, 125) + '"></div>' +
                '<div class="descr"><strong>' + cases[3][0] + '</strong><span>' + cases[3][1] + '</span></div>' +
                '</div>'
            );
            var el_five = $(
                '<div class="item-scratch ' + cases[4][2] + '">' +
                '<div class="picture"><img src="' + getImage(cases[4][3], 125, 125) + '"></div>' +
                '<div class="descr"><strong>' + cases[4][0] + '</strong><span>' + cases[4][1] + '</span></div>' +
                '</div>'
            );
            var el_six = $(
                '<div class="item-scratch ' + cases[5][2] + '">' +
                '<div class="picture"><img src="' + getImage(cases[5][3], 125, 125) + '"></div>' +
                '<div class="descr"><strong>' + cases[5][0] + '</strong><span>' + cases[5][1] + '</span></div>' +
                '</div>'
            );
            var el_seven = $(
                '<div class="item-scratch ' + cases[6][2] + '">' +
                '<div class="picture"><img src="' + getImage(cases[6][3], 125, 125) + '"></div>' +
                '<div class="descr"><strong>' + cases[6][0] + '</strong><span>' + cases[6][1] + '</span></div>' +
                '</div>'
            );
            var el_eight = $(
                '<div class="item-scratch ' + cases[7][2] + '">' +
                '<div class="picture"><img src="' + getImage(cases[7][3], 125, 125) + '"></div>' +
                '<div class="descr"><strong>' + cases[7][0] + '</strong><span>' + cases[7][1] + '</span></div>' +
                '</div>'
            );
            var el_nine = $(
                '<div class="item-scratch ' + cases[8][2] + '">' +
                '<div class="picture"><img src="' + getImage(cases[8][3], 125, 125) + '"></div>' +
                '<div class="descr"><strong>' + cases[8][0] + '</strong><span>' + cases[8][1] + '</span></div>' +
                '</div>'
            );
            el_one.fadeIn(300);
            el_two.fadeIn(300);
            el_theree.fadeIn(300);
            el_four.fadeIn(300);
            el_five.fadeIn(300);
            el_six.fadeIn(300);
            el_seven.fadeIn(300);
            el_eight.fadeIn(300);
            el_nine.fadeIn(300);
            caseItems_one.html(el_one)
            caseItems_two.html(el_two)
            caseItems_theree.html(el_theree)
            caseItems_four.html(el_four)
            caseItems_five.html(el_five)
            caseItems_six.html(el_six)
            caseItems_seven.html(el_seven)
            caseItems_eight.html(el_eight)
            caseItems_nine.html(el_nine)

            setTimeout(function () {
                $('.win').show();
                $('.win img').attr('src', getImages(swin[3], 153, 153))
                $('.win .name').text(swin[0]+' | '+swin[1])
            }, 2000)
            $('.scratchcase').addClass('disables');
        }
    }

    else if (shans) {

        full_card++;
        for (var i = 0, l = cardsArray.length; i < l; i++) {
            cardsArray[i].lock(true);
            cardsArray[i].className = 'scratchcase disables';
        }
        document.getElementById('arr2').style.backgroundPosition = '-48px';
        $('.game .arrows').show();
        $('.scratchcase').addClass('disables');
        $('#case-10').removeClass('offcard');
        $('#case-10').removeClass('disables');
        $('.card-extra').addClass('shake animated');
        $('.card-extra').css("opacity", "1");
        var weapon = cases[9]


        $('.scratchcase').css("cursor", "default");

        $('.card-extraarrow-right').show();

    }



}
function loadscratc_one(id) {

    console.log(ticket);

    if (id == 'case-1') {
        ticket = ticket + 1;
        var weapon = cases[0];
    }

    if (id == 'case-2') {
        ticket = ticket + 1;
        var weapon = cases[1];
    }

    if (id == 'case-3') {
        ticket = ticket + 1;
        var weapon = cases[2];
    }

    if (id == 'case-4') {
        ticket = ticket + 1;
        var weapon = cases[3];
    }

    if (id == 'case-5') {
        ticket = ticket + 1;
        var weapon = cases[4];
    }

    if (id == 'case-6') {
        ticket = ticket + 1;
        var weapon = cases[5];
    }

    if (id == 'case-7') {
        ticket = ticket + 1;
        var weapon = cases[6];
    }

    if (id == 'case-8') {
        ticket = ticket + 1;
        var weapon = cases[7];
    }

    if (id == 'case-9') {
        ticket = ticket + 1;
        var weapon = cases[8];
    }
    if (id == 'case-10') {
        var weapon = cases[9];
    }
    if (ticket == 1 && oneticket == '') {
        oneticket = weapon;
    }
    if (ticket == 3 && twoticket == '') {
        twoticket = weapon;
    }
    if (ticket == 5 && thereeticket == '') {
        thereeticket = weapon;
    }
    if (ticket == 7 && fourticket == '') {
        fourticket = weapon;
    }
    console.log(ticket);
    $('.playcard canvas').css('width', '100%').css('height', '100%').css('position', 'relative');
    $('.descr').show();
    var caseid = $('#' + id);
    var el = $(
        '<div class="item-scratch ' + weapon[2] + '">' +
        '<div class="picture"><img src="' + getImage(weapon[3], 125, 125) + '"></div>' +
        '<div class="descr"><strong>' + weapon[0] + '</strong><span>' + weapon[1] + '</span></div>' +
        '</div>'
    );

    caseid.prepend(el);


}


function loadgarant(id) {


    $('.card-extraerase').hide();
    var classname = ('#case-10 .scratchcard-Overlay');
    var classname_two = ('#case-10 .scratchcard-Cursor');
    $(classname).remove();
    $(classname_two).remove();

    var caseItems_one = $('#case-1');
    var caseItems_two = $('#case-2');
    var caseItems_theree = $('#case-3');
    var caseItems_four = $('#case-4');
    var caseItems_five = $('#case-5');
    var caseItems_six = $('#case-6');
    var caseItems_seven = $('#case-7');
    var caseItems_eight = $('#case-8');
    var caseItems_nine = $('#case-9');
    $('#case-1').innerHTML = '';
    $('#case-2').innerHTML = '';
    $('#case-3').innerHTML = '';
    $('#case-4').innerHTML = '';
    $('#case-5').innerHTML = '';
    $('#case-6').innerHTML = '';
    $('#case-7').innerHTML = '';
    $('#case-8').innerHTML = '';
    $('#case-9').innerHTML = '';
    var el_one = $(
        '<div class="item-scratch ' + cases[0][2] + '">' +
        '<div class="picture"><img src="' + getImage(cases[0][3], 125, 125) + '"></div>' +
        '<div class="descr"><strong>' + cases[0][0] + '</strong><span>' + cases[0][1] + '</span></div>' +
        '</div>'
    );
    var el_two = $(
        '<div class="item-scratch ' + cases[1][2] + '">' +
        '<div class="picture"><img src="' + getImage(cases[1][3], 125, 125) + '"></div>' +
        '<div class="descr"><strong>' + cases[1][0] + '</strong><span>' + cases[1][1] + '</span></div>' +
        '</div>'
    );
    var el_theree = $(
        '<div class="item-scratch ' + cases[2][2] + '">' +
        '<div class="picture"><img src="' + getImage(cases[2][3], 125, 125) + '"></div>' +
        '<div class="descr"><strong>' + cases[2][0] + '</strong><span>' + cases[2][1] + '</span></div>' +
        '</div>'
    );
    var el_four = $(
        '<div class="item-scratch ' + cases[3][2] + '">' +
        '<div class="picture"><img src="' + getImage(cases[3][3], 125, 125) + '"></div>' +
        '<div class="descr"><strong>' + cases[3][0] + '</strong><span>' + cases[3][1] + '</span></div>' +
        '</div>'
    );
    var el_five = $(
        '<div class="item-scratch ' + cases[4][2] + '">' +
        '<div class="picture"><img src="' + getImage(cases[4][3], 125, 125) + '"></div>' +
        '<div class="descr"><strong>' + cases[4][0] + '</strong><span>' + cases[4][1] + '</span></div>' +
        '</div>'
    );
    var el_six = $(
        '<div class="item-scratch ' + cases[5][2] + '">' +
        '<div class="picture"><img src="' + getImage(cases[5][3], 125, 125) + '"></div>' +
        '<div class="descr"><strong>' + cases[5][0] + '</strong><span>' + cases[5][1] + '</span></div>' +
        '</div>'
    );
    var el_seven = $(
        '<div class="item-scratch ' + cases[6][2] + '">' +
        '<div class="picture"><img src="' + getImage(cases[6][3], 125, 125) + '"></div>' +
        '<div class="descr"><strong>' + cases[6][0] + '</strong><span>' + cases[6][1] + '</span></div>' +
        '</div>'
    );
    var el_eight = $(
        '<div class="item-scratch ' + cases[7][2] + '">' +
        '<div class="picture"><img src="' + getImage(cases[7][3], 125, 125) + '"></div>' +
        '<div class="descr"><strong>' + cases[7][0] + '</strong><span>' + cases[7][1] + '</span></div>' +
        '</div>'
    );
    var el_nine = $(
        '<div class="item-scratch ' + cases[8][2] + '">' +
        '<div class="picture"><img src="' + getImage(cases[8][3], 125, 125) + '"></div>' +
        '<div class="descr"><strong>' + cases[8][0] + '</strong><span>' + cases[8][1] + '</span></div>' +
        '</div>'
    );
    el_one.fadeIn(300);
    el_two.fadeIn(300);
    el_theree.fadeIn(300);
    el_four.fadeIn(300);
    el_five.fadeIn(300);
    el_six.fadeIn(300);
    el_seven.fadeIn(300);
    el_eight.fadeIn(300);
    el_nine.fadeIn(300);
    caseItems_one.html(el_one)
    caseItems_two.html(el_two)
    caseItems_theree.html(el_theree)
    caseItems_four.html(el_four)
    caseItems_five.html(el_five)
    caseItems_six.html(el_six)
    caseItems_seven.html(el_seven)
    caseItems_eight.html(el_eight)
    caseItems_nine.html(el_nine)

    setTimeout(function () {
        $('.win').show();
        $('.win img').attr('src', getImages(cases[9][3], 153, 153))
        $('.win .name').text(cases[9][0]+' | '+cases[9][1])
    }, 2000)
    $('.scratchcase').addClass('disables');


}


$(document).on('mouseup', '.scratchcase', function (e) {
    var that = $(this);
    id_case = that.data('id');
    if (full_card == 1) {
        for (var i = 0, l = cardsArray.length; i < l; i++) {
            cardsArray[i].lock(false);
            cardsArray[i].className = 'scratchcase';
            cardSelected = false;
        }
        full_card--;
    }
})

function callback(covered, element, container) {
    full_card++;
    for (var i = 0, l = cardsArray.length; i < l; i++) {
        cardsArray[i].lock(true);
        cardsArray[i].className = 'scratchcase disables';
    }
    for (var i = 0, l = cardsArray.length; i < l; i++) {
        if ((cardsArray[i].id == covered.container.id)) {

            var case_id = $(cardsArray[i]).attr("id");
            var id = $(cardsArray[i]).attr("id");
            var classname = ('#' + case_id + ' .scratchcard-Overlay');
            var classname_two = ('#' + case_id + ' .scratchcard-Cursor');
            var classname_tff = ('#' + case_id);
            $(classname).remove();
            $(classname_two).remove();


            cardSelected = false;
            $(classname_tff).addClass('tada animated');
        }


    }

    if (covered.container.id == 'case-10') {
        loadgarant(covered.container.id);
    } else {
        loadscratc(covered.container.id);
    }


}

function counting(covered, element, container) {


    if (!cardSelected && covered > 0) {
        loadscratc_one(element.container.id);
        for (var i = 0, l = cardsArray.length; i < l; i++) {
            if (!(cardsArray[i].id == element.container.id)) {
                cardsArray[i].lock(true);
                cardsArray[i].className = 'disables scratchcase';
                $('scratchcard-Cursor').css("display", "none");
            }
        }


        cardSelected = true;
    }

}


window.onload = function () {

    scratchcards = document.getElementById('scratchcards');
    cardsArray = [document.getElementById('case-1'), document.getElementById('case-2'), document.getElementById('case-3'), document.getElementById('case-4'), document.getElementById('case-5'), document.getElementById('case-6'), document.getElementById('case-7'), document.getElementById('case-8'), document.getElementById('case-9')];


    createScratchCard({
        'container': cardsArray[0],
        'background': lose,
        'foreground': foreground,
        'coin': '/images/coin.png',
        'percent': 55,
        'thickness': 12,
        'counter': 'counting',
        'callback': 'callback'
    });

    createScratchCard({
        'container': cardsArray[1],
        'background': lose,
        'foreground': foreground,
        'coin': '/images/coin.png',
        'percent': 55,
        'thickness': 12,
        'counter': 'counting',
        'callback': 'callback'
    });

    createScratchCard({
        'container': cardsArray[2],
        'background': win,
        'foreground': foreground,
        'coin': '/images/coin.png',
        'percent': 55,
        'thickness': 12,
        'counter': 'counting',
        'callback': 'callback'
    });


    createScratchCard({
        'container': cardsArray[3],
        'background': win,
        'foreground': foreground,
        'coin': '/images/coin.png',
        'percent': 55,
        'thickness': 12,
        'counter': 'counting',
        'callback': 'callback'
    });


    createScratchCard({
        'container': cardsArray[4],
        'background': win,
        'foreground': foreground,
        'coin': '/images/coin.png',
        'percent': 55,
        'thickness': 12,
        'counter': 'counting',
        'callback': 'callback'
    });


    createScratchCard({
        'container': cardsArray[5],
        'background': win,
        'foreground': foreground,
        'coin': '/images/coin.png',
        'percent': 55,
        'thickness': 12,
        'counter': 'counting',
        'callback': 'callback'
    });


    createScratchCard({
        'container': cardsArray[6],
        'background': win,
        'foreground': foreground,
        'coin': '/images/coin.png',
        'percent': 55,
        'thickness': 12,
        'counter': 'counting',
        'callback': 'callback'
    });


    createScratchCard({
        'container': cardsArray[7],
        'background': win,
        'foreground': foreground,
        'coin': '/images/coin.png',
        'percent': 55,
        'thickness': 12,
        'counter': 'counting',
        'callback': 'callback'
    });


    createScratchCard({
        'container': cardsArray[8],
        'background': win,
        'foreground': foreground,
        'coin': '/images/coin.png',
        'percent': 55,
        'thickness': 12,
        'counter': 'counting',
        'callback': 'callback'
    });


    createScratchCard({
        'container': cardsArray[9],
        'background': win,
        'foreground': foreground,
        'coin': '/images/coin.png',
        'percent': 55,
        'thickness': 12,
        'counter': 'counting',
        'callback': 'callback'
    });


    createScratchCard({
        'container': document.getElementById('case-10'),
        'background': win,
        'foreground': boreground,
        'percent': 55,
        'coin': '/images/coin.png',
        'thickness': 12,
        'counter': 'counting',
        'callback': 'callback'
    });


}