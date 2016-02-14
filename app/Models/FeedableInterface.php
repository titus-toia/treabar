<?php
namespace Treabar\Models;

interface FeedableInterface {
  public function content();

  public function project();

  public function task();

}