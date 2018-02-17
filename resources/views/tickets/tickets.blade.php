@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <a class="btn btn-primary" href="/tickets/create">Create ticket</a>
        @if(!request()->query('all'))
            <a class="btn btn-primary" href="?all=true">Show all</a>
        @else
            <a class="btn btn-primary" href="/">Show open</a>

        @endif
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">User</th>
                <th scope="col">Category</th>
                <th scope="col">Priority</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
                @can('delete tickets')
                    <th scope="col"></th>
                @endcan
            </tr>
            </thead>
            <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td><a href="{{'ticket/'. $ticket->id}}">{{$ticket->id}}</a></td>
                    <td>{{$ticket->title}}</td>
                    <td>{{$ticket->user->name}}</td>
                    <td>{{$ticket->category->name}}</td>
                    <td>{{$ticket->priority}}</td>
                    <td>{{$ticket->status}}</td>
                    <td>
                        <a class="btn btn-warning" href="{{'/tickets/' . $ticket->id . '/edit'}}">Edit</a>
                    </td>
                    @can('delete tickets')
                        <td>
                            <a class="btn btn-danger" href="{{'/tickets/' . $ticket->id . '/edit'}}">Delete</a>
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$tickets->links()}}
    </div>
@endsection
