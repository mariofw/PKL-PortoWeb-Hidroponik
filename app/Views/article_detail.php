<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $article['title'] ?> - <?= $settings['site_title'] ?? 'Hidroganik Alfa' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --hydro-dark: #1b5e20;   
            --hydro-main: #2e7d32;   
            --hydro-light: #e8f5e9;  
            --hydro-accent: #4caf50; 
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333;
            background-color: #f9f9f9;
        }

        .bg-hydro-dark { background-color: var(--hydro-dark) !important; }
        .text-hydro { color: var(--hydro-main); }
        
        .article-header {
            background-color: var(--hydro-light);
            padding: 100px 0 50px;
            margin-bottom: 30px;
        }

        .article-content {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .article-img {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    
    <!-- Navbar (Same as Home) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-hydro-dark fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <?php if(isset($settings['site_logo'])): ?>
                    <img src="/<?= $settings['site_logo'] ?>" height="35" class="d-inline-block align-top me-2" alt="">
                <?php endif; ?>
                <?= $settings['site_title'] ?? 'Hidroganik Alfa' ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/#about">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="/#services">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="/#articles">Artikel</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="article-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold text-hydro"><?= $article['title'] ?></h1>
            <p class="text-muted mt-3">
                <i class="fas fa-user me-2"></i> <?= $article['author'] ?> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <i class="fas fa-calendar me-2"></i> <?= date('d F Y', strtotime($article['created_at'])) ?>
            </p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <article class="article-content">
                    <?php if($article['image_path']): ?>
                        <img src="/<?= $article['image_path'] ?>" class="article-img shadow-sm" alt="<?= $article['title'] ?>">
                    <?php endif; ?>
                    
                    <div class="content-body">
                        <?= nl2br($article['content']) ?>
                    </div>

                    <div class="mt-5 pt-4 border-top">
                        <a href="/#articles" class="btn btn-outline-success"><i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Artikel</a>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-hydro-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mb-4">
                    <h4 class="mb-3 fw-bold"><?= $settings['site_title'] ?? 'Hidroganik Alfa' ?></h4>
                    <p class="text-white-50">Solusi hidroponik terbaik untuk kebutuhan pertanian modern Anda. Menyediakan sayuran segar, instalasi, dan pelatihan.</p>
                    
                    <div class="mt-4">
                        <a href="<?= $settings['social_fb'] ?? '#' ?>" target="_blank" class="text-white me-3 fs-4"><i class="fab fa-facebook"></i></a>
                        <a href="<?= $settings['social_ig'] ?? '#' ?>" target="_blank" class="text-white me-3 fs-4"><i class="fab fa-instagram"></i></a>
                        <a href="<?= $settings['social_yt'] ?? '#' ?>" target="_blank" class="text-white me-3 fs-4"><i class="fab fa-youtube"></i></a>
                        <a href="<?= $settings['social_wa'] ?? '#' ?>" target="_blank" class="text-white fs-4"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="col-md-2"></div>

                <div class="col-md-5 mb-4">
                    <h5 class="mb-4 text-white border-bottom border-success d-inline-block pb-2">Kontak Kami</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-3 d-flex">
                            <i class="fas fa-map-marker-alt mt-1 me-3 text-success"></i>
                            <span><?= nl2br($settings['contact_address'] ?? 'Alamat belum diatur') ?></span>
                        </li>
                        <li class="mb-3">
                            <i class="fab fa-whatsapp me-3 text-success"></i>
                            <?= $settings['contact_phone'] ?? '-' ?>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope me-3 text-success"></i>
                            <?= $settings['contact_email'] ?? '-' ?>
                        </li>
                        <li class="mb-3">
                            <i class="fab fa-instagram me-3 text-success"></i>
                            <?= $settings['contact_ig_handle'] ?? '-' ?>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock me-3 text-success"></i>
                            <?= $settings['contact_hours'] ?? '-' ?>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary mt-4">
            <div class="text-center pt-3 text-white-50 small">
                <p class="mb-0">&copy; <?= date('Y') ?> <?= $settings['site_title'] ?? 'Hidroganik Alfa' ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Floating Contact Button -->
    <div class="floating-contact-container">
        <div class="contact-list" id="contactList">
            <?php if(!empty($settings['social_wa'])): ?>
                <a href="<?= $settings['social_wa'] ?>" target="_blank" class="contact-item bg-success" title="Chat WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            <?php endif; ?>
            
            <?php if(!empty($settings['social_ig'])): ?>
                <a href="<?= $settings['social_ig'] ?>" target="_blank" class="contact-item" style="background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            <?php endif; ?>

            <?php if(!empty($settings['contact_email'])): ?>
                <a href="mailto:<?= $settings['contact_email'] ?>" class="contact-item bg-primary" title="Kirim Email">
                    <i class="fas fa-envelope"></i>
                </a>
            <?php endif; ?>
            
            <?php if(!empty($settings['contact_phone'])): ?>
                <a href="tel:<?= $settings['contact_phone'] ?>" class="contact-item bg-secondary text-white" title="Telepon">
                    <i class="fas fa-phone"></i>
                </a>
            <?php endif; ?>
        </div>
        
        <button class="main-fab shadow" onclick="toggleContact()" id="mainFab">
            <i class="fas fa-comments"></i>
            <i class="fas fa-times" style="display: none;"></i>
        </button>
    </div>

    <style>
        .floating-contact-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .main-fab {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background-color: var(--hydro-main);
            color: white;
            border: none;
            font-size: 26px;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .main-fab:hover {
            transform: scale(1.1);
            background-color: var(--hydro-dark);
        }
        .contact-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }
        .contact-list.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .contact-item {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            transition: transform 0.2s;
        }
        .contact-item:hover {
            transform: scale(1.1);
            color: white;
        }
    </style>

    <script>
        function toggleContact() {
            const list = document.getElementById('contactList');
            const btn = document.getElementById('mainFab');
            const iconComment = btn.querySelector('.fa-comments');
            const iconClose = btn.querySelector('.fa-times');
            
            if (list.classList.contains('show')) {
                list.classList.remove('show');
                iconComment.style.display = 'block';
                iconClose.style.display = 'none';
            } else {
                list.classList.add('show');
                iconComment.style.display = 'none';
                iconClose.style.display = 'block';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
