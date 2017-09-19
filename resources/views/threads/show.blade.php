@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">
                            {{ $thread->creator->name }}
                        </a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(auth()->check())
                    <form action="{{ $thread->path() . '/replies' }}" method="POST">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" rows="5"
                                      placeholder="Enter your reply..."></textarea>
                        </div>
                        <button class="btn btn-default">Post</button>
                    </form>
                @else
                    <p class="text-center">
                        Please <a href="{{ route('login') }}">sign in</a> to participate in this thread.
                    </p>
                @endif
            </div>
        </div>

    </div>
@endsection
