@extends('emails.index')

@section('content1')
Hi {{ucfirst($name)}},

@endsection
@section('content2')
To reset your password, please <a style="color:#000;" href="{{url("/password_reset/$email/$token")}}">go to:</a> 
@endsection

@section('content3')

{{url("/password_reset/$email/$token")}}


@endsection