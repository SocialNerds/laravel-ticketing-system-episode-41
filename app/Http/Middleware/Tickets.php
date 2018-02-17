<?php

namespace App\Http\Middleware;

use App\Ticket;
use Closure;
use Illuminate\Support\Facades\Auth;

class Tickets
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $ticket = Ticket::find($request->id);
        $user = Auth::user();
        if($user->hasRole(['admin', 'support']) || $user->id === $ticket->user->id) {
            return $next($request);
        }
        return redirect('home');

    }
}
