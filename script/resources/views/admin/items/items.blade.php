@extends('admin')

@section('content')



    <div class="top-bar">
        <h3>Вещь</h3>

    </div>



    <div class="well no-padding">

        <!-- Forms: Form -->
        <form method="post" action="/admin/itemsedit" class="form-horizontal">
            <input  name="id" value="{{$items->id}}"  type="hidden">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="control-group">
                <label class="control-label" for="inputNormal">Вещь</label>
                <div class="controls">
                    <select class="span6 m-wrap" name="case_id">
                        @foreach($case as $i)
                            <option value="{{$i->id}}" @if($items->case_id == $i->id) selected @endif>{{$i->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Forms: Normal input field -->
            <div class="control-group">
                <label class="control-label" for="inputNormal">Название</label>
                <div class="controls">
                    <input type="text" name="market_name" value="{{$items->market_name}}" placeholder="..." class="input-block-level">
                </div>
            </div>



            <div class="control-group">
                <label class="control-label" for="inputInline">Classid</label>
                <div class="controls">
                    <input type="text" name="classid" value="{{$items->classid}}" placeholder="..." class="input-block-level">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputInline">Тип</label>
                <div class="controls">
                    <input type="text" name="type" value="{{$items->type}}" placeholder="..." class="input-block-level">
                </div>
            </div>



            <div class="control-group">
                <label class="control-label" for="inputInline">Цена</label>
                <div class="controls">
                    <input type="text" name="price" value="{{$items->price}}" placeholder="..." class="input-block-level">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="inputInline">Статус</label>
                <div class="controls">

                        <select class="span6 m-wrap" name="status">
                                <option value="1" @if($items->status == 1) selected @endif>Будут выпадать</option>
                            <option value="0" @if($items->status == 0) selected @endif>Не будут выпадать</option>
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