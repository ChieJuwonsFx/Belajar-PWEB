@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Halaman yang Anda cari tidak ditemukan. Mungkin telah dipindahkan atau dihapus.'))
@section('image', asset('assets/404.png'))