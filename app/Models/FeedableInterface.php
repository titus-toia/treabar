<?php
namespace Treabar\Models;

interface FeedableInterface {
  public function content();

  public function icon();

  public function project();

  public function task();

  public function timestamp();
}