<?php

namespace Treabar\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Treabar\Http\Requests;
use Treabar\Models\Activity;
use Treabar\Models\Comment;
use Treabar\Models\Feedable;

class DashboardController extends Controller
{
  public function __construct() {
    view()->share('page', 'dashboard');
  }

  public function activityFeed() {
    $projects = \Auth::user()->getProjects();
    $created = Input::get('created');
    $feed = Feedable::feed(Activity::ofProjects($projects), $created);

    return view('partials.scrollers.notifications-activity', [
      'activities' => $feed,
      'only_data' => true
    ]);
  }

  public function discussionFeed() {
    $projects = \Auth::user()->getProjects();
    $created = Input::get('created');
    $feed = Feedable::feed(Comment::ofProjects($projects), $created);

    return view('partials.scrollers.notifications-discussion', [
      'comments' => $feed,
      'only_data' => true
    ]);
  }

  public function index() {
    $projects = \Auth::user()->getProjects();
    $comments = Feedable::feed(Comment::ofProjects($projects));
    $activities = Feedable::feed(Activity::ofProjects($projects));

    return view('dashboard', [
      'projects' => $projects,
      'activities' => $activities,
      'comments' => $comments
    ]);
  }

}
