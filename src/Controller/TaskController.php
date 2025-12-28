<?php

namespace App\Controller;

use App\Model\Task;
use App\Repository\TaskRepositoryInterface;

class TaskController {

    private TaskRepositoryInterface $repository;
    private array $tasks;

    public function __construct(TaskRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function list() {
        $tasks = $this->repository->findAll();
        require __DIR__ . '/../View/task_list.php';
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            
            if (empty($title)) {
                $error = 'Название задачи не может быть пустым';
                require __DIR__ . '/../View/add.php';
                return;
            }
            
            $task = new Task($title);
            $this->repository->add($task);
            
            header('Location: ?route=task/list');
            exit;
        }
        
        require __DIR__ . '/../View/add.php';
    }

    public function getTasks()  {
        return $this->repository->findAll();
    }
}