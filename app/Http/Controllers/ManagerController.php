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

}
