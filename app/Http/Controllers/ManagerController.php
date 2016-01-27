<?php namespace Treabar\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Treabar\Models\Activity;
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

  /* Manager */
  public function tasks(Project $project) {
    return view('manage/tasks')->with('tasks', $project->tasks);
  }
  public function comments(Task $task) {
    return view('manage/task-comments')->with('comments', $task->comments);
  }
  public function createTask(Project $project) {
    $parent = Task::find(Input::get('parent_id'));
    $users = $project->users;
    return view('manage.task-form')
      ->with('parent', $parent)
      ->with('users', $users);
  }
  public function editTask(Project $project, Task $task) {
    $parent = $task->parent;
    $users = $project->users;
    return view('manage.task-form')
      ->with('parent', $parent)
      ->with('users', $users);
  }
  public function storeTask(Project $project, Task $task) {

  }
  public function updateTask(Task $task) {

  }
  public function deleteTask(Task $task) {
    return json_encode(['status' => 'ok']);
  }

  /* Timesheet */
  public function timesheet(Project $project) {
    return view('manage/timesheet')->with('activities', $project->activities);
  }
  public function storeActivity(Project $project, Task $task) {

  }
  public function editActivity(Activity $activity) {

  }
  public function deleteActivity(Activity $activity) {

  }

  /* Chart */
  public function chart() {
    return view('manage/chart');
  }

  /* Feed */
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
