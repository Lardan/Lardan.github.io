@extends('admin')

@section('content')



    <style>td {
            white-space: nowrap;
            word-wrap: normal;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100px;
        }</style>


    <div class="top-bar">
        <h3>Лог переводов</h3>

    </div>


    <div class="well no-padding">


        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Отправитель</th>
                <th>Сумма</th>
                <th>Комментарий</th>
                <th>Дата</th>


            </tr>
            </thead>
            <tbody>


            @foreach($users as $i)


                <tr>
                    <td>{{$i->id}}</td>
                    <td>{{$i->admin}}</td>
                    <td>{{$i->money}}</td>
                    <td>{{$i->comment}}</td>
                    <td>{{$i->date}}</td>

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