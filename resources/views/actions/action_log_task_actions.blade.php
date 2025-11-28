<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        @if($action_log_task->status == ACTION_LOG_TASK_COMPLETED)
        <a class="btn-primary" href="#" onclick="taskReopening();">
            <i class="fa fa-edit"></i>
            <span>Reopen Action Log Task</span>
            <form id="task_reopen" class="form-horizontal" action="{{ route('action_log_tasks.reopen') }}" method="POST" style="display: none;">
                <input type="hidden" name="id" value="{{ $action_log_task->id }}">
                {{ csrf_field() }}
            </form>
        </a>
        @else
        <a class="btn-primary clarify_tertiary" title="Complete Action Log Task" href="{{ route('action_log_tasks.complete',$action_log_task->id) }}">
            <i class="fa fa-edit"></i>
            <span>Complete Action Log Task</span>
        </a>
        @endif
    </div>
</div>
