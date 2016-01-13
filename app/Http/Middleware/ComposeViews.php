<?php

namespace Treabar\Http\Middleware;

use Closure;

class ComposeViews {
  public function handle($request, Closure $next) {
    view()->share('logged_user', \Auth::user());
    return $next($request);
  }
}
