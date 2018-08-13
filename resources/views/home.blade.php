@extends('template.layout')
@section('title', 'Inicio')
@section('content')
<router-view></router-view>
@endsection
@section('script')
    <script>
    	// Vue.config.devtools = true
    </script>
@endsection
