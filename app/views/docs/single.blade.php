@extends('layouts.docs')

@section('content')
    
    <h1><span class="doc-method">{{ $doc->method }}</span> {{ $doc->resource }}/</h1>

    <section>

        <h2>Resource URL</h2>
        <p>{{ URL::to('/') . '/' . $doc->resource }}</p>

        <h2>Description</h2>
        {{ $doc->description }}

        {{ $doc->content }}
    </section>

@stop