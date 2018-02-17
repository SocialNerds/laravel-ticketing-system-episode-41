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
        <form action="/tickets/save" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="title">Title</label>
                <input value="{{old('title')}}" name="title" type="text" class="form-control" id="title"
                       aria-describedby="emailHelp"
                       placeholder="Title">
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category_id" class="form-control" id="category">
                    @foreach($categories as $category)
                        <option @if(old('category_id') == $category->id) selected
                                @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="priority">Priority</label>
                <select name="priority" class="form-control" id="priority">
                    <option @if(old('priority') === 'Low') selected @endif>Low</option>
                    <option @if(old('priority') === 'Medium') selected @endif>Medium</option>
                    <option @if(old('priority') === 'High') selected @endif>High</option>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" class="form-control" id="message"
                          placeholder="Message">{{old('message')}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
