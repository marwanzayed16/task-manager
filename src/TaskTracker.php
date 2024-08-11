<?php

namespace Marwan\TaskTracker;

require __DIR__.'/../vendor/autoload.php';
require 'functions.php';

use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;
use function Termwind\render;

class TaskTracker extends CLI
{
    protected string $jsonFileName = 'src/data.json';

    protected function setup(Options $options): void
    {
        $options->setHelp('A Task Tracker CLI');

        $commands = [
            "add" => ["Add a task", ['task_name' => true, 'task_description' => false, 'status' => false]],
            "update" => ["Update a task", ['id' => true, 'task_name' => true, 'task_description' => false]],
            "delete" => ["Delete a task", ['id' => true]],
            "list" => ["List all tasks", ['status' => false]],
            "mark-in-progress" => ["Mark task status as in-progress", ['id' => true]],
            "mark-done" => ["Mark task status as done", ['id' => true]],
            "mark-todo" => ["Mark task status as todo", ['id' => true]],
        ];

        foreach ($commands as $cmd => $data) {
            [$description, $args] = $data;
            $options->registerCommand($cmd, $description);
            foreach ($args as $arg => $isRequired) {
                $options->registerArgument($arg, ucfirst(str_replace('_', ' ', $arg)), $isRequired, $cmd);
            }
        }
    }

    protected function main(Options $options): void
    {
        $dataArray = getDataFromJson($this->jsonFileName);
        $command = $options->getCmd();
        $args = $options->getArgs();

        if (!$command) {
            $this->error('No command provided. Showing help:');
            echo $options->help();
            return;
        }

        $methodName = $this->getMethodNameFromCommand($command);
        if (method_exists($this, $methodName)) {
            $this->{$methodName}($dataArray, $args);
        } else {
            $this->error('Unknown command called. Showing help:');
            echo $options->help();
        }
    }

    private function getMethodNameFromCommand(string $command): string
    {
        $methodMap = [
            'add' => 'addTask',
            'update' => 'updateTask',
            'delete' => 'deleteTask',
            'list' => 'listTasks',
            'mark-in-progress' => 'markTaskInProgress',
            'mark-done' => 'markTaskDone',
            'mark-todo' => 'markTaskTodo',
        ];

        return $methodMap[$command] ?? '';
    }

    private function addTask(array &$dataArray, array $args): void
    {
        $id = $dataArray['id'];

        $dataArray['tasks'][] = [
            'id' => $id,
            'name' => $args[0],
            'description' => $args[1] ?? 'No Description',
            'status' => $args[2] ?? 'todo',
        ];

        $dataArray['id']++;
        editJson($this->jsonFileName, $dataArray);

        $this->info("Task added successfully (ID: $id)");
    }

    private function updateTask(array &$dataArray, array $args): void
    {
        $id = $args[0];
        $task = &$dataArray['tasks'][$id - 1];

        $task['name'] = $args[1] ?? $task['name'];
        $task['description'] = $args[2] ?? $task['description'];

        editJson($this->jsonFileName, $dataArray);

        $this->info("Task updated successfully (ID: $id)");
    }

    private function deleteTask(array &$dataArray, array $args): void
    {
        $id = $args[0] - 1;
        array_splice($dataArray['tasks'], $id, 1); // Remove the task and re-index the array

        editJson($this->jsonFileName, $dataArray);

        $this->info("Task deleted successfully (ID: ".($id + 1).")");
    }

    private function listTasks(array $dataArray, $status): void
    {
        $tasks = $status
            ? array_filter($dataArray['tasks'], fn($task) => $task['status'] === $status[0])
            : $dataArray['tasks'];

        foreach ($tasks as $task) {
            render(<<<HTML
                <div class="py-1">
                    <h2>Task Number {$task['id']}</h2>
                    <ul class="spacey-1">
                        <li class="mt-1">Name: {$task['name']}</li>
                        <li>Description: {$task['description']}</li>
                        <li>Status: {$task['status']}</li>
                    </ul>
                </div>
            HTML
            );
        }
    }

    private function markTaskInProgress(array &$dataArray, array $args): void
    {
        $this->markTask($dataArray, $args[0], 'in-progress');
    }

    private function markTask(array &$dataArray, int $id, string $status): void
    {
        $task = &$dataArray['tasks'][$id - 1];
        $task['status'] = $status;

        editJson($this->jsonFileName, $dataArray);

        $this->info("Task marked as $status successfully (ID: $id)");
    }

    private function markTaskDone(array &$dataArray, array $args): void
    {
        $this->markTask($dataArray, $args[0], 'done');
    }

    private function markTaskTodo(array &$dataArray, array $args): void
    {
        $this->markTask($dataArray, $args[0], 'todo');
    }
}

// Execute the CLI
$cli = new TaskTracker();
$cli->run();