<?php

namespace Treabar\Lib;

use Carbon\Carbon;

class CriticalPath {
  private $tasks;

  public function __construct($tasks) {
    $this->tasks = $tasks;
  }

  public function GetChart() {
    return $this->_getChart($this->tasks);
  }

  private function _getChart(&$tasks, $graph = [], $master_to = null, $level = 0) {
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
      $this->_getChart($task['slaves'], $graph, $to, $i + 1);
      $level += 2; //Make subsequent tasks start lower
    }

    return $tasks;
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