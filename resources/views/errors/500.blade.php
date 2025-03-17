@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Wah, terjadi kesalahan pada server kami. Silakan coba lagi nanti.'))
@section('image', asset('assets/500.png'))