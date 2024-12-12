@extends('layouts.admin')

@section('title', "Order #{$order->id}")
@section('content-header', "Order #{$order->id}")
{{-- @section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-primary">{{ __('cart.title') }}</a>
@endsection --}}
