@extends('site.layout.main')

@section('title')
Post card
@endsection

@section('content')

<!-- Banner -->
<section class="topBanner">
    <div class="container">
      <div class="row">
        <aside class="col-lg-5 col-md-6">
          <h1>Pre-K</h1>
          <p>Lorem Ipsum has been the industry's standard dummy text ever since when an unknown printer took galley scrambled it to make Lorem Ipsum has been the industry's standard dummy text ever since when an unknown </p>
          <a href="#" class="link2">Sign up!</a>
        </aside>
        <aside class="col-lg-7 col-md-6 my-auto">
        <img src="{{asset('site')}}/images/banner-image.png" class="img-fluid">
  
        </aside>
      </div>
    </div>
  </section>
  <!-- Recent Postcards -->
  <section class="recentList postCards">
    <div class="container">
      <h2>Kindergarten Postcards</h2>
          <div class="row">
          <div class="col-md-4 col-sm-6">
          <div class="item">
            <figure><a href="#"><img src="{{asset('site')}}/images/postcard1.jpg" class="img-fluid"></a></figure>
              <h3><a href="#">Lorem Ipsum is simply dummy text of the printing industry.</a></h3>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
              <span><a href="#">Kindergarten</a></span>
              <span><a href="#">Cognitive Dev’t</a></span>
          </div>
          </div>
          <div class="col-md-4 col-sm-6">
          <div class="item">
            <figure><a href="#"><img src="{{asset('site')}}/images/postcard2.jpg" class="img-fluid"></a></figure>
              <h3><a href="#">Lorem Ipsum is simply dummy text of the printing industry.</a></h3>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
              <span><a href="#">Grades 1–3</a></span>
              <span><a href="#">Emotional Dev’t</a></span>
          </div>
          </div>
          <div class="col-md-4 col-sm-6">
          <div class="item">
            <figure><a href="#"><img src="{{asset('site')}}/images/postcard3.jpg" class="img-fluid"></a></figure>
              <h3><a href="#">Lorem Ipsum is simply dummy text of the printing industry.</a></h3>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
              <span><a href="#">Grades 4–5</a></span>
              <span><a href="#">Parent Self-care</a></span>
          </div>
          </div>
          <div class="col-md-4 col-sm-6">
          <div class="item">
            <figure><a href="#"><img src="{{asset('site')}}/images/postcard1.jpg" class="img-fluid"></a></figure>
              <h3><a href="#">Lorem Ipsum is simply dummy text of the printing industry.</a></h3>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
              <span><a href="#">Kindergarten</a></span>
              <span><a href="#">Cognitive Dev’t</a></span>
          </div>
          </div>
          <div class="col-md-4 col-sm-6">
          <div class="item">
            <figure><a href="#"><img src="{{asset('site')}}/images/postcard2.jpg" class="img-fluid"></a></figure>
              <h3><a href="#">Lorem Ipsum is simply dummy text of the printing industry.</a></h3>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
              <span><a href="#">Grades 1–3</a></span>
              <span><a href="#">Emotional Dev’t</a></span>
          </div>
          </div>
          <div class="col-md-4 col-sm-6">
          <div class="item">
            <figure><a href="#"><img src="{{asset('site')}}/images/postcard3.jpg" class="img-fluid"></a></figure>
              <h3><a href="#">Lorem Ipsum is simply dummy text of the printing industry.</a></h3>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
              <span><a href="#">Grades 4–5</a></span>
              <span><a href="#">Parent Self-care</a></span>
          </div>
          </div>		
          </div>   
    </div>
  </section>



@endsection