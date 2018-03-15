@extends('admin')

@section('content')

<div class="navbar navbar-inverse" id="nav" style="display: block;">

    <!-- Main Navigation: Inner -->
    <div class="navbar-inner">

        <form class="navbar-search pull-right" action="/admin/searchusers">
            <input type="text" name="name" class="search-query" placeholder="Поиск пользователя" autocomplete="off">
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
    <h3>Пользователи</h3>

</div>


<div class="well no-padding">


    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Ник</th>
            <th>STEAMID64</th>
            <th>Баланс</th>
            <th>Админ</th>
            <th>Трейд ссылка</th>
            <th>Чат</th>

        </tr>
        </thead>
        <tbody>


        @foreach($users as $i)


        <tr>
            <td>{{$i->id}}</td>
            <td>{{$i->username}}</td>
            <td>{{$i->steamid64}}</td>
            <td>{{$i->money}}</td>
            <td>@if($i->is_admin)<span class="label label-important">Да</span>@else <span class="label label-success">Нет</span>
                @endif
            </td>
            <td>@if($i->trade_link)<a href="{{$i->trade_link}}" target="_blank">Трейд ссылка(кликабельная)</a> @else
                <span class="label label-important">Нету</span> @endif
            </td>
            <td>@if($i->banchat)<span class="label label-important">Забанен</span>@else <span
                    class="label label-success">Не забанен</span> @endif
            </td>
            <td><a href="/admin/givemoney/{{$i->id}}" class="btn btn-info">Перевести деньги</a></td>
            <td><a href="/admin/lastmoney/{{$i->id}}" class="btn btn-info">История переводов</a></td>
            <td><a href="/admin/user/{{$i->id}}">Редактировать</a></td>
        </tr>
        @endforeach


        </tbody>
    </table>


    {{$users->render()}}
    <!-- / Add News: WYSIWYG Edior -->

</div>
<!-- / Add News: Content -->


</div>

</div>


@endsection