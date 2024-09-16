<div class="container text-center" id="blog">
    <h1>Comments</h1>
    <form action="{{ route('comment') }}" method="POST">
        @csrf
        <input type="text" name="comment" placeholder="Write a coment here">
        <input type="submit" value="Comment" class="btn btn-primary">
    </form>
</div>
<div class="container p-4 mt-4 bg-grey">
    <h2>All Comments</h2>

    @foreach ($comments as $comment)
    <div class="mb-3">
        <h5>{{ $comment->name }}</h5>
        <p>{{ $comment->comment }}</p>
        <div class="d-flex">
            <div>
                <a href="javascript:void(0);" onclick="reply(this)" data-Commentid="{{ $comment->id }}" class="p-1 btn btn-primary">Reply</a>
            </div>
            @if ($comment->user_id == auth()->id())
                &nbsp;
                <form action="{{ route('delete_comment', $comment->id) }}" method="POST" onsubmit="confirmForm(event, 'Are you sure you want to delete this comment?', 'This action cannot be undone.')">
                    @csrf
                    <button type="submit" class="p-1 btn btn-danger">
                        Delete
                    </button>
                </form>
            @endif
        </div>

        @foreach ($replies as $item)
            @if($item->comment_id==$comment->id)
                <div class="my-3 ml-5">
                    @if($item->parent_name)
                        <b>{{ $item->name }} <i class="badge">Reply to @ {{ $item->parent_name }}</i></b>
                    @else
                        <b>{{ $item->name }} </b>
                    @endif
                    <p>{{ $item->reply }}</p>
                    <div class="d-flex">
                        <div>
                            <a href="javascript:void(0);" onclick="reply_to_reply(this, {{ $item->id }})" data-Commentid="{{ $comment->id }}" data-Replyid="{{ $item->id }}" class="p-1 btn btn-primary">Reply</a>
                        </div>

                        @if ($item->user_id == auth()->id())
                            &nbsp;
                            <form action="{{ route('delete_reply', $item->id) }}" method="POST" onsubmit="confirmForm(event, 'Are you sure you want to delete this reply?', 'This action cannot be undone.')">
                                @csrf
                                <button type="submit" class="p-1 btn btn-danger">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- @foreach ($reply as $nested_reply)
                        @if($nested_reply->parent_id==$item->id)
                            <div class="my-3 ml-5">
                                <b>{{ $nested_reply->name }}  <i class="badge">Reply to @ {{ $item->name }}</i></b>
                                <p>{{ $nested_reply->reply }}</p>
                                <div class="d-flex">
                                    <div>
                                        <a href="javascript:void(0);" onclick="reply_to_reply(this, {{ $nested_reply->id }})" data-Commentid="{{ $comment->id }}" data-Replyid="{{ $nested_reply->id }}" class="p-1 btn btn-primary">Reply</a>
                                    </div>

                                    @if ($nested_reply->user_id == auth()->id())
                                        &nbsp;
                                        <form action="{{ route('delete_reply', $nested_reply->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-1 btn btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach --}}

                </div>
            @endif
        @endforeach
    </div>
    @endforeach

    <section class="mb-3 d-none " id="reply">
        <form action="{{ route('reply') }}" method="POST">
            @csrf
            <input type="text" name="commentId" id="commentId" class="d-none">
            <input type="text" name="parentId" id="parentId" class="d-none">
            <textarea name="reply" id="replyContent" cols="30" rows="5" placeholder="" class="form-control"></textarea>
            <br>
            <button type="submit" class="btn btn-primary">Reply</button>
            {{-- <a href="javascript:void(0);" class="btn btn-primary">Reply</a> --}}
            <a href="javascript:void(0);" class="btn btn-secondary" onclick="reply_close(this)">Close</a>
        </form>
    </section>
</div>

