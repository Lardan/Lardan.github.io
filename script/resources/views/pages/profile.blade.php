@extends('layout')

@section('content')
    <script type="text/javascript">
        var current = '{{$item->currentPage()}}';
        var total = '{{$item->lastPage()}}';
        var url = '{{$item->nextPageUrl()}}';
        var user_id = '{{$user->id}}';
        @if(!Request::get('page') || !\Request::ajax())
              $(document).ready(function () {
            $('#getContent').click(function () {
                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    success: function (html) {
                        $(".ItemsUSERS").append(html);
                        if (current == total) {
                            $('#getContent').hide();
                        }
                    }
                });
                return false;
            });
        });
        @endif
    </script>

    @if(Auth::Guest())  {{--*/  $uid = 0; /*--}} @else  {{--*/  $uid = $u->id; /*--}}  @endif
    @if($user->id != $uid)
        @if(!Request::get('page') || !\Request::ajax())
            <div class="profile-u width">
                <div class="left">
                    <img src="{{$user->avatar}}" alt="" title=""/>
                    <div class="name">{{$user->username}}</div>
                    <a href="http://steamcommunity.com/profiles/{{$user->steamid64}}/" target="_blank">Профиль в
                        Steam</a>
                    <div class="pay">{{App\Game::where('case','>',0)->where('userid',$user->id)->count()}}  {{ trans_choice('main.ticket', App\Game::where('case','>',0)->where('userid',$user->id)->count()) }}</div>
                </div>
                <div class="items other-u">
                    <div class="ItemsUSERS">@endif
                        @forelse ($item as $i)
                            {{--*/ $weapon = json_decode($i->weapon);  $case = App\Cases::find($i->case); /*--}}
                            <div class="itm {{$weapon->type}}">

                                <div class="price" title="Цена">{{$weapon->price}} руб.</div>
                                <img src="{{$case->images}}" alt="milspec" class="case-image" style="opacity: 0;">
                                <img class="drop-image"
                                     src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{$weapon->classid}}/60fx60f.png"
                                     alt="" title=""/>
                                <div class="@if($i->buy)send  @elseif($i->send) send @else queue @endif"
                                     title="@if($i->buy) Продано @elseif($i->send) Получено @elseВ ожидании получения@endif"></div>
                                <div class="name">
                                    <div>{{$weapon->fullname}}</div> {{$weapon->spacename}}</div>
                            </div>


                        @empty
                            <b style="font-size: 1.5em;">Пока предметов нет.</b>
                            <br>
                            <br>
                        @endforelse
                    </div>

                    @if(!Request::get('page') || !\Request::ajax())
                        @if($item->lastPage() > 1)
                            <div class="clear"></div>
                            <a id="getContent" class="more">Загрузить еще предметов</a>@endif
                </div>
            </div>
        @endif
    @elseif(!Auth::Guest())
        @if(!Request::get('page') || !\Request::ajax())
            <script>


                $(document).on('click', ".items .itm .pricebby", function (e) {
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
                            if (data.status == 'success') {
                                updateBalance(data.balance);
                                noty({
                                    text: '<div><div><strong>Предмет успешно продан</strong><br>Не забывайте о нас!</div></div>',
                                    layout: 'topRight',
                                    type: 'success',
                                    theme: 'relax',
                                    timeout: 8000,
                                    closeWith: ['click'],
                                    animation: {
                                        open: 'animated flipInX',
                                        close: 'animated flipOutX'
                                    }
                                });
                                $('#item_' + that.data('order') + ' .trade').remove();
                                $('#item_' + that.data('order') + ' .items .itm').addClass('selled');
                                $('#item_' + that.data('order') + ' .items .itm.selled').attr("title", "Продано");
                                $('#item_' + that.data('order') + ' .price').removeClass('pricebby');
                            }
                        },
                        error: function (data) {
                            noty({
                                text: '<div><div><strong>Ошибка</strong><br>Что-то пошло не так , попробуйте ещё раз !</div></div>',
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
                    });
                });

                $(document).on('click', ".btn-resend-item", function (e) {
                    var that = $(this);
                    var bsh = that.data('bsh');
                    var order_id = that.data('order');
                    that.hide();
                    $('#kim_' + order_id).show();
                    var price = that.data('price');

                    $.ajax({
                        url: '/select/aj_sell_transfer',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            act: 'transfer',
                            action: 'transfer', bsh: bsh, order_id: order_id
                        },
                        success: function (data) {

                            if (data.status == 'success') {
                                noty({
                                    text: '<div><div><strong>Предмет успешно отправлен вам</strong><br>Не забывайте о нас!</div></div>',
                                    layout: 'topRight',
                                    type: 'success',
                                    theme: 'relax',
                                    timeout: 8000,
                                    closeWith: ['click'],
                                    animation: {
                                        open: 'animated flipInX',
                                        close: 'animated flipOutX'
                                    }
                                });


                                $('div#item_' + that.data('order') + ' div:nth-of-type(2)').addClass('selled');
                                $('div#item_' + that.data('order') + ' div:nth-of-type(2)').attr("title", "Продано");
                                $('div#item_' + that.data('order') + ' .price').removeClass('pricebby');
                                $('#item_' + that.data('order') + ' .trade').remove();


                            }
                            if (data.status == 'error') {
                                $('#kim_' + order_id).text('Ошибка');
                            }
                        },
                        error: function (data) {
                            that.text('Ошибка')
                            noty({
                                text: '<div><div><strong>Ошибка</strong><br>Что-то пошло не так , попробуйте ещё раз !</div></div>',
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
                    });
                });

                $(document).on('click', ".profile-u .right .link input[type='submit']", function (e) {
                    var that = $(this);
                    var prevHtml = that.html();


                    var userPanelError = $('.userPanelError')


                    $.ajax({
                        url: '/save_link',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            trade_link: that.prev().val()
                        },
                        success: function (data) {
                            if (data.status == 'success') {

                                noty({
                                    text: '<div><div><strong>Ссылка успешно сохранена</strong><br>Не забудьте открыть инвентарь чтобы получить выигрыш!</div></div>',
                                    layout: 'topRight',
                                    type: 'success',
                                    theme: 'relax',
                                    timeout: 8000,
                                    closeWith: ['click'],
                                    animation: {
                                        open: 'animated flipInX',
                                        close: 'animated flipOutX'
                                    }
                                });
                            }
                            else {
                                noty({
                                    text: '<div><div><strong>Ошибка</strong><br>Введите нормальную ссылку и попробуйте ещё раз</div></div>',
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
                        },
                        error: function () {
                            noty({
                                text: '<div><div><strong>Ошибка</strong><br>Введите нормальную ссылку и попробуйте ещё раз</div></div>',
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
                    })
                })

            </script>
            <script type="text/javascript">
                var currentCase = false;
            </script>

            <div class="program">
                <div class="top">
                    <div class="width">
                        <div class="text">
                            <div class="title">Партнёрская программа</div>
                            <div class="sub">Мы готовы вас отблагодарить за то, что советуете cardup.one!</div>
                            Получайте деньги на счёт каждый раз, когда приглашённый вами пользователь пополнит свой
                            баланс! Если пригласите многих - то сможете и вовсе открывать билеты, не пополняя счёт!
                        </div>
                        <div class="link">
                            <div>Ваша ссылка для раздачи приглашений:</div>
                            <input type="text" name="" value="http://CaseUp.One/?reg={{$u->id}}">
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="block">
                        <div>@if(!Auth::guest()){{App\User::where('partner',$u->id)->count()}}@endif</div>
                        ЗАРЕГИСТРИРОВАЛИСЬ
                    </div>
                    <div class="block">
                        <div>@if(!Auth::guest()){{$money}}@endif%</div>
                        ВАШ ПРОЦЕНТ
                    </div>
                    <div class="block">
                        <div>@if(!Auth::guest()){{$partnermoney}}@endifруб.</div>
                        ПРИГЛАШЕННЫЕ ПОПОЛНИЛИ
                    </div>
                    <div class="block">
                        <div>@if(!Auth::guest()){{$partnermoney/100*$money}}@endifруб.</div>
                        ВАШ ЗАРАБОТОК
                    </div>
                </div>
            </div>

            <div class="profile-u width">
                <div class="left">
                    <img src="{{$u->avatar}}" alt="" title=""/>
                    <div class="name">{{$u->username}}</div>
                    <a href="http://steamcommunity.com/profiles/{{$u->steamid64}}/"
                       target="_blank">Профиль в Steam</a>
                    <div class="pay">{{$u->money}}р<a href="javascript://" onclick="$('#balance').arcticmodal()"></a>
                    </div>
                </div>
                <div class="right">
                    <div class="link">
                        <div>Ваша ссылка на обмен (Trade-URL; можете изменить в любое время; <a
                                    href="http://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url"
                                    target="_blank">искать здесь</a>):
                        </div>
                        <div class="clear"></div>
                        <input type="text" value="{{$u->trade_link}}" name="url"
                               placeholder="https://steamcommunity.com/tradeoffer/new/?partner=186227607&amp;token=XXXXXXXX">
                        <input type="submit" name="" value="Сохранить">
                    </div>
                    <div class="info">
                        <div class="icon"></div>
                        <div class="txt">
                            <div class="name">ОСТЕРЕГАЙТЕСЬ МОШЕННИКОВ, добавляющихся к вам в Steam под видом
                                администраторов/модераторов/помощников cardup.one
                            </div>
                            <div class="text">ЗАПОМНИТЕ - мы никогда не будем добавляться к вам в друзья в Steam и
                                предлагать продать ваши предметы по двойной цене, давать ссылки на скачивание чего-либо
                                (скорее всего вредоносные программы и/или стиллеры) и т.д. ЭТО ВСЕ ОБМАН! У ВАС УКРАДУТ
                                ВАШИ ПРЕДМЕТЫ! ОФИЦИАЛЬНЫЕ КОНТАКТЫ администраторов можете найти у нас в группе
                                Вконтакте.
                            </div>
                        </div>
                    </div>
                    <div class="info">
                        <div class="icon"></div>
                        <div class="txt">
                            <div class="name">ПРОВЕРЬТЕ ОБМЕНЫ на вашем аккаунте Steam</div>
                            <div class="text">Иначе наш бот не сможет отправить вам ваши предметы.</div>
                        </div>
                    </div>
                    <div class="info">
                        <div class="icon"></div>
                        <div class="txt">
                            <div class="name">Если не успели забрать предмет, а также по любым другим вопросам</div>
                            <div class="text">Если вы не заберете ваш предмет в течение часа, на ваш баланс возратится
                                полная его стоимость (исходя из цен на <a href="#">торговой площадке Steam</a>). Ответы
                                на все ваши вопросы есть на специальной <a href="#">страничке</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="items">
                <div class="title">Ваши предметы</div>
                <div class="width">
                    <div class="ItemsUSERS">@endif
                        @forelse ($item as $i)
                            {{--*/ $weapon = json_decode($i->weapon);  $case = App\Cases::find($i->case); /*--}}
                            <div class="itm {{$weapon->type}}" id="item_{{$i->id}}">
                                @if($i->buy == 0 and $i->send == 0)
                                    <div class="trade" style="display: block;">
                                        <div class="info">
                                            <!--  <div class="time">2:30</div>-->
                                            <div class="btn-resend-item" data-order="{{$i->id}}"
                                                 data-bsh="{{\Crypt::encrypt($i->id)}}">Получить
                                            </div>
                                        </div>
                                    </div>@endif
                                <div class="price  @if($i->buy == 0 and $i->send == 0) pricebby" data-order="{{$i->id}}"
                                     data-bsh="{{\Crypt::encrypt($i->id)}}" style=" cursor: pointer; " @endif "
                                title=" @if($i->buy == 0 and $i->send == 0)Продать предмет@elseЦена@endif
                                ">{{$weapon->price}} руб.
                            </div>
                            <img src="{{$case->images}}" alt="milspec" class="case-image" style="opacity: 0;">
                            <img class="drop-image"
                                 src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{$weapon->classid}}/60fx60f.png"
                                 alt="" title=""/>
                            <div class="@if($i->buy)send  @elseif($i->send) send @else queue @endif"
                                 title="@if($i->buy == 1) Продано @elseif($i->send) Получено @elseВ ожидании получения@endif"></div>
                            <div class="name">
                                <div>{{$weapon->fullname}}</div> {{$weapon->spacename}}</div>
                    </div>

                    @empty
                        <b style="font-size: 1.5em;">Пока предметов нет.</b>
                        <br>
                        <br>
                    @endforelse
                </div>
                @if(!Request::get('page') || !\Request::ajax())
                    @if($item->lastPage() > 1)
                        <div class="clear"></div>
                        <a id="getContent" class="more">Загрузить еще предметов</a>@endif

            </div>   </div>@endif
    @endif

@endsection