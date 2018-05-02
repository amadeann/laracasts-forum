@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="container p-5">
            <div class="row justify-content-start mb-3">
                <div class="col-md-8" v-cloak>
                    @include('threads._question')
                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a>, and currently has <span v-text="repliesCount"></span>
                                {{ str_plural('comment', $thread->replies_count) }}.
                            </p>
                            <p class="d-flex">
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signedIn"></subscribe-button>

                                <button 
                                    class="btn btn-default ml-1" 
                                    v-if="authorize('isAdmin')" 
                                    @click="toggleLock" 
                                    v-text="locked ? 'Unlock' : 'Lock'"></button>
                            </p>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </thread-view>

@endsection
