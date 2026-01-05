<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $settings['site_title'] ?? 'Hidroganik Alfa' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --hydro-dark: #1b5e20;   /* Hijau Tua Hutan */
            --hydro-main: #2e7d32;   /* Hijau Daun Utama */
            --hydro-light: #e8f5e9;  /* Hijau Mint Sangat Muda (Background) */
            --hydro-accent: #4caf50; /* Hijau Cerah (Tombol/Icon) */
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333;
        }

        /* Navbar & Footer Override */
        .bg-hydro-dark {
            background-color: var(--hydro-dark) !important;
        }
        
        /* Section Background Override */
        .bg-hydro-light {
            background-color: var(--hydro-light) !important;
        }

        /* Text Colors */
        .text-hydro {
            color: var(--hydro-main);
        }

        /* Buttons */
        .btn-outline-light:hover {
            color: var(--hydro-dark);
        }
        .btn-primary, .btn-outline-primary {
            background-color: var(--hydro-main);
            border-color: var(--hydro-main);
            color: white;
        }
        .btn-primary:hover, .btn-outline-primary:hover {
            background-color: var(--hydro-dark);
            border-color: var(--hydro-dark);
        }
        .btn-outline-primary {
            background-color: transparent;
            color: var(--hydro-main);
        }

        .hero-img {
            height: 650px;
            object-fit: cover;
            filter: brightness(0.9); /* Sedikit gelap agar teks terbaca */
        }
        section {
            padding: 70px 0;
        }
        
        /* Carousel Caption Customization */
        .hydro-caption-box {
            background-color: rgba(27, 94, 32, 0.85); /* Hijau Transparan */
            border-radius: 10px;
            border-left: 5px solid var(--hydro-accent);
            text-align: left;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            
            /* Positioning */
            position: absolute;
            left: 8%; 
            right: auto; 
            bottom: 15%; 
            width: 500px; 
            max-width: 85%;
            max-height: 70%;
            overflow-y: auto;
        }

        .section-title {
            color: var(--hydro-dark);
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: var(--hydro-accent);
            margin: 10px auto 0;
        }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-hydro-dark fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
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
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#articles">Artikel</a></li>
                    <?php if(session()->get('is_logged_in')): ?>
                        <li class="nav-item"><a class="btn btn-light text-success ms-2 fw-bold" href="/admin">Dashboard</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="btn btn-outline-light ms-2" href="/login">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Carousel -->
    <header id="home">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach($sliders as $index => $slider): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <img src="/<?= $slider['image_path'] ?>" class="d-block w-100 hero-img" alt="<?= $slider['title'] ?>">
                    <div class="carousel-caption d-none d-md-block hydro-caption-box">
                        <h4 class="fw-bold mb-3 text-light"><?= $slider['title'] ?></h4>
                        <div style="font-size: 0.95rem; line-height: 1.6; color: #e8f5e9;">
                            <?= nl2br($slider['description']) ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </header>

    <!-- About Us -->
    <section id="about" class="bg-hydro-light">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Tentang Kami</h2>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <?php if(isset($settings['about_us_image'])): ?>
                        <img src="/<?= $settings['about_us_image'] ?>" class="img-fluid rounded shadow border border-success border-2">
                    <?php else: ?>
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="height: 300px;">No Image</div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h3 class="text-hydro fw-bold">Hidroganik Alfa</h3>
                    <p class="lead text-secondary"><?= nl2br($settings['about_us_desc'] ?? 'Deskripsi belum diatur.') ?></p>
                </div>
            </div>
            
            <div class="row align-items-center mt-5 p-4 bg-white rounded shadow-sm">
                <div class="col-md-4 order-md-2 text-center">
                    <?php if(isset($settings['owner_image'])): ?>
                        <img src="/<?= $settings['owner_image'] ?>" class="img-fluid rounded-circle shadow border border-4 border-success" style="width: 220px; height: 220px; object-fit: cover;">
                    <?php endif; ?>
                </div>
                <div class="col-md-8 order-md-1">
                    <h3 class="text-hydro fw-bold mb-3">Profil Pemilik</h3>
                    <p class="text-secondary" style="line-height: 1.8;"><?= nl2br($settings['owner_desc'] ?? 'Profil pemilik belum diatur.') ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="bg-white">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Layanan Kami</h2>
            </div>
            <div class="row">
                <?php foreach($services as $service): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center p-4 shadow border-0 hover-shadow bg-hydro-light">
                        <?php if($service['icon_image']): ?>
                            <img src="/<?= $service['icon_image'] ?>" class="mx-auto mb-3" height="80" style="object-fit: contain;">
                        <?php endif; ?>
                        <h4 class="text-hydro fw-bold"><?= $service['title'] ?></h4>
                        <p class="text-muted"><?= $service['description'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Articles -->
    <section id="articles" class="bg-hydro-light">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Artikel Tentang Kami</h2>
            </div>
            <div class="row">
                <?php foreach($articles as $article): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow border-0 overflow-hidden">
                        <?php if($article['image_path']): ?>
                            <img src="/<?= $article['image_path'] ?>" class="card-img-top" style="height: 220px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-dark"><?= $article['title'] ?></h5>
                            <p class="text-success small mb-2"><i class="fas fa-user me-1"></i> <?= $article['author'] ?> &nbsp;|&nbsp; <i class="fas fa-calendar me-1"></i> <?= date('d M Y', strtotime($article['created_at'])) ?></p>
                            
                            <?php if(isset($article['link_type']) && $article['link_type'] === 'external'): ?>
                                <p class="card-text text-secondary">Baca berita lengkap di situs sumber...</p>
                                <a href="<?= $article['external_url'] ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-4">Buka Berita <i class="fas fa-external-link-alt ms-1"></i></a>
                            <?php else: ?>
                                <p class="card-text text-secondary"><?= substr($article['content'], 0, 100) ?>...</p>
                                <a href="/article/<?= $article['slug'] ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4">Baca Selengkapnya</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Location & Map Section -->
    <section id="location-title" class="bg-white pb-0">
        <div class="container text-center">
            <h2 class="section-title">Kunjungi Kebun Kami</h2>
            <p class="lead text-secondary mt-n4 mb-5">Datang dan lihat langsung proses penanaman hidroponik yang sehat dan higienis.</p>
        </div>
    </section>

    <section id="location" class="position-relative p-0">
        <!-- Google Maps Embed -->
        <div style="width: 100%; height: 500px; overflow: hidden;">
            <iframe 
                src="https://maps.google.com/maps?q=Hidroganik+Alfa&t=&z=17&ie=UTF8&iwloc=&output=embed" 
                width="100%" 
                height="600" 
                style="border:0; margin-top: -50px;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>

        <!-- Floating Review Card (Desktop) -->
        <div class="card position-absolute top-0 start-0 m-4 shadow border-0 d-none d-md-block" style="width: 350px; z-index: 1000; background: rgba(255, 255, 255, 0.95);">
            <div class="card-body p-4">
                <h5 class="fw-bold text-hydro mb-1">Hidroganik Alfa</h5>
                <p class="small text-muted mb-2">Pertanian Hidroponik</p>
                
                <div class="d-flex align-items-center mb-3">
                    <span class="text-warning me-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                    <span class="fw-bold">5.0</span>
                    <span class="text-muted ms-1 small">(Ulasan Google)</span>
                </div>

                <p class="card-text small text-secondary mb-3">
                    <i class="fas fa-quote-left text-success me-2"></i>
                    Tempat terbaik untuk belajar dan membeli sayuran hidroponik segar. Pelayanan sangat ramah dan edukatif.
                </p>

                <div class="d-grid gap-2">
                    <a href="https://www.google.com/maps/place/Hidroganik+Alfa/@-3.3347579,114.6015621,17z" target="_blank" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-map-marked-alt me-1"></i> Lihat di Google Maps
                    </a>
                    <a href="https://www.google.com/maps/place/Hidroganik+Alfa/@-3.3347579,114.6015621,17z" target="_blank" class="btn btn-link text-decoration-none btn-sm text-secondary">
                        Lihat semua ulasan
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile Info Block (Visible only on Mobile) -->
        <div class="bg-white p-4 d-block d-md-none text-center border-top">
            <h5 class="fw-bold text-hydro">Hidroganik Alfa</h5>
            <div class="text-warning mb-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> (5.0)</div>
            <a href="https://www.google.com/maps/place/Hidroganik+Alfa/@-3.3347579,114.6015621,17z" target="_blank" class="btn btn-success w-100">
                Buka di Google Maps
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-hydro-dark text-white py-5">
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