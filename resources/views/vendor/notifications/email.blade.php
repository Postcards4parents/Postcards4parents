@extends('emails.index')
@php

$url=$actionUrl;
$array=(explode("&",parse_url($url)['query'])); 
$token=explode( '=',$array[0])[1];
$email=explode( '=',$array[1])[1];
$base_url=url('/').'/password/reset/'.$token;

@endphp
@section('content1')
Hi, Please find your reset link below 

@endsection

@section('content2')
Link : <a style="color:#000;" href="{{$base_url}}">Link</a>
<br/><br/>
Copy Paste Link: {{$base_url}}

@endsection