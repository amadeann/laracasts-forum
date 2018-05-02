@extends('layouts.app')

@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')

    <div class="container p-5">
        <div class="card">
            <div class="card-header">Create a new thread</div>
            <div class="card-body">
                <form action="/threads" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="channel_id">Choose a channel</label>
                        <select class="form-control" name="channel_id" id="channel_id" required>
                            <option value="">Choose one...</option>
                            @foreach($channels as $channel)
                                <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                    </div>
                    <div class="form-group">
                      <label for="body">Body</label>
                      <wysiwyg name="body"></wysiwyg>
                    </div>
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6Lc_olQUAAAAAMvxUBHfArek2MBczJ2Mk4BfGYmV"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Publish</button>
                </form>
            </div>
        </div>
    </div>

@endsection
