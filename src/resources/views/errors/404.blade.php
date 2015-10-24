@extends('template')

@section('headers')
<style>
    .error-template {
        padding: 40px 15px;text-align: center;
    }
    .error-actions {
        margin-top:15px;margin-bottom:15px;
    }
    .error-actions .btn {
        margin-right:10px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="error-template">
            <h1>Oops!</h1>
            <h2>404 Not Found</h2>
            <div class="error-details">
                Sorry, an error has occurred, and the page you were looking for was not found!
            </div>
            <div class="error-actions">
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span> Take Me Home</a>
                {{--<a href="http://www.jquery2dotnet.com" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>--}}
            </div>
        </div>
    </div>
</div>
@endsection