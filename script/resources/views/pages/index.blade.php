@extends('layout')

@section('content')
    <div class="bilets">
        @foreach($case as $i)

            @if($i->id == 17 || $i->id == 18 || $i->id == 19 || $i->id == 20 || $i->id == 21 || $i->id == 22 || $i->id == 23 || $i->id == 24)

                <div class="block" id="case_{{$i->id}}">


                    <a href="/game/{{$i->id}}">
                        <div class="details close" @if(App\Items::where('case_id',$i->id)->where('counts','>',0)->count() < 1) style=" opacity: 1;" @else style=" opacity: 0;"  @endif>
                            <div>кейс недоступен</div>


                        </div>
                        <div class="details open" @if(App\Items::where('case_id',$i->id)->where('counts','>',0)->count() < 1) style=" opacity: 0;" @else style=" opacity: 1;" @endif>
                            <div>Подробнее</div>
                            о кейсе
                        </div>
                    </a>

                    <div class="name">{{$i->name}}</div>
                    <div class="price">{{$i->price}}P</div>
                    <img src="{{$i->images}}" alt="{{$i->name}}" title=""/>
                </div>
            @endif
        @endforeach
        <div class="ograda"></div>

    </div>


    <!-- билеты -->
    <div class="bilets">
        @foreach($case as $i)

            @if(  $i->id == 14 || $i->id == 13 || $i->id == 15 || $i->id == 16 )

                <div class="block" id="case_{{$i->id}}">

                    <a href="/game/{{$i->id}}">
                        <div class="details close" @if(App\Items::where('case_id',$i->id)->where('counts','>',0)->count() < 1) style=" opacity: 1;" @else style=" opacity: 0;"  @endif>
                            <div>кейс недоступен</div>


                        </div>
                        <div class="details open" @if(App\Items::where('case_id',$i->id)->where('counts','>',0)->count() < 1) style=" opacity: 0;" @else style=" opacity: 1;" @endif>
                            <div>Подробнее</div>
                            о кейсе
                        </div>
                    </a>


                    <div class="name">{{$i->name}}</div>
                    <div class="price">{{$i->price}}P</div>
                    <img src="{{$i->images}}" alt="{{$i->name}}" title=""/>
                </div>
            @endif
        @endforeach
        <div class="ograda"></div>
    </div>
    <!-- билеты -->

    <!-- кейсы -->
    <div class="bilets">

        @foreach($case as $i)

            @if($i->id != 18 and $i->id != 19 and $i->id != 20 and $i->id != 21 and $i->id != 22 and $i->id != 23 and $i->id != 24 and $i->id != 14 and $i->id != 13 and $i->id != 15 and $i->id != 16 and $i->id != 17)

                <div class="block" id="case_{{$i->id}}">


                    <a href="/game/{{$i->id}}">
                        <div class="details close" @if(App\Items::where('case_id',$i->id)->where('counts','>',0)->count() < 1) style=" opacity: 1;" @else style=" opacity: 0;"  @endif>
                            <div>кейс недоступен </div>


                        </div>
                        <div class="details open" @if(App\Items::where('case_id',$i->id)->where('counts','>',0)->count() < 1) style=" opacity: 0;" @else style=" opacity: 1;" @endif>
                            <div>Подробнее</div>
                            о кейсе
                        </div>
                    </a>


                    <div class="name">{{$i->name}}</div>
                    <div class="price">{{$i->price}}P</div>
                    <img src="{{$i->images}}" alt="{{$i->name}}" title=""/>
                </div>
            @endif
        @endforeach
    </div>
    <!-- кейсы -->
@endsection