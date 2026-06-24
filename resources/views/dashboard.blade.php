@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-2">Dashboard</h1>
<p class="text-gray-500">Bem-vindo, {{ auth()->user()->name }}! 👋</p>
@endsection