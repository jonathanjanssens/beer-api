@extends('layouts.docs')

@section('content')
    
    <h1>REST API v1 Docs</h1>

    <h2>beers</h2>
    <table>
        <thead>
            <tr>
                <th>Resource</th>
                <th>Description</th>
            </tr>
        </thead>
        @foreach($beersDocs as $doc)

            <tr>
                <td class="doc-title"><a href="docs/{{ $doc->slug }}"><span class="doc-method">{{ $doc->method }}</span> {{ $doc->resource }}/ </a></td>
                <td class="doc-body">{{ $doc->description }}</td>
            </tr>

        @endforeach
    </table>

    <h2>breweries</h2>
    <table>
        <thead>
            <tr>
                <th>Resource</th>
                <th>Description</th>
            </tr>
        </thead>
        @foreach($breweriesDocs as $doc)

            <tr>
                <td class="doc-title"><a href="docs/{{ $doc->slug }}"><span class="doc-method">{{ $doc->method }}</span> {{ $doc->resource }}/ </a></td>
                <td class="doc-body">{{ $doc->description }}</td>
            </tr>

        @endforeach
    </table>

    <h2>users</h2>
    <table>
        <thead>
            <tr>
                <th>Resource</th>
                <th>Description</th>
            </tr>
        </thead>
        @foreach($usersDocs as $doc)

            <tr>
                <td class="doc-title"><a href="docs/{{ $doc->slug }}"><span class="doc-method">{{ $doc->method }}</span> {{ $doc->resource }}/ </a></td>
                <td class="doc-body">{{ $doc->description }}</td>
            </tr>

        @endforeach
    </table>

    <h2>reviews</h2>
    <table>
        <thead>
            <tr>
                <th>Resource</th>
                <th>Description</th>
            </tr>
        </thead>
        @foreach($reviewsDocs as $doc)

            <tr>
                <td class="doc-title"><a href="docs/{{ $doc->slug }}"><span class="doc-method">{{ $doc->method }}</span> {{ $doc->resource }}/ </a></td>
                <td class="doc-body">{{ $doc->description }}</td>
            </tr>

        @endforeach
    </table>

@stop