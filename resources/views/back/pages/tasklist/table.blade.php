@foreach($tasks as $key => $task)
                                                    <tr data-task-id="{{ $task->id }}"> <!-- Add data-task-id attribute -->
                                                        <td>
                                                            <input type="checkbox" class="task-checkbox" name="task_id[]" value="{{ $task->id }}">
                                                        </td>
                                                        <td>{{ @$loop->iteration }}</td>
                                                        <td>{{ @$task->tast }}</td>
                                                        <td>{{ @$task->user->name }}</td>
                                                        <td>{{ @$task->status }}</td>
                                                        <td>
                                                            @if(auth()->user()->can('administrator') || auth()->user()->can('user_task_edit'))
                                                            <button class="btn btn-outline-primary btn-sm edit-task"
                                                                data-task-id="{{ @$task->id }}"
                                                                data-task-name="{{ @$task->tast }}"
                                                                data-assignee-id="{{ @$task->user->id }}" title="Edit Task"><i
                                                                    class="fas fa-edit"></i></button>
                                                            @endif
                                                        </td>
                                                        <td class="drag-handle"><i class="fas fa-arrows-alt"></i></td> <!-- Drag handle icon -->
                                                    </tr>
                                                    @endforeach