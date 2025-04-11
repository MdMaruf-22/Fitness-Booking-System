@extends('layouts.app')

@section('title', 'Fitness Classes')

@section('header')
    <h2 class="text-xl font-semibold leading-tight">Edit Class</h2>
@endsection

@section('content')
    <div class="py-6 px-4">
        <form action="{{ route('classes.update', $class->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('classes.form', ['submit' => 'Update'])
        </form>
    </div>
@endsection
