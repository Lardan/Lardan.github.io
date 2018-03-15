@extends('admin')

@section('content')



    <div class="top-bar">
        <h3>Пользователь {{$user->username}}</h3>

    </div>



    <div class="well no-padding">

        <!-- Forms: Form -->
        <form method="post" action="/admin/userdit" class="form-horizontal">
            <input  name="id" value="{{$user->id}}"  type="hidden">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">



            <!-- Forms: Normal input field -->
            <div class="control-group">
                <label class="control-label" for="inputNormal">Ник</label>
                <div class="controls">
                    <input type="text" name="username" value="{{$user->username}}" placeholder="..." class="input-block-level">
                </div>
            </div>



            <div class="control-group">
                <label class="control-label" for="inputInline">Трейд ссылка</label>
                <div class="controls">
                    <input type="text" name="trade_link" value="@if($user->trade_link){{$user->trade_link}}@endif" placeholder="..." class="input-block-level">
                </div>
            </div>



            <div class="control-group">
                <label class="control-label" for="inputInline">Баланс</label>
                <div class="controls">
                    <input type="text" name="money" value="{{$user->money}}" placeholder="..." class="input-block-level">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="inputInline">Бан в чате</label>
                <div class="controls">

                    <select class="span6 m-wrap" name="banned">
                        <option value="1" @if($user->banchat == 1) selected @endif>Забанить</option>
                        <option value="0" @if($user->banchat == 0) selected @endif>Пусть живёт</option>
                    </select>


                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="inputInline">Админ</label>
                <div class="controls">

                    <select class="span6 m-wrap" name="is_admin">
                        <option value="1" @if($user->is_admin == 1) selected @endif>Да</option>
                        <option value="0" @if($user->is_admin == 0) selected @endif>Нет</option>
                    </select>


                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputInline">Поддержка</label>
                <div class="controls">

                    <select class="span6 m-wrap" name="support">
                        <option value="1" @if($user->support == 1) selected @endif>Да</option>
                        <option value="0" @if($user->support == 0) selected @endif>Нет</option>
                    </select>


                </div>
            </div>

            <!-- Forms: Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Сохранить</button>

            </div>
            <!-- / Forms: Form Actions -->

        </form>
        <!-- / Forms: Form -->


        <!-- / Add News: WYSIWYG Edior -->

    </div>
    <!-- / Add News: Content -->




    </div>

    </div>

@endsection