@extends('layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid">
    <!--admin dashboard-->

    @if(auth()->user()->hasRole('superadmin'))
    @include('pages.home.admin.wrapper')
    @else
    @include('pages.home.team.wrapper')
    @endif



</div>
<!--main content -->
@endsection