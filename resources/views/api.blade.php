@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                    <h2>Client</h2>

                    <passport-clients></passport-clients>
                    <passport-authorized-clients></passport-authorized-clients>

            </div>
            <div class="col-md-12 col-lg-6">

                    <h2>Tokens</h2>

                    <passport-personal-access-tokens></passport-personal-access-tokens>

            </div>
        </div>
    </div>
@endsection