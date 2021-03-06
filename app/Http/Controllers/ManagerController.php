<?php namespace Treabar\Http\Controllers;

use Treabar\Lib\CriticalPath;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Treabar\Models\Activity;
use Treabar\Models\Comment;
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
    return view('manage.project-form')->with('users', \Auth::user()->company->users)
      ->with('clients', \Auth::user()->company->clients);
  }

  public function storeProject() {
    $project = Project::create([
      'name' => Input::get('name'),
      'slug' => str_slug(Input::get('name')),
      'from' => Input::get('from')? Carbon::createFromFormat('d-m-Y', Input::get('from')): null,
      'to' => Input::get('to')? Carbon::createFromFormat('d-m-Y', Input::get('to')): null,
      'color' => Input::get('color'),
      'client_id' => Input::get('client_id'),
      'company_id' => Input::get('company_id')?: \Auth::user()->company_id
    ]);
    $project->users()->sync(Input::get('user_ids', []));

    return $project;
  }

  public function editProject(Project $project) {
    return view('manage.project-form', [
      'project' => $project,
      'users' => \Auth::user()->company->users
    ]);
  }

  public function updateProject(Project $project) {
    $project->update([
      'name' => Input::get('name'),
      'slug' => str_slug(Input::get('name')),
      'from' => Input::get('from')? Carbon::createFromFormat('d-m-Y', Input::get('from')): null,
      'to' => Input::get('to')? Carbon::createFromFormat('d-m-Y', Input::get('to')): null,
      'color' => Input::get('color'),
      'client_id' => Input::get('client_id')
    ]);
    $project->users()->sync(Input::get('user_ids', []));
  }

  /* Tasks */
  public function tasks(Project $project) {
    return view('manage/tasks')->with('tasks', $project->tasks);
  }

  public function comments(Task $task) {
    $comments = $this->GetFeed($task->comments(), $onlyData);

    return view('partials/scrollers/task-comments', [
      'task' => $task,
      'comments' => $comments,
      'only_data' => $onlyData
    ]);
  }

  public function createTask(Project $project) {
    $parent = Task::find(Input::get('parent_id'));
    $users = $project->users;
    $tasks = $project->tasks(true)->get();

    return view('manage.task-form', [
      'tasks' => $tasks,
      'parent' => $parent,
      'users' => $users
    ]);
  }

  public function storeTask(Project $project) {
    $task = Task::create([
      'name' => Input::get('name'),
      'description' => Input::get('description'),
      'duration' => Input::get('duration'),
      'from' => Input::get('from')? Carbon::createFromFormat('d-m-Y', Input::get('from')): null,
      'to' => Input::get('to')? Carbon::createFromFormat('d-m-Y', Input::get('to')): null,
      'master_id' => Input::get('master_id', null),
      'user_id' => Input::get('user_id'),
      'project_id' => $project->id,
    ]);

    $parent = Task::find(Input::get('parent_id'));
    if($parent) {
      $task->makeChildOf($parent);
    }

    return $task;
  }

  public function editTask(Project $project, Task $task) {
    $parent = $task->parent;
    $users = $project->users;
    $tasks = $project->tasks(true)->get()->except($task->id);
    $task->loggedTotal();

    return view('manage.task-form', [
      'tasks' => $tasks,
      'task' => $task,
      'parent' => $parent,
      'users' => $users
    ]);
  }

  public function comment(Task $task) {
    $comment = Comment::create([
      'content' => Input::get('content'),
      'task_id' => $task->id,
      'project_id' => $task->project_id,
      'user_id' => \Auth::user()->id
    ]);

    return $comment;
  }

  public function updateTask(Task $task) {
    $task->update([
      'name' => Input::get('name'),
      'description' => Input::get('description'),
      'duration' => Input::get('duration'),
      'from' => Input::get('from')? Carbon::createFromFormat('d-m-Y', Input::get('from')): null,
      'to' => Input::get('to')? Carbon::createFromFormat('d-m-Y', Input::get('to')): null,
      'master_id' => Input::get('master_id', null),
      'user_id' => Input::get('user_id')
    ]);

    return $task;
  }

  public function moveTask(Task $task) {
    $parent = Task::find(Input::get('parent_id'));
    $task->makeChildOf($parent);

    return $task;
  }

  public function invoiceTask(Project $project, Task $task) {
    if($task->invoice_id) {
        return redirect()->route('invoice.edit', $task->invoice_id);
    } else {
        return redirect()->route('invoice.create', $task->id);
    }
  }

  public function completeTask(Task $task) {
    $task->update(['finished' => true]);

    Activity::create([
      'description' => "Task {$task->name} completed.",
      'type' => Activity::TYPE_COMPLETION,
      'started_at' => Carbon::now(),
      'task_id' => $task->id,
      'user_id' => \Auth::user()->id,
      'project_id' => $task->project_id
    ]);

    return $task;
  }
  public function deleteTask(Task $task) {
    $task->delete();
  }

  /* Timesheet */
  public function timesheet(Project $project) {
    $activities = $this->GetFeed($project->activities()->where('type',
      Activity::TYPE_ACTIVITY), $onlyData);
    return view('manage/timesheet', [
      'project' => $project,
      'activities' => $activities,
      'only_data' => $onlyData
    ]);
  }
  public function createActivity(Project $project) {
    $tasks = $project->getTaskHierarchies();
    return view('manage.activity-form', ['tasks' => $tasks]);
  }
  public function storeActivity(Project $project) {
    $started_at = new Carbon(Input::get('started_at'));
    $finished_at = new Carbon(Input::get('finished_at'));
    $diff = $started_at->diffInSeconds($finished_at);

    if($diff < 0) {
      abort(500, 'Finished at should be after started at');
    }

    $activity = Activity::create([
      'description' => Input::get('description'),
      'started_at' => $started_at,
      'duration' => $diff,
      'type' => Activity::TYPE_ACTIVITY,
      'task_id' => Input::get('task_id'),
      'user_id' => \Auth::user()->id,
      'project_id' => $project->id
    ]);

    return $activity;
  }

  public function editActivity(Project $project, Activity $activity) {
    $tasks = $project->getTaskHierarchies();
    return view('manage.activity-form', ['activity' => $activity, 'tasks' => $tasks]);
  }

  public function updateActivity(Project $project, Activity $activity) {
    $started_at = new Carbon(Input::get('started_at'));
    $finished_at = new Carbon(Input::get('finished_at'));
    $diff = $started_at->diffInSeconds($finished_at);

    if($diff < 0) {
      abort(500, 'Finished at should be after started at');
    }

    $activity->update([
      'description' => Input::get('description'),
      'started_at' => $started_at,
      'duration' => $diff,
      'type' => Activity::TYPE_ACTIVITY,
      'task_id' => Input::get('task_id')
    ]);
  }

  public function deleteActivity(Activity $activity) {
    $activity->delete();
  }

  /* Chart */
  public function chart(Project $project) {
    $tasks = Task::getGanttHierarchy($project->tasks(true)->get());
    $path = new CriticalPath($tasks);

    $dates = [];
    for($cursor = $project->from; $cursor->lte($project->to); $cursor = $cursor->addDay()) {
      $dates[] = $cursor->format('Y-m-d');
    }
//dd($path->GetChart());
    return view('manage/chart', [
      'dates' => $dates,
      'tasks' => $path->GetChart(),
      'project' => $project
    ]);
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
    $created = Input::get('created');
    $direction = Input::get('direction') != 'after'? Feedable::BEFORE: Feedable::AFTER;
    $onlyData = Input::get('created')? true: false;

    if($eloquent) {
      return Feedable::feed($eloquent, $created, $direction);
    }

    return true;
  }
}
