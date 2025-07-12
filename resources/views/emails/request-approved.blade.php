@extends('emails.layout')


@section('title', $subject ?? 'Welcome')
@section('header', $header ?? 'Welcome!')


@section('content')
    <p>{{ $greeting ?? 'Hello,' }}</p>

    <p>{{ $messageLine1 ?? 'Thanks for joining our platform!' }}</p>

    <p style="margin-top: 30px;">Regards,<br>{{ config('app.name') }}</p>
@endsection
