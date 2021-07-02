@extends('emails.index')

@section('content1')
Hi, {{$name}} Please find your reset link below 

@endsection

@section('content2')
Link : <a style="color:#000;" href="{{url("/password_reset/$email/$token")}}">Link</a>
<br/><br/>
Copy Paste Link: {{url("/password_reset/$email/$token")}}

@endsection