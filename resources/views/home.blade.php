@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                @include('flash::message')
                <post-list />
            </div>
        </div>
    </div>
</div>
@endsection