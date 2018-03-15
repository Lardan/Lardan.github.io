@extends('admin')

@section('content')



    <div class="top-bar">
        <h3>Вещь</h3>

    </div>



    <div class="well no-padding">

        <!-- Forms: Form -->
        <form method="post" action="/admin/itemsedit" class="form-horizontal">
            <input  name="id" value="0"  type="hidden">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="control-group">
                <label class="control-label" for="inputNormal">Кейс</label>
                <div class="controls">
                    <select class="span6 m-wrap" name="case_id">
                        @foreach($case as $i)
                            <option value="{{$i->id}}">{{$i->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            </br></br>
            <!-- Forms: Normal input field -->
            <div class="control-group">
                <label class="control-label" for="inputNormal">Classid</label>
                <div class="controls">
                    <input type="text" name="classid" value="" placeholder="..." class="input-block-level">
                </div>
            </div>


            </br></br>

            <div class="control-group">
                <label class="control-label" for="inputInline">Статус</label>
                <div class="controls">
                    <select class="span6 m-wrap" name="status">
                        <option value="0" >Не будут выпадать</option>
                        <option value="1" >Будут выпадать</option>

                    </select>
                </div>
            </div>
</br></br></br>
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