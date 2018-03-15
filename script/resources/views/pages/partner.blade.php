
@extends('layout')

@section('content')


    <div class="program">
        <div class="top">
            <div class="width">
                <div class="text">
                    <div class="title">Партнёрская программа</div>
                    <div class="sub">Мы готовы вас отблагодарить за то, что советуете cardup.one!</div>
                    Получайте деньги на счёт каждый раз, когда приглашённый вами пользователь пополнит свой баланс! Если пригласите многих - то сможете и вовсе открывать билеты, не пополняя счёт!
                </div>
                <div class="link">
                    <div>Ваша ссылка для раздачи приглашений:</div>
                    <input type="text" name="" value="http://CaseUp.One/?reg=@if(!Auth::guest()){{$u->id}}@endif">
                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="block"><div>@if(!Auth::guest()){{App\User::where('partner',$u->id)->count()}}@else 0 @endif</div>ЗАРЕГИСТРИРОВАЛИСЬ</div>
            <div class="block"><div>@if(!Auth::guest()){{$money}}%@else 0% @endif</div>ВАШ ПРОЦЕНТ</div>
            <div class="block"><div>@if(!Auth::guest()){{$partnermoney}}руб.@else 0руб. @endif</div>ПРИГЛАШЕННЫЕ ПОПОЛНИЛИ</div>
            <div class="block"><div>@if(!Auth::guest()){{$partnermoney/100*$money}}руб.@else 0руб. @endif</div>ВАШ ЗАРАБОТОК</div>
        </div>
    </div>

    <div class="width">
        <div class="important">
            <div class="title">Важно знать!</div>
            <ol>
                <li>Один пользователь может стать партнёром только одного другого пользователя.</li>
                <li>Вы получаете деньги на счёт сразу же после пополнения баланса вашего партнёра.</li>
                <li>Вся статистика по приглашённым находится также в вашем профиле.</li>
                <li>Пользователям с большим количеством партнёров повышается процент отчислений.</li>
                <li>Если приглашенные пополнили на 5000 рублей, мы увеличиваем ваш процент отчислений до 10%, на 10000 рублей = 15%. Если вам не увеличили процент, обращайтесь в нашу техподдержку (модераторы группы ВК).</li>
            </ol>
        </div>
        <div class="faq-p">
            <div class="title">FAQ - часто задаваемые вопросы</div>
            <div class="block">
                <div class="question">Я передал ссылку многих людям, они по ней зашли, но денег я не получил!</div>
                <div class="answer">Этот пользователь уже зарегистрировался на сайте ранее, либо является партнёром другого пользователя. Запомните - один пользователь может стать партнёром единожды и навсегда.</div>
            </div>
            <div class="block">
                <div class="question">Как можно повысить свой процент прибыли от партнёров?</div>
                <div class="answer">Мы отслеживаем активных пользователей и повышаем процент.</div>
            </div>
        </div>
    </div>
@endsection