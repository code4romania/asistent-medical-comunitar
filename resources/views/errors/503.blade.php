@extends('errors::minimal', [
    'showBackButton' => false,
])

@section('title', __('error.503.title'))
@section('code', '503')
@section('message', __('error.503.message'))
