<?php namespace Treabar\Http\Controllers;

use Treabar\Models\User;

class ManagerController extends Controller {
  public function __construct() {
    //$this->middleware()
  }

  public function getData() {

  }

  public function index() {
    $user = \Auth::user();
    if($user->role === User::ROLE_MANAGER || $user->role === User::ROLE_ROOT)
      $projects = $user->company->projects;
    else
      $projects = $user->projects;

    return view('manage')->with('projects', $projects);
  }

  public function tasks() {
    return view('manage/tasks');
  }

  public function timesheet() {
    return view('manage/timesheet');
  }

  public function chart() {
    return view('manage/chart');
  }

  public function feed() {
    return view('manage/feed');
  }
}
