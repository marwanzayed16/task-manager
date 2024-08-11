# Task Manager

The Task Manager is a simple PHP-based application designed to help you manage tasks. You can add, list, update, and
delete tasks, each with different statuses.

## Features

- **Add Tasks**: Create new tasks with a name, description, and status.
- **List Tasks**: View tasks and filter them based on their status.
- **Update Tasks**: Modify existing tasks' details.
- **Delete Tasks**: Remove tasks by their unique ID.

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/marwanzayed16/task-manager.git
    cd task-manager
    ```

2. Ensure PHP is installed on your machine.

## Usage

### Adding a Task

To add a task, use the following command:

- **Task Name**: Required
- **Task Description**: Optional (default: 'No Description')
- **Task Status**: Optional (default: 'todo')
- **Status Options**: `done`, `todo`, `in-progress`

    ```bash
    task add <"Task Name"> <"Task Description"> <"status">
    ```

  If you do not specify a status, the default status will be 'todo'.

### Updating a Task

To update a task, use the following command:

- **Task ID**: Required
- **Task Name**: Required
- **Task Description**: Optional (default: 'No Description')

    ```bash
    task update <id> <"Task Name"> <"Task Description">
    ```

### Deleting a Task

To delete a task, use the following command:

- **Task ID**: Required

    ```bash
    task delete <id>
    ```

### Listing All Tasks

To list all tasks, use the following command:

- No data required

  ```bash
  task list
  ```

### Listing Tasks by Status

To list tasks by status, use the following command:

- **Status Options**: `done`, `todo`, `in-progress`

    ```bash
    task list <status>
    ```

### Marking a Task as Done

To mark a task as done, use the following command:

- **Task ID**: Required

    ```bash
    task mark-done <id>
    ```

### Marking a Task as In-Progress

To mark a task as in-progress, use the following command:

- **Task ID**: Required

    ```bash
    task mark-in-progress <id>
    ```

### Marking a Task as To-Do

To mark a task as to-do, use the following command:

- **Task ID**: Required

    ```bash
    task mark-todo <id>
    ```

## Examples (Wndows)

- **Add a new task**:
    ```bash
    task add "Complete project" "Finish the project by end of the week"
    ```
  This will create a task with the default status 'todo'.

- **Update a task**:
    ```bash
    task update 1 "Complete project" "Finish the project by next Friday"
    ```

- **List tasks by status**:
    ```bash
    task list done
    ```

- **Mark a task as done**:
    ```bash
    task mark-done 1
    ```

## Examples (Linux Or Mac)

- **Add a new task**:
    ```bash
    php src\TaskTracker.php add "Complete project" "Finish the project by end of the week"
    ```
  This will create a task with the default status 'todo'.

- **Update a task**:
    ```bash
    php src\TaskTracker.php update 1 "Complete project" "Finish the project by next Friday"
    ```

- **List tasks by status**:
    ```bash
    php src\TaskTracker.php list done
    ```

- **Mark a task as done**:
    ```bash
    php src\TaskTracker.php mark-done 1
    ```

## Notes

- Ensure all required parameters are provided to avoid errors.
- Refer to the application’s help command for more details and options.
- task is a bat file run a command `php src\TaskTracker.php %1 %2 %3 %4`

## License

This application is open source and free to use. You can contribute to its development and modify it as needed. Or you
can use it however you like.