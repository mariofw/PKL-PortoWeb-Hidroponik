<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h3>General Settings</h3>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<form action="/admin/settings" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header fw-bold">Branding & Logo</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label>Site Title</label>
                        <input type="text" name="site_title" class="form-control" value="<?= $settings['site_title'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label>Logo</label>
                        <?php if(isset($settings['site_logo'])): ?>
                            <div class="mb-2"><img src="/<?= $settings['site_logo'] ?>" height="50"></div>
                        <?php endif; ?>
                        <input type="file" name="site_logo" class="form-control">
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header fw-bold">Social Media Links (Footer Kiri)</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label><i class="fab fa-facebook"></i> Facebook URL</label>
                        <input type="text" name="social_fb" class="form-control" value="<?= $settings['social_fb'] ?? '' ?>" placeholder="https://facebook.com/...">
                    </div>
                    <div class="mb-3">
                        <label><i class="fab fa-instagram"></i> Instagram URL</label>
                        <input type="text" name="social_ig" class="form-control" value="<?= $settings['social_ig'] ?? '' ?>" placeholder="https://instagram.com/...">
                    </div>
                    <div class="mb-3">
                        <label><i class="fab fa-youtube"></i> YouTube URL</label>
                        <input type="text" name="social_yt" class="form-control" value="<?= $settings['social_yt'] ?? '' ?>" placeholder="https://youtube.com/...">
                    </div>
                    <div class="mb-3">
                        <label><i class="fab fa-whatsapp"></i> WhatsApp URL (Link Chat)</label>
                        <input type="text" name="social_wa" class="form-control" value="<?= $settings['social_wa'] ?? '' ?>" placeholder="https://wa.me/62...">
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header fw-bold">Kontak Kami (Footer Kanan)</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label>Alamat / Lokasi</label>
                        <textarea name="contact_address" class="form-control" rows="2"><?= $settings['contact_address'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Nomor WhatsApp (Teks)</label>
                        <input type="text" name="contact_phone" class="form-control" value="<?= $settings['contact_phone'] ?? '' ?>" placeholder="0812-3456-7890">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="text" name="contact_email" class="form-control" value="<?= $settings['contact_email'] ?? '' ?>" placeholder="info@hidroganik.com">
                    </div>
                    <div class="mb-3">
                        <label>Nama Akun Instagram</label>
                        <input type="text" name="contact_ig_handle" class="form-control" value="<?= $settings['contact_ig_handle'] ?? '' ?>" placeholder="@hidroganikalfa">
                    </div>
                    <div class="mb-3">
                        <label>Jam Buka - Tutup</label>
                        <input type="text" name="contact_hours" class="form-control" value="<?= $settings['contact_hours'] ?? '' ?>" placeholder="Senin - Jumat: 08.00 - 17.00">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header fw-bold">About Us Section</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="about_us_desc" class="form-control" rows="4"><?= $settings['about_us_desc'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <?php if(isset($settings['about_us_image'])): ?>
                            <div class="mb-2"><img src="/<?= $settings['about_us_image'] ?>" height="100"></div>
                        <?php endif; ?>
                        <input type="file" name="about_us_image" class="form-control">
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header fw-bold">Owner Profile</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label>Owner Description</label>
                        <textarea name="owner_desc" class="form-control" rows="4"><?= $settings['owner_desc'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Owner Image</label>
                        <?php if(isset($settings['owner_image'])): ?>
                            <div class="mb-2"><img src="/<?= $settings['owner_image'] ?>" height="100"></div>
                        <?php endif; ?>
                        <input type="file" name="owner_image" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-grid gap-2 mb-5">
        <button type="submit" class="btn btn-primary btn-lg">Save All Settings</button>
    </div>
</form>
<?= $this->endSection() ?>