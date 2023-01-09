@extends("layouts.app")
@section("content")
    <div class="container">

        @if (session("info"))
            <div class="alert alert-info">
                {{ session("info") }}
            </div>
        @endif

            <div class="card border-primary mb-2">
                <div class="card-body">
                    <h3 class="card-title">{{ $article->title }}</h3>

                    <div>
                        <small class=" text-muted">
                            Comments: ({{ count($article->comments) }}),
                            Category: <b>{{ $article->category->name }}</b>,
                            {{ $article->created_at }}
                        </small>
                    </div>

                    <div>{{ $article->body }}</div>


                    @auth
                        @can('article-delete', $article)
                            <div class="mt-2">
                                <a href="{{ url("/articles/delete/$article->id") }}"
                                class="btn btn-danger">Delete</a>
                            </div>
                        @endcan
                    @endauth

                </div>
            </div>

            <hr>

            <ul class="list-group">
                <li class="list-group-item active">
                    <b>Comments ({{ count($article->comments) }})</b>
                </li>

                @foreach ($article->comments as $comment)
                    <li class="list-group-item">
                        @auth
                            @can('comment-delete', $comment)
                                <a href="{{ url("/comments/delete/$comment->id") }}"
                                class="btn-close float-end"></a>
                            @endcan
                        @endauth

                        <b class="text-success">
                            {{ $comment->user->name }}
                        </b>,
                        {{ $comment->content }}
                    </li>
                @endforeach
            </ul>

            @auth
                <form action="{{ url("/comments/add") }}" method="post" class="mt-4">
                    @csrf
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <textarea name="content" class="mb-2 form-control"></textarea>
                    <button class="btn btn-warning">Add Comment</button>
                </form>
            @endauth

    </div>
@endsection
