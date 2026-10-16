<?php
    session_start();
    require_once __DIR__ . '/app/Controllers/StudentController.php';

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $basePath = '/mvc-fast-track';

    $route = substr($path, strlen($basePath));

    // FIX: strip trailing slash so /students/ and /students both work
    $route = rtrim($route, '/');

    if ($route === '' || $route === '/') {
        $route = '/students';
    }

    $method = $_SERVER['REQUEST_METHOD'];
    $controller = new StudentController();

    if ($method === 'GET' && $route === '/students') {
        $controller->index();
    } elseif ($method === 'GET' && $route === '/students/create') {
        $controller->create();
    } elseif ($method === 'POST' && $route === '/students/create') {
        $controller->store();
    } elseif($method === 'POST' && $route === '/students/delete'){
        $controller->delete();
    } elseif($method == 'GET' && $route === '/students/edit'){
        $controller->edit(); 
    } elseif($method === 'POST' && $route === '/students/update'){
        $controller->update();
    } else {
        // FIX: proper 404 response + nicer page instead of "Page Kay Not Found"
        http_response_code(404);
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>404 | MVC Fast Track</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-light">
            <main class="container py-5 text-center" style="max-width: 540px;">
                <div class="card border-0 shadow-sm rounded-4 mt-5">
                    <div class="card-body p-5">
                        <h1 class="display-1 fw-bold text-primary mb-0">404</h1>
                        <p class="fs-4 fw-semibold mb-1">Page Not Found</p>
                        <p class="text-secondary mb-4">The page you are looking for does not exist or has been moved.</p>
                        <a href="/mvc-fast-track/students" class="btn btn-primary px-4">
                            &larr; Back to Students
                        </a>
                    </div>
                </div>
            </main>
        </body>
        </html>';
        exit;
    }