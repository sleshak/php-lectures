<?php

namespace App\Repository;

use App\Model\Task;

class FileTaskRepository implements TaskRepositoryInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function findAll(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }

        $content = file_get_contents($this->filePath);
        if (empty($content)) {
            return [];
        }

        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        $tasks = [];
        foreach ($data as $taskData) {
            $task = new Task($taskData['title']);
            if ($taskData['completed']) {
                $task->complete();
            }
            $tasks[] = $task;
        }

        return $tasks;
    }

    public function add(Task $task): void
    {
        $tasks = $this->findAll();
        $tasks[] = $task;

        $data = [];
        foreach ($tasks as $task) {
            $data[] = [
                'title' => $task->getTitle(),
                'completed' => $task->isCompleted()
            ];
        }

        file_put_contents( 
            $this->filePath, 
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }
}