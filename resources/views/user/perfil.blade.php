@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Perfil
                    </div>

                    <div class="card-body">
                        Olá, {{ $user->league_name }}!
                        Level: {{ $user->league_summonerlevel }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
