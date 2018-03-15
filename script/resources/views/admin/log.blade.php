@extends('admin')

@section('content')



    <div class="top-bar">
        <h3>Лог Автозакупки</h3>

    </div>



    <div class="well no-padding">


        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Вещь</th>
                <th>Цена</th>
                <th>Ответ</th>
            </tr>
            </thead>
            <tbody>



            @foreach($log as $i)






                <tr>
                    <td>{{$i->id}}</td>
                    <td>{{$i->name}}</td>
                    <td>{{$i->price/100}} руб.</td>
                    <td>{{$i->log}}</td>
                </tr>
            @endforeach



            </tbody>
        </table>
        <!-- / Add News: WYSIWYG Edior -->
        {{$log->render()}}
    </div>
    <!-- / Add News: Content -->




    </div>

    </div>

@endsection