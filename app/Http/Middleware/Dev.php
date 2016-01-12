<?php

namespace Treabar\Http\Middleware;

use Auth;
use Closure;

class Dev {
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next) {
    Auth::loginUsingId(2); //1 is always root; 2 is the manager of the first company
    return $next($request);
  }
}
