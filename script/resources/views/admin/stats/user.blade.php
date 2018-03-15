@extends('admin')

@section('content')



        <!-- Live Stats -->
<div class="row-fluid">

    <!-- Pie: Box -->
    <div class="span12">

        <!-- Pie: Top Bar -->
        <div class="top-bar">
            <h3><i class="icon-eye-open"></i>Статистика пользователей </h3>
        </div>
        <!-- / Pie: Top Bar -->

        <!-- Pie: Content -->
        <div class="well no-padding">

            <table class="data-table">
                <thead>
                <tr>
                    <th>Ник</th>
                    <th>Кейсов открыто</th>
                    <th>Пополнил</th>
                    <th>Выиграл</th>
                    <th>Какие кейсы открывал</th>
                </tr>
                </thead>
                <tbody>

                @foreach($user as $i)

                    <tr class="odd gradeX">
                        <td>{{$i->username}}</td>
                        <td>{{App\Game::where('userid',$i->id)->count()}}</td>
                        <td>{{DB::table('log_pay')->where('user',$i->id)->count()}} руб.</td>
                        <td>{{App\Game::where('userid',$i->id)->sum('price') - App\Game::where('userid',$i->id)->join('case','game.case', '=', 'case.id' )->sum('case.price')}} руб.</td>
                        <td><a href="/admin/lastcase/{{$i->id}}" class="btn btn-info">История открытий</a></td>
                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>Ник</th>
                    <th>Кейсов открыто</th>
                    <th>Пополнил</th>
                    <th>Выиграл</th>
                    <th>Какие кейсы открывал</th>
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