@extends('site.layout.main')

@section('title')
Post card
@endsection

@section('content')


<section class="topBanner accountInfo">
  <div class="container">
    <div class="row">
      
      <aside class="col-lg-9 col-md-8 col-12">
        <h2>Welcome on board</h2>
       
       
        <div class="infoBox">
                
      @if ( session()->has('message') )
         <div class="alert alert-success alert-dismissable">{{ session()->get('message') }}</div> 
       @endif
           
        </div>
      </aside>
    </div>
  </div>
</section>


@endsection

@section('script')
@php
$disabledrag=1;

//dd($Disabledrag);
@endphp
<script>

</script>
@endsection