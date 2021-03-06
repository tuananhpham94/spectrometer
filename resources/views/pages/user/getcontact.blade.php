@extends('layouts.user.application')

@section('metadata')
@stop

@section('styles')
    @parent
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }

        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 15px;
        }

        th {
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr {
            margin: 10px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
@stop

@section('title')
@stop

@section('scripts')
    @parent
@stop

@section('content')
    <div class="container" style="padding-top:100px; text-align: center; padding-bottom: 150px;">
        <h1 >Thanks for your query, we will reply to your message as soon as possible.</h1>

    </div>

@stop
