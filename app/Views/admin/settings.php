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
                        <input type="text" name="site_title" class="form-control" value="<?= esc($settings['site_title'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label>Logo</label>
                        <div class="mb-2">
                            <img src="<?= isset($settings['site_logo']) && !empty($settings['site_logo']) ? '/'.esc($settings['site_logo']) : '' ?>" id="site_logo_preview" style="max-height: 50px; display: <?= isset($settings['site_logo']) && !empty($settings['site_logo']) ? 'block' : 'none' ?>;">
                        </div>
                        <input type="file" name="site_logo" class="form-control image-cropper-input"
                               data-hidden-input-id="cropped_site_logo"
                               data-preview-id="site_logo_preview"
                               data-aspect-ratio="1/1">
                        <input type="hidden" name="cropped_site_logo" id="cropped_site_logo">
                        <small class="text-muted">Pilih gambar untuk membuka cropper (rasio 1:1).</small>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header fw-bold">Social Media Links (Footer Kiri)</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label><i class="fab fa-facebook"></i> Facebook URL</label>
                        <input type="text" name="social_fb" class="form-control" value="<?= esc($settings['social_fb'] ?? '') ?>" placeholder="https://facebook.com/...">
                    </div>
                    <div class="mb-3">
                        <label><i class="fab fa-instagram"></i> Instagram URL</label>
                        <input type="text" name="social_ig" class="form-control" value="<?= esc($settings['social_ig'] ?? '') ?>" placeholder="https://instagram.com/...">
                    </div>
                    <div class="mb-3">
                        <label><i class="fab fa-youtube"></i> YouTube URL</label>
                        <input type="text" name="social_yt" class="form-control" value="<?= esc($settings['social_yt'] ?? '') ?>" placeholder="https://youtube.com/...">
                    </div>
                    <div class="mb-3">
                        <label><i class="fab fa-whatsapp"></i> WhatsApp URL (Link Chat)</label>
                        <input type="text" name="social_wa" class="form-control" value="<?= esc($settings['social_wa'] ?? '') ?>" placeholder="https://wa.me/62...">
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header fw-bold">Kontak Kami (Footer Kanan)</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label>Alamat / Lokasi</label>
                        <textarea name="contact_address" class="form-control" rows="2"><?= esc($settings['contact_address'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Nomor WhatsApp (Teks)</label>
                        <input type="text" name="contact_phone" class="form-control" value="<?= esc($settings['contact_phone'] ?? '') ?>" placeholder="0812-3456-7890">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="text" name="contact_email" class="form-control" value="<?= esc($settings['contact_email'] ?? '') ?>" placeholder="info@hidroganik.com">
                    </div>
                    <div class="mb-3">
                        <label>Nama Akun Instagram</label>
                        <input type="text" name="contact_ig_handle" class="form-control" value="<?= esc($settings['contact_ig_handle'] ?? '') ?>" placeholder="@hidroganikalfa">
                    </div>
                    <div class="mb-3">
                        <label>Jam Buka - Tutup</label>
                        <input type="text" name="contact_hours" class="form-control" value="<?= esc($settings['contact_hours'] ?? '') ?>" placeholder="Senin - Jumat: 08.00 - 17.00">
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
                        <textarea name="about_us_desc" class="form-control" rows="4"><?= esc($settings['about_us_desc'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <div class="mb-2">
                            <img src="<?= isset($settings['about_us_image']) && !empty($settings['about_us_image']) ? '/'.esc($settings['about_us_image']) : '' ?>" id="about_us_image_preview" style="max-height: 100px; display: <?= isset($settings['about_us_image']) && !empty($settings['about_us_image']) ? 'block' : 'none' ?>;">
                        </div>
                        <input type="file" name="about_us_image" class="form-control image-cropper-input"
                               data-hidden-input-id="cropped_about_us_image"
                               data-preview-id="about_us_image_preview"
                               data-aspect-ratio="1/1">
                        <input type="hidden" name="cropped_about_us_image" id="cropped_about_us_image">
                        <small class="text-muted">Pilih gambar untuk membuka cropper (rasio 1:1).</small>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header fw-bold">Owner Profile</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label>Owner Description</label>
                        <textarea name="owner_desc" class="form-control" rows="4"><?= esc($settings['owner_desc'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Owner Image</label>
                        <div class="mb-2">
                            <img src="<?= isset($settings['owner_image']) && !empty($settings['owner_image']) ? '/'.esc($settings['owner_image']) : '' ?>" id="owner_image_preview" style="max-height: 100px; display: <?= isset($settings['owner_image']) && !empty($settings['owner_image']) ? 'block' : 'none' ?>;">
                        </div>
                        <input type="file" name="owner_image" class="form-control image-cropper-input"
                               data-hidden-input-id="cropped_owner_image"
                               data-preview-id="owner_image_preview"
                               data-aspect-ratio="1/1">
                        <input type="hidden" name="cropped_owner_image" id="cropped_owner_image">
                        <small class="text-muted">Pilih gambar untuk membuka cropper (rasio 1:1).</small>
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