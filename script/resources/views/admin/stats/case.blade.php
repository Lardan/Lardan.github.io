@extends('admin')

@section('content')



    <!-- Live Stats -->
    <div class="row-fluid">

        <!-- Pie: Box -->
        <div class="span12">

            <!-- Pie: Top Bar -->
            <div class="top-bar">
                <h3><i class="icon-eye-open"></i>Статистика кейсов </h3>
            </div>
            <!-- / Pie: Top Bar -->

            <!-- Pie: Content -->
            <div class="well no-padding">
                <select class="span6 m-wrap" tabindex="1" onchange="location = this.options[this.selectedIndex].value;">
                    <option value="/admin/stats/case">Всего</option>
                    <option value="/admin/stats/case?day=today">Сегодня</option>
                    <option value="/admin/stats/case?day=vchera">Вчера</option>
                    <option value="/admin/stats/case?day=nedela">Неделя</option>
                    <option value="/admin/stats/case?day=moonth">Месяц</option>
                </select>
                <table class="data-table">
                    <thead>
                    <tr>
                        <th>Название кейса</th>
                        <th>Заработано с кейса</th>
                        <th>Открыто кейсов</th>
                        <th>Вещей</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($case as $i)

                        <tr class="odd gradeX">
                            <td>{{$i->name}}</td>
                            <td>{{$i->caseprice*App\Game::where('case',$i->caseid)->count() -  App\Game::where('case',$i->caseid)->sum('price')}}  руб.</td>
                            <td>{{App\Game::where('case',$i->caseid)->count()}}</td>
                            <td>{{$i->counts}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Название кейса</th>
                        <th>Заработано с кейса</th>
                        <th>Открыто кейсов</th>
                        <th>Вещей</th>
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