@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{'/tickets/' . $ticket->id}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="form-group">
                <label for="title">Title</label>
                <input name="title" value="{{ old('message', $ticket->title) }}" type="text" class="form-control" id="title"
                       aria-describedby="emailHelp"
                       placeholder="Title">
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="category_id" class="form-control" id="category">
                    @foreach($categories as $category)
                        <option @if(old('category_id', $ticket->category->id) == $category->id) selected
                                @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="priority">Priority</label>
                <select name="priority" class="form-control" id="priority">
                    <option @if(old('priority', $ticket->priority) === 'Low') selected @endif>Low</option>
                    <option @if(old('priority', $ticket->priority) === 'Medium') selected @endif>Medium</option>
                    <option @if(old('priority', $ticket->priority) === 'High') selected @endif>High</option>
                </select>
            </div>
            @can('change tickets status')
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" id="priority">
                        <option value="open" @if(old('status', $ticket->status) === 'open') selected @endif>Open</option>
                        <option value="closed" @if(old('status', $ticket->status) === 'closed') selected @endif>Closed</option>
                    </select>
                </div>
            @endcan
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" class="form-control" id="message"
                          placeholder="Message">{{ old('message', $ticket->message) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
