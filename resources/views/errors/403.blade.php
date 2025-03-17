@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __('Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.'))
@section('image', asset('assets/403.png'))