@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ Auth::user()->name }} Match</div>

                <div class="card-body text-center">
                    <queue :match_id="{{ $match_id }}"></queue>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
