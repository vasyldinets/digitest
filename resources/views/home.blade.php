@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>You are logged in!</p>
                        <p>Now you can see your <a href="/transactions">transactions</a> or create <a href="/api">token</a> for API requests</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection