<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hidroganik Alfa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Hidroganik Alfa</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/admin" class="nav-link text-white">Dashboard</a>
                </li>
                <li>
                    <a href="/admin/settings" class="nav-link text-white">General Settings</a>
                </li>
                <li>
                    <a href="/admin/sliders" class="nav-link text-white">Sliders</a>
                </li>
                <li>
                    <a href="/admin/services" class="nav-link text-white">Services</a>
                </li>
                <li>
                    <a href="/admin/articles" class="nav-link text-white">Articles</a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="/logout" class="d-flex align-items-center text-white text-decoration-none">
                    <strong>Logout</strong>
                </a>
            </div>
        </div>
        <div class="flex-grow-1 p-4 bg-light" style="max-height: 100vh; overflow-y: auto;">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
