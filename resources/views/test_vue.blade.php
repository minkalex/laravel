@extends('layouts.index')

@section('content')
    <div id="app">
        <header-component :users="{{ json_encode($objUsers) }}"></header-component>
    </div>
@endsection
