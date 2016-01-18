<?php namespace Treabar\Http\Controllers;

use Treabar\Models\Project;
use Treabar\Models\Task;
use Treabar\Models\User;

class ManagerController extends Controller {
  public function __construct() {
    //$this->middleware()
  }

  public function getData() {

  }

  public function index() {
    return view('manage')->with('projects', $this->getProjects());
  }

  public function projects() {
    return view('manage.projects')->with('projects', $this->getProjects());
  }

  public function tasks(Project $project) {
    return view('manage/tasks')->with('tasks', $project->tasks);
  }

  public function create(Project $project) {
    return view('manage.form');
  }

  public function edit(Project $project, Task $task) {
    return view('manage.form');
  }

  public function store(Project $project, Task $task) {

  }

  public function update(Task $task) {

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

  private function getProjects() { //TODO: Where does this belong? Service layer? Model?
    $user = \Auth::user();
    if($user->role === User::ROLE_MANAGER || $user->role === User::ROLE_ROOT)
      $projects = $user->company->projects;
    else
      $projects = $user->projects;

    return $projects;
  }
}
