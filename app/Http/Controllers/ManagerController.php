<?php namespace Treabar\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Treabar\Models\Activity;
use Treabar\Models\Feedable;
use Treabar\Models\Project;
use Treabar\Models\Task;
use Treabar\Models\User;

class ManagerController extends Controller {
  public function __construct() {
    view()->share('page', 'manager');
  }

  public function index() {
    return view('manage')->with('projects', \Auth::user()->getProjects());
  }

  public function projects() {
    return view('manage.projects')->with('projects', \Auth::user()->getProjects());
  }

  public function createProject() {
    return view('manage.project-form')->with('users', \Auth::user()->company->users);
  }

  public function storeProject() {

  }

  public function editProject(Project $project) {
    return view('manage.project-form')
      ->with('project', $project)
      ->with('users', \Auth::user()->company->users);
  }

  public function updateProject(Project $project) {

  }

  /* Tasks */
  public function tasks(Project $project) {
    return view('manage/tasks')->with('tasks', $project->tasks);
  }
  public function comments(Task $task) {
    return view('partials/scrollers/task-comments')->with('comments', $task->comments);
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
  public function moveTask(Task $task) {

  }
  public function completeTask(Task $task) {
  }
  public function deleteTask(Task $task) {
    return json_encode(['status' => 'ok']);
  }

  /* Timesheet */
  public function timesheet(Project $project) {
    $activities = $this->GetFeed($project->activities(), $onlyData);

    return view('manage/timesheet', [
      'project' => $project,
      'activities' => $activities,
      'only_data' => $onlyData
    ]);
  }
  public function createActivity(Project $project) {
    return view('manage.activity-form');
  }
  public function storeActivity(Project $project) {
  }
  public function editActivity(Project $project, Activity $activity) {
    $tasks = $project->getTaskHierarchies();
    return view('manage.activity-form')->with('tasks', $tasks);
  }
  public function updateActivity(Project $project, Activity $activity) {
  }
  public function deleteActivity(Activity $activity) {
  }

  /* Chart */
  public function chart() {
    return view('manage/chart');
  }

  /* Feed */
  public function feed(Project $project) {
    $this->GetFeed(null, $onlyData, $before);
    $feed = Feedable::ofProject($project, $before);

    return view('manage/feed', [
      'project' => $project,
      'feed' => $feed,
      'only_data' => $onlyData
    ]);
  }

  private function GetFeed($eloquent = null, &$onlyData, &$before = null) {
    $before = Input::get('before');
    $onlyData = $before? true: false;

    if($eloquent) {
      return Feedable::feed($eloquent, $before);
    }

    return true;
  }
}
