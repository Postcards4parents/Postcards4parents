@extends('site.layout.main')



@section('content')

      



<section class="whatsYou" id="quizSections">
  <div class="container">
		{!! $renderer->render($data->moduleText1) !!}
  </div>
</section>








 
@endsection

@section('title')
Quiz
@endsection

@section('description')
@if(!empty($metaDescription))
{{$metaDescription}}
@endif
@endsection

@section('script')

@endsection      
