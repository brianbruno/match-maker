@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Match Info</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <h4>Check if have you ever played with some player</h4>
                    <hr>
                    <form id="check-games-username" class="form-inline justify-content-center" action="{{ route('matchinfo') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                        </div>
                        <button type="submit" class="btn btn-success">Check</button>
                    </form>
                    @if (isset($partidas) && $partidas)
                    <hr>
                    <div class="d-flex justify-content-center">
                        <h4>Matches played with {{ $username }}: {{ $partidas }}</h4>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
