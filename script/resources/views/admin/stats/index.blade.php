@extends('admin')

@section('content')


<div class="navbar navbar-inverse" id="nav" style="display: block;">

    <!-- Main Navigation: Inner -->
    <div class="navbar-inner">


        <ul class="nav">

            <!-- Main Navigation: Dashboard -->
            <li><a href="/admin/stats/case"> Статистика по кейсам</a></li>
            <li><a href="/admin/stats/users"> Ститика по пользователям</a></li>

        </ul>
        <!-- / Add News: Content -->


    </div>

</div>


<div class="row-fluid">

    <!-- Information Boxes: Users Registered -->
    <div class="span3 well infobox">
        <i class="icon-6x icon-money"></i>
        <div class="pull-right text-right">
            Сайт заработал<br>
            <b class="huge">{{$moneysite->top_value - $items}}</b><br>
            <span class="caps muted">Всего</span>
        </div>
    </div>
    <!-- / Information Boxes: Users Registered -->

    <!-- Information Boxes: Active Users -->
    <div class="span3 well infobox">
        <i class="icon-6x icon-usd"></i>
        <div class="pull-right text-right">
            Открыто кейсов <br>
            <b class="huge">{{$case}}</b><br>
            <span class="caps muted">+{{$casetoday}} Сегодня</span>
        </div>
    </div>
    <!-- / Information Boxes: Active Users -->

    <!-- Information Boxes: Images -->
    <div class="span3 well infobox">
        <i class="icon-6x icon-user"></i>
        <div class="pull-right text-right">
            Пользователей<br>
            <b class="huge">{{$users}}</b><br>
            <span class="caps muted">+{{$userstoday}} Сегодня</span>
        </div>
    </div>
    <!-- / Information Boxes: Images -->

    <!-- Information Boxes: Images -->
    <div class="span3 well infobox">
        <i class="icon-6x icon-user"></i>
        <div class="pull-right text-right">
            Закуплено на сумму<br>
            <b class="huge">{{ round(App\AutoBuy::where('log','Купили предмет')->sum('price')/100)}}</b><br>
        </div>
    </div>
    <!-- / Information Boxes: Images -->




</div>


<!-- Live Stats -->
<div class="row-fluid">

    <!-- Pie: Box -->
    <div class="span12">

        <!-- Pie: Top Bar -->
        <div class="top-bar">
            <h3><i class="icon-eye-open"></i>Статистика пополнений </h3>
        </div>
        <!-- / Pie: Top Bar -->

        <!-- Pie: Content -->
        <div class="well no-padding">

            <table class="data-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Сумма</th>
                    <th>Пользователь</th>
                    <th>uniq</th>
                    <th>Дата</th>
                </tr>
                </thead>
                <tbody>

                @foreach($moneystats as $i)

                {{--*/ $user = App\User::find($i->user);/*--}}
                <tr class="odd gradeX">
                    <td>{{$i->id}}</td>
                    <td>{{$i->amount}}  руб.</td>
                    <td>{{$user->username}}</td>
                    <td>{{$i->uniq}}</td>
                    <td>{{$i->created_at}}</td>
                </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>Сумма</th>
                    <th>Пользователь</th>
                    <th>uniq</th>
                    <th>Дата</th>
                </tr>
                </tfoot>
            </table>

        </div>
        <!-- / Pie: Content -->

    </div>
    <!-- / Pie -->

</div>
<!-- / Live Stats -->


@endsection