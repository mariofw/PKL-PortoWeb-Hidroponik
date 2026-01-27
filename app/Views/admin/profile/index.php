<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Akun Admin</h6>
                </div>
                <div class="card-body">
                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <?php if(session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="/admin/profile/update" method="post" enctype="multipart/form-data">
                        <div class="row mb-4 align-items-center">
                            <div class="col-md-4 text-center">
                                <div class="mb-3">
                                    <?php 
                                        $avatarPath = '/'.($user['avatar'] ?? 'default-avatar.png'); // Fallback to a default
                                        $previewSrc = !empty($user['avatar']) ? '/'.esc($user['avatar']) : '';
                                        $previewDisplay = !empty($user['avatar']) ? 'block' : 'none';
                                    ?>
                                    <img src="<?= $previewSrc ?>" id="avatar_preview" class="img-thumbnail rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover; display: <?= $previewDisplay ?>;">
                                </div>
                                <div class="mb-3">
                                    <label for="avatar" class="form-label small text-muted">Ganti Foto Profil</label>
                                    <input type="file" class="form-control form-control-sm image-cropper-input" id="avatar" name="avatar" accept="image/*"
                                           data-hidden-input-id="cropped_avatar_data"
                                           data-preview-id="avatar_preview"
                                           data-aspect-ratio="1/1">
                                    <input type="hidden" name="cropped_avatar" id="cropped_avatar_data">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user['username']) ?>" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="font-weight-bold text-secondary mb-3">Ganti Password (Opsional)</h6>
                        <p class="small text-muted mb-3">Kosongkan jika tidak ingin mengganti password.</p>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" autocomplete="new-password">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
