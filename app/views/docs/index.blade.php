@extends('layouts.docs')

@section('content')
    
    <h1>REST API v1 Docs</h1>

    <p>All resources apart from GET requests require that you send your secret application token (<code>private_token</code>) and authenticated user token (<code>access_token</code>) in the request headers.</p>

    <p>For help in getting started creating your first app with the beer api, see our <a href="docs/getting-started">getting started guide</a>.</p>

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