@extends('emails.layout')

@section('title', $subject ?? 'Welcome')
@section('header', $header ?? 'Welcome!')

@section('content')
    <p>{{ $greeting ?? 'Hello,' }}</p>

    <p>{{ $messageLine1 ?? 'Thanks for joining our platform!' }}</p>

    @isset($actionUrl)
        <a href="{{ $actionUrl }}" class="button">{{ $actionText ?? 'Get Started' }}</a>
    @endisset

    @isset($messageLine2)
        <p style="margin-top: 20px;">{{ $messageLine2 }}</p>
    @endisset

    <p style="margin-top: 30px;">Regards,<br>{{ config('app.name') }}</p>
@endsection
