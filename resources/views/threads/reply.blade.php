<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile', $reply->owner->name) }}">
                        {{ $reply->owner->name }}
                    </a>
                    said
                    {{ $reply->created_at->diffForHumans() }}
                </h5>

                @if(auth()->check())
                    <div>
                        <favorite :reply="{{ $reply }}"></favorite>
                    </div>
                @endif
            </div>
        </div>
        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-xs btn-primary" @click="update">update</button>
                <button class="btn btn-xs btn-link" @click="editing = false">cancel</button>
            </div>
            <div v-else v-text="body">
                {{ $reply->body }}
            </div>
        </div>

        @can('update', $reply)
            <div class="panel-footer level">
                <button class="btn btn-xs mr-1" @click="editing = true">edit</button>
                <button class="btn btn-xs btn-danger mr-1" @click="destroy">delete</button>
            </div>
        @endcan
    </div>
</reply>