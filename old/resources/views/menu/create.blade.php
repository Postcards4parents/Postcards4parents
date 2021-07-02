
@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Menu Management</h1>
@stop

@section('content')
  

<div class="row">

    <div class="col-md-12">
   
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Menu management page</h3>
          
        </div>
      
        <form role="form" id="form">
          <div class="box-body">
            <?php
            $public_menu = Menu::getByName('Main Menu');
            //echo '<pre>';print_r($public_menu);
             ?>            
            {!! Menu::render() !!}
        
            
            
          </div>
       
        </form>
       
      </div>
      
    
    
     

    </div>
  </div>

 
@stop
@section('my_js')
{!! Menu::scripts() !!}

@stop