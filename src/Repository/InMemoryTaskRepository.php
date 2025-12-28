<?php

namespace App\Repository;

use App\Model\Task;

class InMemoryTaskRepository implements TaskRepositoryInterface
{
    private array $tasks = []; 
    public function __construct()
    {
        $this->tasks = [
            new Task("Проспааааать пары"),
            new Task("Проспать пары"),
            new Task("Проспаааааааааааать пары")
        ];
    }

    public function findAll(): array
    {
        return $this->tasks;
    }

    public function add(Task $task): void
    {
        $this->tasks[] = $task; 
    }
}