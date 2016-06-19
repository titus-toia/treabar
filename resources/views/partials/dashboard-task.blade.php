<div class="task" data-id="{{ $task->id }}">
  <h5>
    {{ $task->name }}
    <small>Estimated/Completion: <span>{{$task->durationReadable()}} / {{ round($task->completion(), 1) }}%,
      </span> {{round($task->loggedTotal())?: 0}}h logged.
      <a href="{{ url('manage#tasks') }}" target="_blank">Go to task</a>
    </small>

  </h5>

  <table>
    <tr>
      <td>Leaf tasks: {{ $task->leaves()->count() }}</td>
      <td>Leaf tasks overtime: {{ $task->getLeafOvertime()?: 0 }}h</td>
      <td>Non-leaf tasks overtime: {{ $task->getTrunkOvertime()?: 0 }}h</td>
    </tr>
    <tr>
      <td>Total logged today: {{ round($task->loggedTotal('today'))?: 0 }}h</td>
      <td>Total logged yesterday: {{ round($task->loggedTotal('yesterday'))?: 0 }}h</td>
      <td>Total logged last 7 days: {{ round($task->loggedTotal('-7 days'))?: 0 }}h</td>
    </tr>
  </table>
</div>