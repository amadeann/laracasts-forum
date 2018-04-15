@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <avatar-form :user="{{ $profileUser }}"></avatar-form>
                <div>
                </div>
                <hr>
                @forelse($activities as $date => $activity)
                    <h3>{{ $date }}</h3>
                    @foreach($activity as $record)
                        @if(view()->exists('profiles.activities.'.$record->type))
                            @include('profiles.activities.'.$record->type, ['activity' => $record])
                        @endif
                    @endforeach
                @empty
                    <p>There is no activity for this use yet.</p>
                @endforelse
                {{--  {{ $threads->links() }}  --}}
            </div>
        </div>
    </div>

@endsection
