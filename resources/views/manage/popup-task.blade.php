@extends('popup')
@section('content')
  Task Form
  @if(isset($project))
    {{ dump($project) }}
  @else
    <h1>New form for new Task</h1>
  @endif
@endsection