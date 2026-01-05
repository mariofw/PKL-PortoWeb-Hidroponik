<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard Overview</h2>
        <div class="text-muted"><?= date('l, d F Y') ?></div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 display-4"><i class="fas fa-users"></i></div>
                    <div>
                        <h5 class="card-title mb-0">Total Pengunjung</h5>
                        <p class="display-6 fw-bold mb-0"><?= number_format($total_visitors) ?></p>
                        <small>Sepanjang waktu</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card bg-warning text-dark shadow h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 display-4"><i class="fas fa-chart-line"></i></div>
                    <div>
                        <h5 class="card-title mb-0">Pengunjung Hari Ini</h5>
                        <p class="display-6 fw-bold mb-0"><?= number_format($today_visitors) ?></p>
                        <small>Hits unik hari ini</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">
            <i class="fas fa-compass me-2 text-success"></i> Menu Cepat
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <a href="/admin/sliders" class="btn btn-outline-success w-100 py-3">
                        <i class="fas fa-images fa-2x mb-2"></i><br>Sliders
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="/admin/services" class="btn btn-outline-success w-100 py-3">
                        <i class="fas fa-leaf fa-2x mb-2"></i><br>Layanan
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="/admin/articles" class="btn btn-outline-success w-100 py-3">
                        <i class="fas fa-newspaper fa-2x mb-2"></i><br>Artikel
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="/admin/settings" class="btn btn-outline-success w-100 py-3">
                        <i class="fas fa-cogs fa-2x mb-2"></i><br>Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome for Icons in Dashboard -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<?= $this->endSection() ?>