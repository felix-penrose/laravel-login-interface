@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-12 col-sm-4 col-lg-3">

            <side-bar
                :current_tab="current_tab"
                v-on:set-tab="set_tab"
            ></side-bar>

        </div>


        <div class="col-12 col-sm-8 col-lg-9">

            <flash-message
                v-if="this.$store.state.flash_message"
                :class_name="this.$store.state.flash_message.class"
            >@{{ this.$store.state.flash_message.message }}</flash-message>

            <edit-profile
                v-if="current_tab == 'edit-profile'"
                v-on:update-user="update_user"
                :processing="processing"
            ></edit-profile>

            <close-account
                v-if="current_tab == 'close-account'"
                end_point="{{ route('profile.delete') }}"
            ></close-account>

        </div>

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
