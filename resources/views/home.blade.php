@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                    <queue></queue>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
