@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h1>
                        {{ $profileUser->name }}
                    </h1>
                </div>

                @forelse($activities as $date => $activity)
                    <h1 class="page-header">{{ $date }}</h1>
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.$record->type"))
                            @include("profiles.activities.$record->type", ['activity' => $record])
                        @endif
                    @endforeach
                @empty
                    <p>No activity yet.</p>
                @endforelse

            </div>
        </div>

    </div>
@endsection