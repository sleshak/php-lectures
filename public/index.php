<?php

declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use App\Repository\InMemoryTaskRepository;
use App\Repository\FileTaskRepository;
use App\Repository\MySqlTaskRepository;
use App\Repository\TaskRepositoryInterface;
use App\Controller\TaskController;
use App\Container\Container;

$route = $_GET['route'] ?? 'task/list';

$config = require __DIR__ . '/../config.php';

$container = new Container();

$container->set(PDO::class, function () use ($config) {
    return new PDO(
        $config['db']['dsn'],
        $config['db']['user'],
        $config['db']['pass'],
        $config['db']['options']
    );
});

$container->set(FileTaskRepository::class, function () use ($config) {
    return new FileTaskRepository($config['storage']);
});

$container->set(MySqlTaskRepository::class, function (Container $c) {
    $pdo = $c->get(PDO::class);
    return new MySqlTaskRepository($pdo);
});

$container->set(TaskRepositoryInterface::class, function (Container $c) use ($config) {
    return match ($config['repository']) {
        'mysql' => $c->get(MySqlTaskRepository::class),
        'file' => $c->get(FileTaskRepository::class),
        default => new InMemoryTaskRepository()
    };
});

$container->set(TaskController::class, function (Container $c) {
    $repo = $c->get(TaskRepositoryInterface::class);
    return new TaskController($repo);
});

$controller = $container->get(TaskController::class);

switch ($route) {
    case 'task/list':
        $controller->list();
        break;
    case 'task/add':
        $controller->add();
        break;
    default:
        http_response_code(404);
        echo '404 not found';
}