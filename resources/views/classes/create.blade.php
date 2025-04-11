@extends('layouts.app')

@section('title', 'Fitness Classes')

@section('header')
    <h2 class="text-xl font-semibold leading-tight">Create New Class</h2>
@endsection

@section('content')
    <div class="py-6 px-4">
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            @include('classes.form', ['submit' => 'Create'])
        </form>
    </div>
@endsection
