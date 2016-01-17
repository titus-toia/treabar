<?php

namespace Treabar\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ComposeViews {
  public function handle(Request $request, Closure $next) {
    //Share automatic model bindings
    foreach($request->route()->parameters() as $name => $parameter) {
      if($parameter instanceof Model) {
        view()->share($name, $parameter);
      }
    }

    view()->share('logged_user', \Auth::user());
    return $next($request);
  }
}
