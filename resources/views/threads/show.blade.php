@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container p-5">
            <div class="row justify-content-start mb-3">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="level">
                                <img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" height="25" class="mr-1">
                                <span class="flex">
                                    <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted: 
                                    <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                </span>
                                @can('update', $thread)
                                    <form method="POST" action="{{ $thread->path() }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-link">Delete Thread</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>
    
                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
    
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a>, and currently has <span v-text="repliesCount"></span>
                                {{ str_plural('comment', $thread->replies_count) }}.
                            </p>
                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                            </p>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </thread-view>

@endsection