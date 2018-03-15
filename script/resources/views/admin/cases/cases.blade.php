@extends('admin')

@section('content')


				
				<div class="top-bar">
					<h3>Кейс</h3>
			
				</div>
				

				
				<div class="well no-padding">
  
					<!-- Forms: Form -->
					<form method="post" action="/admin/casesedit" class="form-horizontal">
		<input  name="id" value="{{$cases->id}}"  type="hidden">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- Forms: Normal input field -->
						<div class="control-group">
							<label class="control-label" for="inputNormal">Название</label>
							<div class="controls">
								<input type="text" name="name" value="{{$cases->name}}" placeholder="..." class="input-block-level">
							</div>
						</div>
						
						
				<div class="control-group">
							<label class="control-label" for="inputInline">Картинка</label>
							<div class="controls">
								<input type="text" name="images" value="{{$cases->images}}" placeholder="..." class="input-block-level">
							</div>
						</div>


						<div class="control-group">
							<label class="control-label" for="inputInline">Цена</label>
							<div class="controls">
								<input type="text" name="price" value="{{$cases->price}}" placeholder="..." class="input-block-level">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="inputInline">Позиция</label>
							<div class="controls">
								<input type="text" name="nomer" value="{{$cases->nomer}}" placeholder="..." class="input-block-level">
							</div>
						</div>



						<div class="control-group">
							<label class="control-label" for="inputInline">Статус</label>
							<div class="controls">
								<input type="text" name="status" value="{{$cases->status}}" placeholder="..." class="input-block-level">
								<span class="help-inline">0 - Выключен | 1 - Включён | 2 - Закончился  </span>
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