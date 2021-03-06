@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (isset($recuperou) && $recuperou)
                        <div class="alert alert-success" role="alert">
                            Os dados de sua conta de League acabaram de ser atualizados!
                        </div>
                    @endif
                    <div class="d-flex justify-content-center">
                        <a href="{{ url('match/'.Auth::user()->id) }}"><button class="btn btn-secondary btn-lg">Create match</button></a>
                        <a href="{{ url('matchinfo') }}"><button class="btn btn-info btn-lg text-white">Match info</button></a>
                    </div>
                    <hr>
                    <matches></matches>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
