
@extends('layout')

@section('content')
   <!--<div id="tabs-1"><div class="tabs">

            <div class="buttons" id="buttons">
                <div>ТОП по дропу</div>
                <a href="#tab-1">24 часа</a>
                <a href="#tab-2">всё время</a>
            </div>

            <div class="tab" id="tab-1">
                <div class="width">
                    <div class="block">
                        <div class="info">
                            <div class="user"><img src="avatar.png" alt="" title="" />Мистер гусь</div>
                            <div class="price">109P</div>
                        </div>
                        <img src="https://steamcommunity-a.akamaihd.net/economy/image/class/730/926978479/60fx60f.png" alt="" title="" />
                        <div class="name">Керамбит Дамасская сталь</div>
                    </div>
                    <div class="block">
                        <div class="info">
                            <div class="user"><img src="avatar.png" alt="" title="" />Мистер гусь</div>
                            <div class="price">109P</div>
                        </div>
                        <img src="https://steamcommunity-a.akamaihd.net/economy/image/class/730/926978479/60fx60f.png" alt="" title="" />
                        <div class="name">Керамбит Дамасская сталь</div>
                    </div>
                    <div class="block">
                        <div class="info">
                            <div class="user"><img src="avatar.png" alt="" title="" />Мистер гусь</div>
                            <div class="price">109P</div>
                        </div>
                        <img src="https://steamcommunity-a.akamaihd.net/economy/image/class/730/926978479/60fx60f.png" alt="" title="" />
                        <div class="name">Керамбит Дамасская сталь</div>
                    </div>
                    <div class="block">
                        <div class="info">
                            <div class="user"><img src="avatar.png" alt="" title="" />Мистер гусь</div>
                            <div class="price">109P</div>
                        </div>
                        <img src="https://steamcommunity-a.akamaihd.net/economy/image/class/730/926978479/60fx60f.png" alt="" title="" />
                        <div class="name">Керамбит Дамасская сталь</div>
                    </div>
                </div>
            </div>

            <div class="tab" id="tab-2">
                <div class="width">
                    <div class="block">
                        <div class="info">
                            <div class="user"><img src="avatar.png" alt="" title="" />Мистер гусь</div>
                            <div class="price">209P</div>
                        </div>
                        <img src="https://steamcommunity-a.akamaihd.net/economy/image/class/730/926978479/60fx60f.png" alt="" title="" />
                        <div class="name">Керамбит Дамасская сталь</div>
                    </div>
                    <div class="block">
                        <div class="info">
                            <div class="user"><img src="avatar.png" alt="" title="" />Мистер гусь</div>
                            <div class="price">209P</div>
                        </div>
                        <img src="https://steamcommunity-a.akamaihd.net/economy/image/class/730/926978479/60fx60f.png" alt="" title="" />
                        <div class="name">Керамбит Дамасская сталь</div>
                    </div>
                    <div class="block">
                        <div class="info">
                            <div class="user"><img src="avatar.png" alt="" title="" />Мистер гусь</div>
                            <div class="price">209P</div>
                        </div>
                        <img src="https://steamcommunity-a.akamaihd.net/economy/image/class/730/926978479/60fx60f.png" alt="" title="" />
                        <div class="name">Керамбит Дамасская сталь</div>
                    </div>
                    <div class="block">
                        <div class="info">
                            <div class="user"><img src="avatar.png" alt="" title="" />Мистер гусь</div>
                            <div class="price">209P</div>
                        </div>
                        <img src="https://steamcommunity-a.akamaihd.net/economy/image/class/730/926978479/60fx60f.png" alt="" title="" />
                        <div class="name">Керамбит Дамасская сталь</div>
                    </div>
                </div>
            </div>

        </div></div>-->

    <div class="top-users">
        @foreach($users as $i)
            @if($i->place < 4)
        <div class="block">
            <div class="name"><a onclick="Page.Go(this.href); return false;" href="/user/{{$i->id}}">{{$i->username}}</a></div>
            <div class="avatar">
                <div class="numb">{{ $place++ }}</div>
                <a onclick="Page.Go(this.href); return false;" href="/user/{{$i->id}}">  <img src="{{$i->avatar}}" alt="" title="" /></a>
            </div>
            <div class="left"><div>{{  round($i->top_value) }}Р</div>В ПЛЮСЕ</div>
            <div class="right" style="    text-transform: uppercase;"><div>{{ $i->games_played  }}</div>{{ trans_choice('main.ticket', $i->games_played ) }}</div>
        </div>
            @endif
      @endforeach
    </div>

    <div class="table">
        <div class="width">
            <div class="list">
                <div>#</div>
                <div>Пользователь</div>
                <div>БИЛЕТОВ РАЗЫГРАЛ</div>
                <div>В ПЛЮСЕ</div>
            </div>

            @foreach($users as $i)
                @if($i->place > 3)
            <div class="list">
                <div>{{ $place++ }}</div>
                <div><a onclick="Page.Go(this.href); return false;" href="/user/{{$i->id}}"><img src="{{$i->avatar}}" alt="" title="" /></a><a onclick="Page.Go(this.href); return false;" href="/user/{{$i->id}}">{{$i->username}}</a></div>
                <div>{{ $i->games_played }}</div>
                <div>{{ round($i->top_value)   }}Р</div>
            </div>
                @endif
            @endforeach

        </div>
    </div>
@endsection