@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Akses ditolak. Silakan login terlebih dahulu untuk melanjutkan.'))
@section('image', asset('assets/401.png'))