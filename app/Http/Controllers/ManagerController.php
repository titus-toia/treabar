<?php namespace Treabar\Http\Controllers;

use Illuminate\Support\Facades\Input;
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

  public function comments(Task $task) {
    return view('manage/task-comments')->with('comments', $task->comments);
  }

  public function create(Project $project) {
    $parent = Task::find(Input::get('parent_id'));
    $users = $project->users;
    return view('manage.task-form')
      ->with('parent', $parent)
      ->with('users', $users);
  }

  public function edit(Project $project, Task $task) {
    $parent = $task->parent;
    $users = $project->users;
    return view('manage.task-form')
      ->with('parent', $parent)
      ->with('users', $users);
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
