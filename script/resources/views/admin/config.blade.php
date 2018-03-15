@extends('admin')

@section('content')



    <div class="top-bar">
        <h3>Настройки сайта</h3>

    </div>



    <div class="well no-padding">

        <!-- Forms: Form -->
        <form method="post" action="/admin/config" class="form-horizontal">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">



            <!-- Forms: Normal input field -->
            <div class="control-group">
                <label class="control-label" for="inputNormal">Макс.</label>
                <div class="controls">
                    <input type="text" name="maxprice" value="{{$config->maxprice}}" placeholder="..." class="input-block-level">
                    <span class="help-inline">Максимальная цена выпадания оружия. Например 100 руб , оружия будут выпадать не больше 100 рублей.  </span>
                </div>
            </div>



            <div class="control-group">
                <label class="control-label" for="inputNormal">Ключ от csgo.tm</label>
                <div class="controls">
                    <input type="text" name="keycsgotm" value="{{$config->keycsgotm}}" placeholder="..." class="input-block-level">
                    <span class="help-inline">Секретный ключ .  Получаем тут <a href="https://csgo.tm/botinfo/" target="_blank">Получить ключ</a></span>
                </div>
            </div>




            <div class="control-group">
                <label class="control-label" for="inputInline">Количество закупа</label>
                <div class="controls">
                    <input type="text" name="countitems" value="{{$config->countitems}}" placeholder="..." class="input-block-level">
                    <span class="help-inline">Какое количество предметов закупать ? Например по 2 штуки </span>
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