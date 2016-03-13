<?php

namespace Treabar\Http\Controllers;

use Illuminate\Http\Request;

use Treabar\Http\Requests;
use Treabar\Http\Controllers\Controller;
use Treabar\Models\Activity;
use Treabar\Models\Comment;

class DashboardController extends Controller
{
  public function __construct() {
  }


  public function index() {
    $projects = \Auth::user()->getProjects();
    $comments = Comment::ofProjects($projects);
    $activities = Activity::ofProjects($projects);

    return view('dashboard', [
      'projects' => $projects,
      'activities' => $activities,
      'comments' => $comments
    ]);
  }

}
