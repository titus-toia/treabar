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

      $found = false;
      $from = $master_to? $master_to: $task['from'];
      $to = $task['to'];

      while(!$this->isFree($graph, $from, $to, $i)) {
        $i++;
      }
      $this->fill($graph, $from, $to, $i);

      $task['level'] = $i;

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

  private function fill(&$graph, $from, $to, $level) {
    $from = new Carbon($from);
    $to = new Carbon($to);

    for($cursor = $from; $cursor->lte($to); $cursor = $cursor->addDay()) {
      $graph[$from->format('Y-m-d')] = [
        'level' => $level + 1
      ];
    }

  }
}