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
            padding-top: 70px; /* Offset for fixed navbar */
        }

        /* Navbar & Footer Override */
        .bg-hydro-dark {
            background-color: var(--hydro-dark) !important;
        }

        .navbar.bg-white .nav-link {
            color: var(--hydro-dark) !important;
            font-weight: 600;
            transition: color 0.3s, transform 0.2s ease;
            display: inline-block;
        }
        .navbar.bg-white .nav-link:hover {
            color: var(--hydro-accent) !important;
            transform: scale(1.08);
        }

        /* Navbar Dividers (Desktop) */
        @media (min-width: 992px) {
            .navbar-nav .nav-item .nav-link {
                border-right: 1px solid rgba(0,0,0,0.08);
                padding-right: 15px;
                padding-left: 15px;
            }
            .navbar-nav .nav-item:nth-last-child(2) .nav-link {
                border-right: none;
            }
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
            height: calc(100vh - 70px);
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

        /* Horizontal Scroll Services */
        .service-scroll-container {
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 20px;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none;  /* IE 10+ */
        }
        .service-scroll-container::-webkit-scrollbar {
            display: none; /* Chrome/Safari/Webkit */
        }
        
        /* Scroll Buttons */
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            border: 1px solid var(--hydro-main);
            color: var(--hydro-main);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }
        .scroll-btn:hover {
            background-color: var(--hydro-main);
            color: white;
        }
        .scroll-btn.left { left: -15px; }
        .scroll-btn.right { right: -15px; }
        
        @media (max-width: 768px) {
            .scroll-btn { display: none; } /* Hide buttons on mobile, touch is better */
        }

        /* Article Hover Effect */
        .article-card {
            position: relative;
            height: auto;
            aspect-ratio: 4 / 5;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s;
        }
        .article-card:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .article-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s;
        }
        .article-card:hover .article-img {
            transform: scale(1.1);
        }
        .article-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            background: linear-gradient(to top, rgba(0,0,0,0.9), rgba(27, 94, 32, 0.8), transparent);
            color: white;
            transform: translateY(65%); /* Only show Title initially */
            transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }
        .article-card:hover .article-overlay {
            transform: translateY(0);
            background: linear-gradient(to top, rgba(27, 94, 32, 0.95), rgba(27, 94, 32, 0.8));
            justify-content: center;
        }
        .article-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 5px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.6);
        }
        .article-hidden-content {
            opacity: 0;
            transition: opacity 0.3s ease 0.1s;
            height: 0;
            overflow: hidden;
        }
        .article-card:hover .article-hidden-content {
            opacity: 1;
            height: auto;
            margin-top: 15px;
        }

        /* Services Redesign */
        .service-card {
            position: relative;
            width: 100%;
            aspect-ratio: 1/1;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .service-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .service-card:hover .service-img {
            transform: scale(1.1);
        }
        .service-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(27, 94, 32, 0.85); /* Dark Green Overlay */
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
            text-align: center;
        }
        .service-card:hover .service-overlay {
            opacity: 1;
        }
        .service-desc {
            font-size: 0.95rem;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-hydro" href="#">
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
                    <li class="nav-item"><a class="nav-link" href="#competency">Ujikom</a></li>
                    <li class="nav-item"><a class="nav-link" href="#partners">Partner</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contribution">Kontribusi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#articles">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="#location-title">Lokasi</a></li>
                    <?php if(session()->get('is_logged_in')): ?>
                        <li class="nav-item"><a class="btn btn-success ms-2 fw-bold text-white" href="/admin">Dashboard</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="btn btn-outline-success ms-2" href="/login">Login</a></li>
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
                        <img src="/<?= $settings['about_us_image'] ?>" class="img-fluid rounded shadow border border-success border-2" style="aspect-ratio: 1/1; object-fit: cover; width: 100%;">
                    <?php else: ?>
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="height: 300px;">No Image</div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h3 class="text-hydro fw-bold">Hidroganik Alfa</h3>
                    <p class="lead text-secondary" style="text-align: justify;"><?= nl2br($settings['about_us_desc'] ?? 'Deskripsi belum diatur.') ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi & Profil Section (White Background) -->
    <section class="bg-white">
        <div class="container">
            <!-- Visi Misi -->
            <div class="row mb-5">
                <div class="col-md-6 mb-4 mb-md-0">
                     <div class="h-100 p-4 bg-white rounded shadow-lg border-top border-4 border-success">
                        <h4 class="text-hydro fw-bold mb-3 text-center"><i class="fas fa-eye me-2"></i> Visi</h4>
                        <p class="text-secondary" style="line-height: 1.8; text-align: justify;">
                            <?= nl2br($settings['visi'] ?? 'Visi belum diatur.') ?>
                        </p>
                     </div>
                </div>
                <div class="col-md-6">
                     <div class="h-100 p-4 bg-white rounded shadow-lg border-top border-4 border-success">
                        <h4 class="text-hydro fw-bold mb-3 text-center"><i class="fas fa-bullseye me-2"></i> Misi</h4>
                        <div class="text-secondary" style="line-height: 1.8; text-align: justify;">
                            <?= nl2br($settings['misi'] ?? 'Misi belum diatur.') ?>
                        </div>
                     </div>
                </div>
            </div>

            <div class="row align-items-center p-4 bg-white rounded shadow-lg border-start border-4 border-success">
                <div class="col-md-4 order-md-2 text-center">
                    <?php if(isset($settings['owner_image'])): ?>
                        <img src="/<?= $settings['owner_image'] ?>" class="img-fluid rounded-circle shadow border border-4 border-success" style="max-width: 220px; width: 100%; aspect-ratio: 1/1; object-fit: cover;">
                    <?php endif; ?>
                </div>
                <div class="col-md-8 order-md-1">
                    <h3 class="text-hydro fw-bold mb-3">Profil Pemilik</h3>
                    <p class="text-secondary" style="line-height: 1.8; text-align: justify;"><?= nl2br($settings['owner_desc'] ?? 'Profil pemilik belum diatur.') ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Competency Test Section (Sertifikat) -->
    <section id="competency" class="bg-hydro-light">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Uji Kompetensi</h2>
                <p class="text-muted mb-5">Sertifikasi dan pencapaian yang telah kami raih.</p>
            </div>
            
            <div class="row justify-content-center">
                <?php if(!empty($certificates)): ?>
                    <?php foreach($certificates as $cert): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden certificate-card position-relative">
                            <div class="certificate-img-wrapper position-relative">
                                <img src="/<?= $cert['image_path'] ?>" class="w-100 h-100 object-fit-cover" alt="<?= $cert['title'] ?>">
                                
                                <!-- Hover Overlay for Description -->
                                <div class="certificate-overlay">
                                    <div class="text-white text-center p-3">
                                        <?php if(!empty($cert['description'])): ?>
                                            <p class="mb-0 small fw-bold"><?= $cert['description'] ?></p>
                                        <?php else: ?>
                                             <i class="fas fa-search-plus fa-2x"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center bg-white p-3">
                                <h5 class="card-title fw-bold text-hydro mb-0" style="font-size: 1.1rem;"><?= $cert['title'] ?></h5>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">Belum ada sertifikat yang ditampilkan.</div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <style>
        .certificate-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .certificate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
        }
        .certificate-img-wrapper {
            width: 100%;
            aspect-ratio: 1/1;
            overflow: hidden;
        }
        .object-fit-cover {
            object-fit: cover;
        }
        .certificate-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(27, 94, 32, 0.85); /* Hydro Dark with opacity */
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .certificate-card:hover .certificate-overlay {
            opacity: 1;
        }
    </style>

    <!-- Partners Section -->
    <section id="partners" class="bg-white">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Partner Kami</h2>
                <p class="text-muted mb-5">Bekerja sama dengan berbagai instansi dan komunitas.</p>
            </div>
            
            <div class="row justify-content-center align-items-center">
                <?php if(!empty($partners)): ?>
                    <?php foreach($partners as $partner): ?>
                    <div class="col-6 col-md-3 mb-4">
                        <div class="partner-item">
                            <img src="/<?= $partner['logo_path'] ?>" class="img-fluid partner-logo" alt="<?= $partner['name'] ?>">
                            <span class="partner-name"><?= $partner['name'] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">Belum ada partner yang ditambahkan.</div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <style>
        .partner-item {
            position: relative;
            text-align: center;
            padding: 20px;
            transition: all 0.3s;
            cursor: pointer;
        }
        .partner-logo {
            filter: grayscale(100%);
            opacity: 0.7;
            transition: all 0.4s ease;
            max-height: 100px;
            width: auto;
        }
        .partner-item:hover .partner-logo {
            filter: grayscale(0%);
            opacity: 1;
            transform: scale(1.1);
        }
        .partner-name {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: var(--hydro-main);
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        .partner-item:hover .partner-name {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <!-- Services -->
    <section id="services" class="bg-hydro-light">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Layanan Kami</h2>
            </div>
            <!-- Horizontal Scroll Container -->
            <div class="position-relative px-2">
                <button class="scroll-btn left" onclick="scrollServices('left')"><i class="fas fa-chevron-left"></i></button>
                
                <div class="service-scroll-container d-flex pb-4" id="serviceContainer">
                    <?php foreach($services as $service): ?>
                    <!-- col-10 (mobile) and col-md-4 (desktop) with flex-shrink-0 to prevent wrapping -->
                    <div class="col-10 col-md-4 flex-shrink-0 me-4">
                        <div class="service-card mb-3">
                            <?php if($service['icon_image']): ?>
                                <img src="/<?= $service['icon_image'] ?>" class="service-img" alt="<?= $service['title'] ?>">
                            <?php else: ?>
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">No Image</div>
                            <?php endif; ?>
                            
                            <div class="service-overlay">
                                <p class="service-desc mb-0"><?= $service['description'] ?></p>
                            </div>
                        </div>
                        <h4 class="text-hydro fw-bold text-center"><?= $service['title'] ?></h4>
                    </div>
                    <?php endforeach; ?>
                </div>

                <button class="scroll-btn right" onclick="scrollServices('right')"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

    <!-- Contribution Section (SDGs & Green Economy) -->
    <section id="contribution" class="bg-white py-5">
        <div class="container">
            <!-- Header -->
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">Kontribusi Kami Pada SDGs & Green Economy</h2>
            </div>

            <div class="row g-4">
                <!-- Left Column: Poin-Poin SDGs (Dark Green Box) -->
                <div class="col-lg-6">
                    <div class="p-4 rounded-4 h-100 position-relative" style="background-color: #1b5e20; min-height: 400px;">
                        <h4 class="text-center text-white fw-bold mb-4">Poin-Poin SDGs</h4>
                        
                        <div class="row g-3">
                            <div class="col-4">
                                <div class="sdg-card bg-white rounded-2 p-1 h-100 d-flex align-items-center justify-content-center overflow-hidden position-relative">
                                    <img src="/uploads/poin2sdg.gif" class="img-fluid w-100" alt="SDG 2">
                                    <div class="sdg-overlay">
                                        <p class="sdg-text">Mendukung ketahanan pangan melalui sistem pertanian yang sehat dan berkelanjutan.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="sdg-card bg-white rounded-2 p-1 h-100 d-flex align-items-center justify-content-center overflow-hidden position-relative">
                                    <img src="/uploads/poin3sdg.gif" class="img-fluid w-100" alt="SDG 3">
                                    <div class="sdg-overlay">
                                        <p class="sdg-text">Produk bebas pestisida kimia berbahaya, menjaga kesehatan konsumen dan lingkungan.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="sdg-card bg-white rounded-2 p-1 h-100 d-flex align-items-center justify-content-center overflow-hidden position-relative">
                                    <img src="/uploads/poin6sdg.gif" class="img-fluid w-100" alt="SDG 6">
                                    <div class="sdg-overlay">
                                        <p class="sdg-text">Sistem hidroponik menghemat hingga 90% penggunaan air dibanding pertanian konvensional.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="sdg-card bg-white rounded-2 p-1 h-100 d-flex align-items-center justify-content-center overflow-hidden position-relative">
                                    <img src="/uploads/poin11sdg.gif" class="img-fluid w-100" alt="SDG 11">
                                    <div class="sdg-overlay">
                                        <p class="sdg-text">Memanfaatkan lahan sempit di perkotaan menjadi area produktif dan hijau.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="sdg-card bg-white rounded-2 p-1 h-100 d-flex align-items-center justify-content-center overflow-hidden position-relative">
                                    <img src="/uploads/poin12sdg.gif" class="img-fluid w-100" alt="SDG 12">
                                    <div class="sdg-overlay">
                                        <p class="sdg-text">Mengurangi limbah rumah tangga dengan memanfaatkannya sebagai media tanam.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="sdg-card bg-white rounded-2 p-1 h-100 d-flex align-items-center justify-content-center overflow-hidden position-relative">
                                    <img src="/uploads/poin13sdg.gif" class="img-fluid w-100" alt="SDG 13">
                                    <div class="sdg-overlay">
                                        <p class="sdg-text">Mengurangi jejak karbon melalui pertanian lokal dan distribusi yang lebih singkat.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <style>
                    .sdg-card {
                        cursor: pointer;
                    }
                    .sdg-overlay {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(27, 94, 32, 0.95); /* Deep Green */
                        color: white;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        text-align: center;
                        padding: 5px;
                        opacity: 0;
                        transition: opacity 0.3s ease;
                    }
                    .sdg-card:hover .sdg-overlay {
                        opacity: 1;
                    }
                    .sdg-text {
                        font-size: 0.65rem;
                        line-height: 1.2;
                        margin: 0;
                        font-weight: 500;
                    }
                    @media (min-width: 992px) {
                        .sdg-text { font-size: 0.7rem; }
                    }
                </style>

                <!-- Right Column: Green Economy (White) -->
                <div class="col-lg-6">
                    <div class="p-4 h-100">
                        <h4 class="text-center text-dark fw-bold mb-4">Green Economy</h4>
                        
                        <div class="row g-3">
                            <div class="col-4">
                                <div class="card border-0 shadow-sm h-100 d-flex align-items-center justify-content-center p-2 rounded-3 hover-up">
                                    <img src="/uploads/5.%20Efiensi%20Energi.png" class="img-fluid" alt="Efisiensi Energi">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card border-0 shadow-sm h-100 d-flex align-items-center justify-content-center p-2 rounded-3 hover-up">
                                    <img src="/uploads/1.%20PRODUK%20BERKELANJUTAN.png" class="img-fluid" alt="Produk Berkelanjutan">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card border-0 shadow-sm h-100 d-flex align-items-center justify-content-center p-2 rounded-3 hover-up">
                                    <img src="/uploads/3.%20Pemberdayaan%20Masyarakat.png" class="img-fluid" alt="Pemberdayaan Masyarakat">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card border-0 shadow-sm h-100 d-flex align-items-center justify-content-center p-2 rounded-3 hover-up">
                                    <img src="/uploads/4.%20Penghijauaan%20Kota.png" class="img-fluid" alt="Penghijauan Kota">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card border-0 shadow-sm h-100 d-flex align-items-center justify-content-center p-2 rounded-3 hover-up">
                                    <img src="/uploads/2.%20PRODUK%20RAMAH%20LINGKUNGAN.png" class="img-fluid" alt="Ramah Lingkungan">
                                </div>
                            </div>
                             <div class="col-4">
                                <div class="card border-0 shadow-sm h-100 d-flex align-items-center justify-content-center p-2 rounded-3 hover-up">
                                    <img src="/uploads/6.%20inovasi%20berbasis%20limba.png" class="img-fluid" alt="Inovasi Limbah">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .hover-up { transition: transform 0.3s ease, box-shadow 0.3s ease; }
            .hover-up:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        </style>
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
                    <div class="article-card">
                        <?php if($article['image_path']): ?>
                            <img src="/<?= $article['image_path'] ?>" class="article-img">
                        <?php endif; ?>
                        
                        <div class="article-overlay">
                            <h5 class="article-title"><?= $article['title'] ?></h5>
                            
                            <div class="article-hidden-content">
                                <p class="small mb-3 text-warning">
                                    <i class="fas fa-user me-1"></i> <?= $article['author'] ?> &nbsp;|&nbsp; 
                                    <i class="fas fa-calendar me-1"></i> <?= date('d M Y', strtotime($article['created_at'])) ?>
                                </p>
                                <p class="small text-light mb-4"><?= substr(strip_tags($article['content']), 0, 100) ?>...</p>
                                
                                <?php if(isset($article['link_type']) && $article['link_type'] === 'external'): ?>
                                    <a href="<?= $article['external_url'] ?>" target="_blank" class="btn btn-outline-light btn-sm rounded-pill px-4">Buka Berita <i class="fas fa-external-link-alt ms-1"></i></a>
                                <?php else: ?>
                                    <a href="/article/<?= $article['slug'] ?>" class="btn btn-outline-light btn-sm rounded-pill px-4">Baca Selengkapnya</a>
                                <?php endif; ?>
                            </div>
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
        <div style="width: 100%; height: 500px;">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3983.062409999398!2d114.5989818!3d-3.3347579!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de421bf7aef995f%3A0x594092a02701e3dd!2sHidroganik%20Alfa!5e0!3m2!1sid!2sid!4v1767675115801!5m2!1sid!2sid" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <!-- Spacer between Map and Footer -->
    <div class="bg-white py-5"></div>

    <!-- Footer -->
    <footer class="bg-hydro-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <h4 class="mb-2 fw-bold"><?= $settings['site_title'] ?? 'Hidroganik Alfa' ?></h4>
                    <p class="text-white-50 small">Solusi hidroponik terbaik untuk kebutuhan pertanian modern Anda. Menyediakan sayuran segar, instalasi, dan pelatihan.</p>
                    
                    <div class="mt-2">
                        <a href="<?= $settings['social_fb'] ?? '#' ?>" target="_blank" class="text-white me-3 fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="<?= $settings['social_ig'] ?? '#' ?>" target="_blank" class="text-white me-3 fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="<?= $settings['social_yt'] ?? '#' ?>" target="_blank" class="text-white me-3 fs-5"><i class="fab fa-youtube"></i></a>
                        <a href="<?= $settings['social_wa'] ?? '#' ?>" target="_blank" class="text-white fs-5"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="col-md-2"></div>

                <div class="col-md-5 mb-3">
                    <h5 class="mb-3 text-white border-bottom border-success d-inline-block pb-1">Kontak Kami</h5>
                    <ul class="list-unstyled text-white-50 small">
                        <li class="mb-1 d-flex">
                            <i class="fas fa-map-marker-alt mt-1 me-2 text-success"></i>
                            <span><?= nl2br($settings['contact_address'] ?? 'Alamat belum diatur') ?></span>
                        </li>
                        <li class="mb-1">
                            <i class="fab fa-whatsapp me-2 text-success"></i>
                            <?= $settings['contact_phone'] ?? '-' ?>
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-envelope me-2 text-success"></i>
                            <?= $settings['contact_email'] ?? '-' ?>
                        </li>
                        <li class="mb-1">
                            <i class="fab fa-instagram me-2 text-success"></i>
                            <?= $settings['contact_ig_handle'] ?? '-' ?>
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-clock me-2 text-success"></i>
                            <?= $settings['contact_hours'] ?? '-' ?>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary mt-3 mb-3">
            <div class="text-center text-white-50 small">
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
        function scrollServices(direction) {
            const container = document.getElementById('serviceContainer');
            const scrollAmount = 350; // Adjust scroll distance
            
            if (direction === 'left') {
                container.scrollLeft -= scrollAmount;
            } else {
                container.scrollLeft += scrollAmount;
            }
        }

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