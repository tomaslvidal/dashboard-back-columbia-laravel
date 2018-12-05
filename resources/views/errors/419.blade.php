@extends('errors::illustrated-layout')

@section('code', '419')
@section('title', __('Página expirada'))

@section('image')
<div style="background-image: url({{ asset('/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('Lo sentimos, tu sesión ha expirado. Por favor, actualice y pruebe de nuevo.'))
