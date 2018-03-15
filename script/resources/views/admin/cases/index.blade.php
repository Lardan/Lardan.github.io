@extends('admin')

@section('content')


				
				<div class="top-bar">
					<h3>Кейсы</h3>
			
				</div>
				

				
				<div class="well no-padding">

					
					<table class="table">
		              <thead>
		                <tr>
		                  <th>#</th>
		                  <th>Кейс</th>
							<th>Средняя гарантия</th>
							<th>Цена кейса</th>
							<th>3 попытки</th>
							<th>4 попытки</th>
							<th>Средняя основа</th>
							<th>Количество вещей</th>
							<th>Статус</th>
						  	 	 <th><a href="/admin/cases">Добавить кейс</a></th>
		                </tr>
		              </thead>
		              <tbody>
		                
		                
						
						 @foreach($cases as $i)





						 {{--*/ $caseprice = App\Items::where('case_id', $i->id)->orderByRaw("RAND()")->where('price', '<',$i->price)->where('counts', '>', 0)->count();
						 $caseprice1 = App\Items::where('case_id', $i->id)->orderByRaw("RAND()")->where('price', '<',$i->price)->where('counts', '>', 0)->sum('price');
						 $caseprice2 = App\Items::where('case_id', $i->id)->orderByRaw("RAND()")->where('price', '>',$i->price)->where('status',1)->where('counts', '>', 0)->count();
						 $caseprice3 = App\Items::where('case_id', $i->id)->orderByRaw("RAND()")->where('price', '>',$i->price)->where('status',1)->where('counts', '>', 0)->sum('price');



						 /*--}}
		                <tr> 
		                  <td>{{$i->id}}</td>
		                  <td>{{$i->name}}</td>
							<td> {{round( $caseprice == 0 ? 0 : ($caseprice1 / $caseprice) )}} руб.</td>
							<td>{{$i->price}} руб.</td>
							<td>{{($i->price - round( $caseprice == 0 ? 0 : ($caseprice1 / $caseprice) )) *28 }} руб.</td>
							<td>{{($i->price - round( $caseprice == 0 ? 0 : ($caseprice1 / $caseprice)) ) *24 }} руб.</td>
							<td> {{round( $caseprice2 == 0 ? 0 : ($caseprice3 / $caseprice2) )}} руб.</td>
							<td>{{App\Items::where('case_id',$i->id)->where('counts','>',0)->count()}}</td>
							<td>@if($i->status == 1) Включён  @else Выключен @endif</td>
		     
							 	 <td><a href="/admin/case/{{$i->id}}">Редактировать</a></td>
								  <td><a href="/admin/case/{{$i->id}}?status=del">Удалить</a></td>
		                </tr>
								@endforeach
						
						
						
		              </tbody>
		            </table>
					<!-- / Add News: WYSIWYG Edior -->

				</div>
				<!-- / Add News: Content -->

			
		
		
					</div>
	
	</div>

@endsection