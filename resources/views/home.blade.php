@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                @include('flash::message')
                @if (Auth::check() && Auth::user()->isAdmin())
                    <div class="text-right">
                        <a href='{{ route('admin') }}'>Admin</a>
                        <hr />    
                    </div>
                @endif
                <post-list />
            </div>
        </div>
    </div>
</div>
@endsection