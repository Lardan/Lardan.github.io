@extends('admin')

@section('content')



<div class="top-bar">
    <h3>Не разыгранный билет</h3>

</div>





@if($game)
    <div class="well no-padding">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
        </tr>
        </thead>
        <tbody>









        <tr>
            <td>{{$game->id}}</td>
            <th><img src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{json_decode($game->one)->classid}}/25fx25f"/></th>
            <th><img src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{json_decode($game->two)->classid}}/25fx25f"/></th>
            <th><img src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{json_decode($game->theree)->classid}}/25fx25f"/></th>
            <th><img src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{json_decode($game->four)->classid}}/25fx25f"/></th>
            <th><img src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{json_decode($game->five)->classid}}/25fx25f"/></th>
            <th><img src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{json_decode($game->six)->classid}}/25fx25f"/></th>
            <th><img src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{json_decode($game->seven)->classid}}/25fx25f"/></th>
            <th><img src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{json_decode($game->eight)->classid}}/25fx25f"/></th>
            <th><img src="//steamcommunity-a.akamaihd.net/economy/image/class/730/{{json_decode($game->nine)->classid}}/25fx25f"/></th>
       
        </tr>




        </tbody>
    </table>
    <!-- / Add News: WYSIWYG Edior --></div>
@else
        <div class="well">
    <code> У вас нету не разыгранных билетов</code></div>
    @endif

<!-- / Add News: Content -->




</div>

</div>

@endsection