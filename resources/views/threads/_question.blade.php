{{-- Editing the question --}}
<div class="card mb-3" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input type="text"  v-model="form.title" class="form-control">
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <wysiwyg v-model="form.body"></wysiwyg>
        </div>
    </div>
    <div class="card-footer d-flex">
        <button class="btn btn-sm btn-primary mr-2" @click="update">Update</button>
        <button class="btn btn-sm" @click="resetForm">Cancel</button>
        @can('update', $thread)
            <form method="POST" action="{{ $thread->path() }}" class="ml-auto">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-link">Delete Thread</button>
            </form>
        @endcan
    </div>
</div>

{{-- Viewing the question --}}

<div class="card mb-3" v-else>
    <div class="card-header">
        <div class="level">
            <img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" height="25" class="mr-1">
            <span class="flex">
                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted: 
                <a href="{{ $thread->path() }}" v-text="title"></a>
            </span>
        </div>
    </div>
    <div class="card-body" v-html="body">
    </div>
    <div class="card-footer" v-if="authorize('owns', thread)">
        <button class="btn btn-sm" @click="editing = true">Edit</button>
    </div>
</div>