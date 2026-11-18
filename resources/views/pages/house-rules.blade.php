@extends('layouts.app')

@section('title', 'House Rules & Information — Hotel Rose Palace Surat')
@section('meta_description', 'Review the house rules, guest eligibility requirements, food arrangements, accessibility, and property policies for Hotel Rose Palace Surat.')

@section('content')

{{-- Breadcrumb Strip --}}
<div style="background-color: var(--hrp-tint); border-bottom: 1px solid var(--hrp-border); padding: 14px 0;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0" style="font-size: 13px;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color: var(--hrp-burgundy); font-weight: 600;">House Rules & Information</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Main Content Section --}}
<section style="background-color: var(--hrp-canvas); padding: 50px 0 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                {{-- Reusable House Rules Component --}}
                <x-house-rules />
            </div>
        </div>
    </div>
</section>

@endsection
