<?php

namespace Treabar\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Treabar\Http\Requests;
use Treabar\Models\Activity;
use Treabar\Models\Comment;
use Treabar\Models\Company;
use Treabar\Models\Feedable;
use Treabar\Models\User;

class SettingsController extends Controller
{
  public function loginForm() {
    return view()->make('login');
  }
  public function login() {
    if(\Auth::attempt(['email' => Input::get('email'), 'password'=> Input::get('password')])) {
      return redirect()->route('dashboard');
    } else {
      return redirect()->route('login.form');
    }
  }

  public function __construct() {
    view()->share('page', 'settings');
  }

  public function userSettings() {
    $company = \Auth::user()->company;

    return view()->make('settings.self', [
      'user' => \Auth::user(),
      'company' => $company,
    ]);
  }

  public function companySettings() {
    $company = \Auth::user()->company;

    return view()->make('settings.company', [
      'company' => $company,
      'devs' => $company->devs,
      'managers' => $company->managers,
      'clients' => $company->clients
    ]);
  }

  public function updateCompany(Company $company) {
    $company->update([
      'name' => Input::get('name')
    ]);

    if(Input::hasFile('icon')) {
      if ($company->icon && file_exists(public_path('img/companies/' . $company->icon))) unlink(public_path('img/companies/' . $company->icon));
      $filename = uniqid() . $company->id . '.' . request()->file('icon')->getClientOriginalExtension();
      request()->file('icon')->move(public_path('img/companies'), $filename);
      $company->icon = $filename;
      $company->save();
    }

    return redirect()->route('settings.company');
  }
  public function storeUser(Company $company) {
    if(Input::get('name') && Input::get('password') && Input::hasFile('icon')) {
      $user = User::create([
        'name' => Input::get('name'),
        'email' => Input::get('email'),
        'password' => \Hash::make(Input::get('password')),
        'role' => Input::get('role'),
        'company_id' => $company->id
      ]);
      $filename = uniqid() . $user->id .  '.' . request()->file('icon')->getClientOriginalExtension();
      request()->file('icon')->move(public_path('img/users'),  $filename);
      $user->icon = $filename;
      $user->save();
    }

    return redirect()->route('settings.company');
  }
  public function updateUser(Company $company, User $user) {
    if(Input::get('name')) {
      $user->update([
        'name' => Input::get('name'),
        'email' => Input::get('email'),
        'password' => \Hash::make(Input::get('password'))
      ]);

      if(Input::hasFile('icon')) {
        if($user->icon && file_exists(public_path('img/users/' . $user->icon))) unlink(public_path('img/users/' . $user->icon));
        $filename = uniqid() . $user->id . '.' . request()->file('icon')->getClientOriginalExtension();
        request()->file('icon')->move(public_path('img/users'), $filename);
        $user->icon = $filename;
        $user->save();
      }
    }
    if($user->id == \Auth::user()->id) {
      return redirect()->route('settings.user');
    } else {
      return redirect()->route('settings.company');
    }
  }

  public function deleteUser(User $user) {
    if($user->icon && file_exists(public_path('img/users/' . $user->icon))) unlink(public_path('img/users/' . $user->icon));
    $user->activities()->delete();
    $user->comments()->delete();
    $user->delete();

    return redirect()->route('settings.company');
  }
}