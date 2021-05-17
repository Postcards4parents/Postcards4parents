<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        
        
        @stack('styles')
    </head>
    <body>
            <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
            <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
           
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

          
        </div>
        <div class="row">
            <div class="col-md-6">
                    @if($errors->any())
                    <div class="alert alert-danger">
                <ul>
                    <li>{{$errors->first()}}</li>
                    
                </ul>
                  </div>
                    @endif

    @if (Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ Session::get('success') }}</li>
        </ul>
    </div>
    @endif
                    @yield('content')
            </div>
        </div>
        
        @stack('scripts')
        <script>
    $(document).ready(function() {

        


    
    
    
    
    setTimeout(() => {
    var checkbox = document.getElementById('checkbox-group-1568973475252-0');
    if(checkbox.checked==false)
    {
        $('.field-text-1568973630291').hide();
        $('.field-select-1568973667002').hide();

    }
    console.log(checkbox);
    checkbox.addEventListener('change', (event) => {
    $('.field-text-1568973630291').toggle();
    $('.field-select-1568973667002').toggle();
   });
    }, 500);
  
  
             
});
     
        
        </script>
    </body>
</html>
