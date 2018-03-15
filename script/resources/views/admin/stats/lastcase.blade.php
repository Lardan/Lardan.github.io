@extends('admin')

@section('content')



        <!-- Live Stats -->
<div class="row-fluid">

    <!-- Pie: Box -->
    <div class="span12">

        <!-- Pie: Top Bar -->
        <div class="top-bar">
            <h3><i class="icon-eye-open"></i>Статистика пользователей </h3>
        </div>
        <!-- / Pie: Top Bar -->

        <!-- Pie: Content -->
        <div class="well no-padding">

            <table class="data-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название кейса</th>
                    <th>Цена кейса</th>
                    <th>Выиграл</th>
                </tr>
                </thead>
                <tbody>

                @foreach($user as $i)
                       <tr class="odd gradeX">
                           <td>{{$i->id}}</td>
                           <td>{{$i->casename}}</td>
                           <td>{{$i->caseprice}} руб.</td>
                           <td>{{$i->price }} руб.</td>

                       </tr>
                   @endforeach

                   </tbody>
                   <tfoot>
                   <tr>
                       <th>Ник</th>
                       <th>Название кейса</th>
                       <th>Цена кейса</th>
                       <th>Выиграл</th>
                   </tr>
                   </tfoot>
               </table>

           </div>
           <!-- / Pie: Content -->

       </div>
       <!-- / Pie -->

   </div>
   <!-- / Live Stats -->


   @endsection