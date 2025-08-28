<?php
use App\Models\Income;
use App\Models\Expend;
?>

@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="pagetitle">
        <h1>@lang('dashboard.dashboard')</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('dashboard.home')</a></li>
                <li class="breadcrumb-item active">@lang('dashboard.dashboard')</li>
            </ol>
        </nav>
        <section class="section dashboard">
            <div class="row">






            
    </div>


    </section>

    </div><!-- End Page Title -->


@endsection
@section('scripts')


  


@endsection
