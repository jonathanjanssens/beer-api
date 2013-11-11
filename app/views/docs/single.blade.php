@extends('layouts.docs')

@section('content')
    
    <h1><span class="doc-method">{{ $doc->method }}</span> {{ $doc->resource }}/</h1>

    <section>
        {{ $doc->description }}
    </section>

@stop