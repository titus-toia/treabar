<?php
namespace Treabar\Lib;

set_time_limit(10);

use Carbon\Carbon;

class CriticalPath {
  private $tasks;

  public function __construct($tasks) {
    $this->tasks = $tasks;
  }

  public function GetChart() {
    $chart = $this->getChartHelper($this->tasks);
    $trail = [];
    $this->longestPath($chart, $trail); //Side effects

    return $chart;
  }

  private function getChartHelper(&$tasks, $graph = [], $master_to = null, $level = 0) {
    foreach($tasks as &$task) {
      $i = $level;
      if($master_to === null && (!$task['from'] || !$task['to'])) continue; //If top-level task and no from/to values

      //Calculate original time different
      $diff = Carbon::createFromFormat('Y-m-d', $task['from'])->diffInDays(Carbon::createFromFormat('Y-m-d', $task['to']));

      //If new 'from' is gte than 'to', adjust end date by diff
      $from = $master_to? $master_to: $task['from'];
      if(Carbon::createFromFormat('Y-m-d', $from)->gte(Carbon::createFromFormat('Y-m-d', $task['to']))) {
        $task['to'] = Carbon::createFromFormat('Y-m-d', $from)->addDays($diff)->format('Y-m-d');
      }

      //If task is not finished and its date has passed, extend it
      if(!$task['finished'] && (new Carbon('today'))->gt(Carbon::createFromFormat('Y-m-d', $task['to']))) {
        //Slack detected!
        $slack = Carbon::createFromFormat('Y-m-d', $task['to'])->diffInDays(new Carbon('tomorrow'));
        //dd(Carbon::createFromFormat('Y-m-d', $task['to']), new Carbon('tomorrow'), $task);
        $task['slack'] = $slack;
        $task['original-to'] = $task['to'];
        $to = (new Carbon('tomorrow'))->format('Y-m-d');
      } else {
        $to = $task['to'];
        $task['slack'] = 0;
      }

      while(!$this->isFree($graph, $from, $to, $i)) {
        $i++;
      }
      $span = $this->fill($graph, $from, $to, $i);

      $task['from'] = $from;
      $task['to'] = $to;
      $task['level'] = $i;
      $task['span'] = $span;

      //Do the same thing with its children
      $this->getChartHelper($task['slaves'], $graph, $to, $i + 1);
      $level += 2; //Make subsequent tasks start lower
    }

    return $tasks;
  }

  private function longestPath(&$tasks, &$trail = []) {
    if(empty($tasks)) return 0;

    $max = ['weight' => 0, 'trail' => []];
    foreach($tasks as &$task) {
      if(!$task['from'] || !$task['to']) continue;
      $newTrail = $trail; $newTrail[] = &$task;

      $diff = Carbon::createFromFormat('Y-m-d', $task['from'])->diffInDays(Carbon::createFromFormat('Y-m-d', $task['to']));
      $weight = $diff + $this->longestPath($task['slaves'], $newTrail);

      if($max['weight'] < $weight) {
        $max['weight'] = $weight;
        $max['trail'] = $newTrail;
      }
    }

    if(empty($trail)) { //At top level
      foreach($max['trail'] as &$task) {
        $task['critical'] = true;
      }
    }

    foreach($max['trail'] as &$task) {
      if(!in_array($task, $trail)) {
        $trail[] = &$task;
      }
    }

    return $max['weight'];
  }

  private function isFree(&$graph, $from, $to, $level = 0) {
    $from = new Carbon($from);
    $to = new Carbon($to);
    $free = true;

    for($cursor = $from; $cursor->lte($to); $cursor = $cursor->addDay()) {
      if(!isset($graph[$from->format('Y-m-d')])) continue;
      if($graph[$from->format('Y-m-d')]['level'] > $level) {
        $free = false;
        break;
      }
    }

    return $free;
  }

  //Returns day-span of task
  private function fill(&$graph, $from, $to, $level) {
    $from = new Carbon($from);
    $to = new Carbon($to);

    $span = 0;
    for($cursor = $from; $cursor->lte($to); $cursor = $cursor->addDay()) {
      $graph[$from->format('Y-m-d')] = [
        'level' => $level + 1
      ];
      $span++;
    }

    return $span;
  }
}