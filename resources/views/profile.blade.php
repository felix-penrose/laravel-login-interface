@extends('layouts.master')

@section('content')
<div class="container">

    <div class="col-12 col-sm-4">

        <side-bar/>

    </div>

    <div class="col-12 col-sm-8">



    </div>
</div>
@endsection



@section('css_foot')
    @parent
    <link href="{{ mix('/css/profile.css') }}" rel="stylesheet">
@endsection



@section('js_foot')
    @parent
    <script src="{{ mix('/js/profile.js') }}" defer></script>
@endsection
