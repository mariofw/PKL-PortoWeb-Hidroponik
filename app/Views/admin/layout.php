<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hidroganik Alfa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            transition: margin-left .3s;
        }
        .sidebar a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: #fff;
            border-left: 4px solid #28a745;
        }
        #wrapper.toggled .sidebar {
            margin-left: -280px;
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 text-white" style="width: 280px;">
            <a href="/" class="d-flex align-items-center p-3 text-white text-decoration-none bg-dark">
                <i class="fas fa-leaf text-success me-2 fs-4"></i>
                <span class="fs-5 fw-bold">Hidroganik Alfa</span>
            </a>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/admin" class="nav-link <?= uri_string() == 'admin' ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/admin/sliders" class="nav-link <?= strpos(uri_string(), 'admin/sliders') !== false ? 'active' : '' ?>">
                        <i class="fas fa-images me-2"></i> Sliders
                    </a>
                </li>
                <li>
                    <a href="/admin/settings" class="nav-link <?= strpos(uri_string(), 'admin/settings') !== false ? 'active' : '' ?>">
                        <i class="fas fa-cogs me-2"></i> General Settings
                    </a>
                </li>
                <li>
                    <a href="/admin/certificates" class="nav-link <?= strpos(uri_string(), 'admin/certificates') !== false ? 'active' : '' ?>">
                        <i class="fas fa-certificate me-2"></i> Certificates
                    </a>
                </li>
                <li>
                    <a href="/admin/partners" class="nav-link <?= strpos(uri_string(), 'admin/partners') !== false ? 'active' : '' ?>">
                        <i class="fas fa-handshake me-2"></i> Partners
                    </a>
                </li>
                <li>
                    <a href="/admin/services" class="nav-link <?= strpos(uri_string(), 'admin/services') !== false ? 'active' : '' ?>">
                        <i class="fas fa-concierge-bell me-2"></i> Services
                    </a>
                </li>
                <li>
                    <a href="/admin/articles" class="nav-link <?= strpos(uri_string(), 'admin/articles') !== false ? 'active' : '' ?>">
                        <i class="fas fa-newspaper me-2"></i> Articles
                    </a>
                </li>
            </ul>
        </div>

        <!-- Page Content Wrapper -->
        <div id="page-content-wrapper" class="w-100 d-flex flex-column" style="height: 100vh; overflow-y: hidden;">
            
            <!-- Top Bar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom px-4 py-2 justify-content-between">
                <button class="btn btn-light border" id="sidebarToggle"><i class="fas fa-bars text-secondary"></i></button>
                
                <div class="d-flex align-items-center">
                    <span class="me-3 text-secondary small d-none d-md-block">Halo, <strong><?= session()->get('username') ?? 'Admin' ?></strong></span>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php 
                                $avatar = session()->get('user_avatar');
                                $username = session()->get('username') ?? 'Admin';
                                $avatarUrl = !empty($avatar) ? '/' . $avatar : 'https://ui-avatars.com/api/?name='.urlencode($username).'&background=28a745&color=fff';
                            ?>
                            <img src="<?= $avatarUrl ?>" width="35" height="35" class="rounded-circle border" style="object-fit: cover;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="/admin/profile"><i class="fas fa-user-edit me-2 text-muted"></i> Edit Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt me-2 text-danger"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main Content (Scrollable) -->
            <div class="flex-grow-1 p-4 bg-light overflow-auto">
                <?= $this->renderSection('content') ?>
            </div>

            <!-- Footer -->
            <footer class="bg-white py-3 border-top mt-auto">
                <div class="container text-center">
                    <span class="text-muted small">&copy; <?= date('Y') ?> Hidroganik Alfa. All rights reserved.</span>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("sidebarToggle").addEventListener("click", function(){
            document.getElementById("wrapper").classList.toggle("toggled");
        });
    </script>
</html>
