@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="panel panel-primary">
            <div class="panel-heading">{{$ticket->title}}</div>
            <ul class="list-group">
                <li class="list-group-item">Category: {{$ticket->category->name}}</li>
            </ul>
            <div class="panel-body">
                {{$ticket->message}}
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <form action="{{'/comments/' . $ticket->id}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea name="comment" class="form-control"
                                      placeholder="Comment"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </li>
                @foreach($comments as $comment)
                    <li class="list-group-item">{{$comment->user->name}}: {{$comment->comment}}</li>
                @endforeach
            </ul>
        </div>
        {{$comments->links()}}
    </div>
@endsection
