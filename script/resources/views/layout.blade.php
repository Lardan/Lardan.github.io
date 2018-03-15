@if(!\Request::ajax())
        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CaseUp.One - Дотянись картой до небес!</title>
    <link rel="shortcut icon" href="/images/favicon.ico"/>
    <meta property="vk:title" content="CaseUp.One - Дотянись картой до небес!">
    <meta property="vk:description"
          content="Здесь решает не столько удача, сколько интуиция! Выиграй предметы из различных кейсов CS:GO, угадав 3 из 9.">
    <meta property="vk:text"
          content="Здесь решает не столько удача, сколько интуиция! Выиграй предметы из различных кейсов CS:GO, угадав 3 из 9.">
    <meta property="vk:url" content="http://CaseUp.One/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="CaseUp.One - Дотянись картой до небес!">
    <meta property="og:description"
          content="Здесь решает не столько удача, сколько интуиция! Выиграй предметы из различных кейсов CS:GO, угадав 3 из 9.">
    <meta property="og:site_name" content="CaseUp.One">
    <meta property="og:url" content="http://CaseUp.One/">
    <meta name="csrf-token" content="{!!  csrf_token()   !!}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/tooltipster.css') }}"/>
    <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/noty/packaged/jquery.noty.packaged.min.js') }}"></script>
    <script src="{{ asset('js/tabs.js') }}"></script>
    <script src="{{ asset('js/jquery-tipsy.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/socket.io.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.arcticmodal-0.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script>
        @if(Auth::user()) const admin = '{{$u->is_admin}}';  @endif
        $(function () {
            $('.north').tipsy({gravity: 'n'});
            $('.south').tipsy({gravity: 's'});
            $('.east').tipsy({gravity: 'e'});
            $('.west').tipsy({gravity: 'w'});
        });
    </script>
</head>

<body>

<header>

    <div class="top">
        <div class="width">
           <a href="/"
               @if(Auth::user()) onclick="Page.Go(this.href); return false;"
               @endif class="logotype"></a> 
            <!--  <div class="langs"><a href="/postLang/ru" class="flag flag-ru" data-lang="ru-ru"></a>
                  <a href="/postLang/en" class="flag flag-us" data-lang="en-us"></a></div>-->
            <ul class="menu">
                <li class="mi1"><a href="/"
                                   @if(Auth::user()) onclick="Page.Go(this.href); return false;" @endif>{{ trans('main.main') }}</a>
                </li>
                <li class="mi2"><a href="/partner"
                                   onclick="Page.Go(this.href); return false;">{{ trans('main.partner') }}</a></li>
                <li class="mi3"><a href="/faq" onclick="Page.Go(this.href); return false;">F.A.Q.</a></li>
                <li class="mi4"><a href="/top" onclick="Page.Go(this.href); return false;">{{ trans('main.top') }}</a>
                </li>

            </ul>
        </div>
    </div>
    @if(!Auth::user())
    <div class="middle">
        <div class="block">
            <div class="name">БЫСТРО</div>
            <div class="title">автоматизированная система</div>
            <div class="text">Предложение об обмене от ботов приходит в течение нескольких секунд — нам важно, чтобы вы
                быстро и без проблем получали выигранные вещи.
            </div>
        </div>
        <div class="block">
            <div class="name">ВЫГОДНО</div>
            <div class="title">лучше внутриигрового открытия</div>
            <div class="text">Мало того, что вы сами можете отгадать и получить лучшую вещь из кейса, так и слот с
                гарантированным выигрышем содержит хороший дроп.
            </div>
        </div>
        <div class="block">
            <div class="name">НАДЁЖНО</div>
            <div class="title">вся статистика перед глазами</div>
            <div class="text">Кликните на предмет в лайв-ленте выигрышей и получите исчерпывающую информацию о
                победителе — его ник, ссылку на аккаунт в Steam и историю выигрышей.
            </div>
        </div>
    </div>
@endif
    <div class="bottom">

        <div id="lastWinners">


            @foreach(App\Http\Controllers\Pages::winners() as $i)
                {{--*/ $weap = json_decode($i->weapon);
                 $case = App\Cases::find($i->case);/*--}}

                <a href="/user/{{$i->userid}}" onclick="Page.Go(this.href); return false;"
                   class="item-history block @if (preg_match("/★/i", $weap->fullname)) rare @else {{$weap->type}} @endif"
                   title="{{$i->winner_username}}">
                    <img src="{{$case->images}}" alt="milspec" class="case-image" style="opacity: 0;">
                    <img class="drop-image" src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{$weap->classid}}/56fx42f"
                         alt=""
                         title=""/>
                    <div>{{$weap->fullname}} | {{$weap->spacename}}</div>
                </a>
            @endforeach

        </div>
    </div>

    <div class="stat">
        <div class="block">
            <div class="cardals"></div>
            открыто кейсов
        </div>
        <div class="block">
            <div class="maxuser"></div>
            пользователей
        </div>
        <div class="block">
            <div class="maxcovert"></div>
            получено тайного
        </div>
        <div class="block">
            <div class="maxknife"></div>
            получено ножей
        </div>
    </div>

</header>

<div class="content">
    <!-- <middle> -->
    @endif
    @yield('content')

    @if(!\Request::ajax())
            <!-- </middle> -->
</div>

<footer>
    <div class="width">
        <div class="copyrights">
            <div><span>CaseUp.One</span> - Дотянись картой до небес!</div>
            На нашем сайте вы можете выиграть различные предметы CS:GO. Все обмены проходят в автоматическом режиме с
            помощью ботов Steam.
        </div>
        <ul>
            <li><a target="_blank" href="https://vk.com/">Группа Вконтакте</a></li>
            <li><a onclick="Page.Go(this.href); return false;" href="/faq">F.A.Q.</a></li>
            <li><a href="javascript://" onclick="$('#contacts').arcticmodal()">Контакты</a></li>
        </ul>
    </div>
</footer>

@if(Auth::guest())
    <a href="/login" class="login east" original-title="Войти через Steam"></a>

@else


    <div class="profile">
        <div class="avatar east" original-title="{{ $u->username }}"><a href="/user/{{$u->id}}"
                                                                      onclick="Page.Go(this.href); return false;"><img
                        src="{{$u->avatar}}" alt="" title=""/></a></div>
        <div class="balance">
            Баланс
            <div>{{$u->money}}Р</div>
            <a href="javascript://" onclick="$('#balance').arcticmodal()" class="east"
               original-title="Пополнить баланс"></a>
        </div>
        <a href="/logout" class="exit">Выйти</a>
    </div>
@endif

@if(Auth::User())
    <div style="display: none;">
        <div class="box-modal" id="balance">
            <div class="title">Пополнение баланса
                <div class="box-modal_close arcticmodal-close"></div>
            </div>
            <div class="balance">

                <form method="GET" action="/pay">
                    <input type="number" name="num" min="3" placeholder="Введите сумму" required="">
                    <input type="submit" value="пополнить">
                </form>
            </div>
            <div class="text">Пополнение баланса производится через современную<br>платежную платформу DigiSeller!</div>
        </div>
    </div>
@endif
<div style="display: none;">
    <div class="box-modal" id="contacts">
        <div class="title">Контакты
            <div class="box-modal_close arcticmodal-close"></div>
        </div>
        <ul>
            <li>Техническая поддержка: <span>https://vk.com/</span></li>
            <li>Сообщить о баге/ошибке/предложении: <span>https://vk.com/</span></li>
        </ul>
    </div>
</div>


</body>
</html>
@endif