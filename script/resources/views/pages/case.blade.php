@extends('layout')

@section('content')



<script type="text/javascript">
    var currentCase = '{{$case->name}}';
    var cases = [@foreach(App\Items::where('case_id',$case->id)->get() as $i)           {{--*/ $i->market_name = str_replace(' (После полевых испытаний)','',$i->market_name);
        $i->market_name = str_replace('(После полевых испытан','',$i->market_name);
        $i->market_name = str_replace(' (Прямо с завода)','',$i->market_name);
        $i->market_name = str_replace(' (Закаленное в боях)','',$i->market_name);
        $i->market_name = str_replace(' (Немного поношенное)','',$i->market_name);
        $i->market_name = str_replace(' (Поношенное)','',$i->market_name);
        $name = explode(' | ',$i->market_name);  /*--}}    ["{{$name[0]}}",
     "{{$name[1]}}",
     @if(preg_match("/★/i", $i->market_name))"rare" @else "{{$i->type}}" @endif,
     "{{$i->classid}}"], @endforeach
     ];
</script>
<script type="text/javascript" src="{{ asset('js/opencase.js') }}"></script>
<div class="game" style="padding: 27px 0 22px;">
    <div class="bilet">
        @if(!Auth::guest() and $u->money >= 0)
        <div class="play">
            <button  id="gogame"  class="go-g">Открыть кейс за {{$case->price}} руб.</button>
        </div>
        @elseif(!Auth::guest())
        <div class="play">
            <a href="javascript:void(0)" class="go-g balance " disabled="disabled">Открыть кейс
                за {{$case->price}} руб.</a>
            <div class="sub">У вас недостаточно средств!</div>
            <a href="javascript://" onclick="$('#balance').arcticmodal()" class="pay-g">Пополнить баланс</a>
        </div>@else
        <div class="play">
            <a href="javascript:void(0)" class="go-g balance " disabled="disabled">Открыть кейс
                за {{$case->price}} руб.</a>
            <a href="/login">
                <div class="sub">Пожалуйста авторизуйтесь!</div>
            </a>

        </div>
        @endif
        <div class="play card-extraerase" style="display: none;">
            <a id="extraerase" class="attempt">
                <div>+1 попытка</div>
                дополнительный ход за <span class="extraPrice">5</span> руб.</a>
            <div class="text"><span>Есть шанс выиграть</span>
                <div id="possible_item">M4A1-S | Нитро</div>
                Испытаете удачу или сразу заберёте<br>гарантированный выигрыш?
            </div>
        </div>
        <div class="win" style="display: none;">
            <div class="name">Это ваш USP-S | Лесные листья</div>
            <div>Заберите предмет в профиле в течение часа!</div>
            <img src="" alt="" title=""/>
            <!-- <a href="#" class="see">Осмотреть в игре</a>-->
            <div class="buttons">
                <div class="btn-sell-item" href="#">Продать за <span></span> руб.</div>
                <div class="go-next">Попробовать ещё</div>
                <a href="@if(Auth::user())/user/{{$u->id}}@endif">Забрать сейчас</a>
            </div>
        </div>
        <div class="inbox">


            <div id="scrollerContainer">
                <div id="caruselLine"></div>
                <div id="caruselOver"></div>
                <div id="aCanvas">
                    <div id="casesCarusel" class="slider"></div>
                </div>
            </div>


        </div>
    </div>

    <div class="info">
        <div class="item">
            <img src="{{$case->images}}" alt="" title=""/>
            <ul>
                <li>{{$case->name}}</li>
                <li></li>
            </ul>
        </div>


        <div class="rights">
            <div class="title">3 Основных правила Caseup.one:</div>
            <ol>
                <li>Играть каждый день</li>
                <li>Оставлять отзывы</li>
                <li>Рассказывать друзьям</li>
            </ol>
        </div>
    </div>

</div>

<div class="items other-g width">
    <div class="width">
        <div class="title">Содержимое билета</div>


        @foreach(App\Items::where('case_id',$case->id)->get() as $i)
        {{--*/ $i->market_name = str_replace(' (После полевых испытаний)','',$i->market_name);
        $i->market_name = str_replace('(После полевых испытан','',$i->market_name);
        $i->market_name = str_replace(' (Прямо с завода)','',$i->market_name);
        $i->market_name = str_replace(' (Закаленное в боях)','',$i->market_name);
        $i->market_name = str_replace(' (Немного поношенное)','',$i->market_name);
        $i->market_name = str_replace(' (Поношенное)','',$i->market_name);
        $name = explode('|',$i->market_name);  /*--}}
        <div href="https://csgo.tm/?search={{$i->market_name}}"
             class="itm  @if (preg_match("/★/i", $i->market_name)) rare @else {{$i->type}}@endif">
        <img src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{$i->classid}}/65fx65f"
             alt="" title=""/>
        <div class="name">
            <div>{{$name[0]}}</div> {{$name[1]}}</div>
    </div>

    @endforeach

</div>
</div>
@endsection