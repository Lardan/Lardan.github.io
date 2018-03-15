@extends('admin')

@section('content')
<div class="row-fluid">



</div>
    <script> $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            statusCode : {
                500: function() {
                    return;
                }
            }
        });

        $(document).on('click', '.label-success', function (e) {
            var id = $(this).attr("data-id");

            $(this).addClass('btn-danger');
            $(this).removeClass('label-success');
            $(this).text('Не будут выпадать');
            $.post('/admin/edit/'+id, {status: 1}, function (data) {
                noty({
                    text: '<div><div><strong>Успешно</strong><br>Вы включили закупку </div></div>',
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

            });
        });
        $(document).on('click', '.btn-danger', function (e) {
            var id = $(this).attr("data-id");

            $(this).addClass('label-success');
            $(this).removeClass('btn-danger');
            $(this).text('Будут выпадать');
            $.post('/admin/edit/'+id, {status: 0}, function (data) {
                noty({
                    text: '<div><div><strong>Успешно</strong><br>Вы выключили закупку</div></div>',
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

            });
        });

    </script>

    <div class="navbar navbar-inverse" id="nav" style="display: block;">

        <!-- Main Navigation: Inner -->
        <div class="navbar-inner">


            <ul class="nav">

                <!-- Main Navigation: Dashboard -->
                <li><a href="/admin/items"> Вещи</a></li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Категории кейсов <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">

@foreach(App\Cases::get() as $i)
                      @if($i->id < 10)  <li><a href="/admin/items/cat/{{$i->id}}"> {{$i->name}}</a></li>@endif
    @endforeach

                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Категории кейсов 2 <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">

                        @foreach(App\Cases::get() as $i)
                            @if($i->id > 9 and $i->id < 20 )  <li><a href="/admin/items/cat/{{$i->id}}"> {{$i->name}}</a></li>@endif
                            @endforeach

                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Категории кейсов 3 <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">

                        @foreach(App\Cases::get() as $i)
                            @if($i->id > 19 )  <li><a href="/admin/items/cat/{{$i->id}}"> {{$i->name}}</a></li>@endif
                        @endforeach

                    </ul>

                </li>



            </ul>
            <form class="navbar-search pull-right" action="/admin/search">
                <input type="text" name="name" class="search-query" placeholder="Поиск предмета" autocomplete="off">
            </form>


        </div>
        <!-- / Main Navigation: Inner -->

    </div>

    <style>td {
            white-space: nowrap;
            word-wrap: normal;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100px;
        }</style>


    <div class="top-bar">
        <h3>Вещи в кейсах</h3>

    </div>



    <div class="well no-padding">


        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Вещь</th>
                <th>Картинка</th>
                <th>Кейс</th>
                <th>ClassID</th>
                <th>Название в маркете</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Статус</th>
                <th><a href="/admin/itemsnew">Добавить вещь</a></th>
            </tr>
            </thead>
            <tbody>


            @foreach($items as $i)






                <tr>
                    <td>{{$i->id}}</td>
                    <td>{{$i->market_name}}}</td>
                    <td><img src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{$i->classid}}/25fx25f"/>
                    </td>
                    <td>{{$i->case_name}}</td>
                    <td>{{$i->classid}}</td>
                    <td>{{$i->market_hash_name}}</td>
                    <td>{{$i->price}}</td>
                    <td>{{$i->counts}}</td>

                    <td><button type="button" data-id="{{$i->id}}" class="btn @if($i->status == 1)btn-danger @else label-success @endif">@if($i->status == 1) Не будут выпадать @else Будут выпадать @endif</button></td>

                    <td><a href="/admin/items/{{$i->id}}">Редактировать</a></td>
                    <td><a href="/admin/items/{{$i->id}}?status=del">Удалить</a></td>
                </tr>
            @endforeach


            </tbody>
        </table>


        {{$items->render()}}
                <!-- / Add News: WYSIWYG Edior -->

    </div>
    <!-- / Add News: Content -->




    </div>

    </div>













@endsection