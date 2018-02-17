<?php

namespace App\Http\Controllers;

use App\Category;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class usersController extends Controller
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
    public function index()
    {

        $users = User::paginate(15);
        return view('users.users', ['users' => $users]);
    }

    public function edit($id)
    {
        $roles = Role::all();

        $user = User::find($id);
        return view('users.edit', compact('roles', 'user'));
    }


    public function update($id, Request $request)
    {
        $user = User::find($id);

        $user->syncRoles($request->input('roles'));
        $user->save();

        $request->session()->flash('status', 'User ' . $user->id . ' updated!');

        return redirect('/users');
    }
}
