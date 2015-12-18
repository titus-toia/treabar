<?php namespace App\Http\Controllers;

class ManagerController extends Controller {
  public function __construct() {
    $this->middleware('guest');
  }

  public function getData() {

  }

  public function index() {
    return view('manage');
  }

  public function tasks() {
    return view('manage/tasks');
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
}
