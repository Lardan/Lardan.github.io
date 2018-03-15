@extends('admin')

@section('content')


				
				<div class="top-bar">
					<h3>Последние 20 покупок</h3>
			
				</div>
				

				
				<div class="well no-padding">

					
					<table class="table">
		              <thead>
		                <tr>
		                  <th>#</th>
		                  <th>Кейс</th>
		                  <th>Выиграл</th>
		                </tr>
		              </thead>
		              <tbody>
		                
		                
						
						 @foreach($game as $i)
				
				

	 
							
						
		                <tr>
		                  <td>{{$i->id}}</td>
		                  <td>{{$i->case_name}}</td>
		                  <td>{{$i->winner_username}}</td>
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