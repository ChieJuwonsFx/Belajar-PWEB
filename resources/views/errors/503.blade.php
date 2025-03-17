@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Layanan sedang tidak tersedia. Kami sedang melakukan pemeliharaan.'))
@section('image', asset('assets/503.png'))