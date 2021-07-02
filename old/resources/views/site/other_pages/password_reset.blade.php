@extends('site.layout.main')

@section('title')
Post card
@endsection

@section('content')


<section class="topBanner resetPassword">
  <div class="container">
    <div class="row">
      
      <aside class="col-lg-10 col-md-12 col-12">
		  <div class="loginInner">
        <h5>Password Reset</h5>
        @if (Session::has('success'))
        <script>
        toastr.success("{{ Session::get('success') }}"); 
        </script>
        <div class="alert alert-info">{{ Session::get('success') }}</div>
        @endif

        @if (Session::has('error'))
        <script>
        toastr.success("{{ Session::get('error') }}"); 
        </script>
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
       
        <div class="">
                <form action="{{ url('update_password') }}" method="post">
                    {{ csrf_field() }}
    
                   <input type="hidden" name="token" value="{{ $token }}">
    				<div class="row">
					<aside class="col-sm-9">
                    <div class="{{ $errors->has('email') ? 'has-error' : '' }}">
                        <input type="email" name="email" value="{{ isset($email) ? $email : old('email') }}"
                               placeholder="{{ trans('adminlte::adminlte.email') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      
                    </div>
                    <div class="{{ $errors->has('password') ? 'has-error' : '' }}">
                        <input type="password" name="password" placeholder="{{ trans('adminlte::adminlte.password') }}">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="{{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                        <input type="password" name="password_confirmation" placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
					</aside>
					<aside class="col-sm-3">
                    <button type="submit" class="btnSubmit">
                        {{ trans('adminlte::adminlte.reset_password') }}
                    </button>
					</aside>
				    </div>
                </form>
        
        </form>
          
        </div>
			</div>
        {{-- <div class="infoBox">
          <h3>Password</h3>
          <a href="#" class="edit">Edit</a>
          <p class="proName">Current Password</p>
          <p><input type="Password" disabled="" name="" value="password"></p>
        </div> --}}

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

@if (Session::has('success'))
        <script>
        toastr.success("{{ Session::get('success') }}"); 
        window.location="{{url('/')}}";
        </script>
       
        @endif

        @if (Session::has('error'))
        <script>
            
        toastr.error("{{ Session::get('error') }}"); 
        window.location="{{url('/')}}";
        </script>
        
        @endif
@endsection