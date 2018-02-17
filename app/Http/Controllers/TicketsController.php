<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tickets = Ticket::when(
          is_null($request->get('all')),
          function ($query) {
              $query->where('status', 'open');
          }
        )
          ->when(!Auth::user()->hasRole(['admin', 'support']), function ($query) {
              $query->where('user_id', Auth::user()->id);
          })
          ->orderBy('id', 'desc')->paginate(15);

        return view('tickets.tickets', ['tickets' => $tickets]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('tickets/create', ['categories' => $categories]);
    }

    public function save(Request $request)
    {
        $this->validate(
          $request,
          [
            'title'       => 'required',
            'category_id' => 'required',
            'priority'    => 'required',
            'message'     => 'required|min:10',
          ]
        );

        $ticket = Ticket::create(
          [
            'title'       => $request->input('title'),
            'category_id' => $request->input('category_id'),
            'priority'    => $request->input('priority'),
            'status'      => 'open',
            'message'     => $request->input('message'),
            'user_id'     => Auth::user()->id,
          ]
        );
        $request->session()->flash('status', 'Ticket '.$ticket->id.' created!');


        return redirect('/home');
    }

    public function edit($id)
    {
        $ticket = Ticket::find($id);

        $categories = Category::all();

        return view(
          'tickets/edit',
          ['categories' => $categories, 'ticket' => $ticket]
        );
    }

    public function update($id, Request $request)
    {
        $ticket = Ticket::find($id);

        $this->validate(
          $request,
          [
            'title'       => 'required',
            'category_id' => 'required',
            'priority'    => 'required',
            'message'     => 'required|min:10',
          ]
        );

        $updatedFields = $request->only(
          ['title', 'category_id', 'status', 'priority', 'message']
        );
        $ticket->fill($updatedFields);
        $ticket->save();

        $request->session()->flash('status', 'Ticket '.$ticket->id.' updated!');


        return redirect('/home');
    }

    public function ticket($id)
    {
        $ticket   = Ticket::find($id);
        $comments = $ticket->comments()->orderBy('created_at', 'desc')->paginate(5);

        return view('tickets.ticket', compact('ticket', 'comments'));
    }

    public function comment($id, Request $request)
    {

        Comment::create(
          [
            'ticket_id' => $id,
            'user_id'   => Auth::user()->id,
            'comment'   => $request->input('comment'),
          ]
        );

        return redirect('/ticket/' . $id);
    }
}
