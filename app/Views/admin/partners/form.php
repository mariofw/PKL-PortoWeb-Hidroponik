<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        <a href="/admin/partners" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= isset($partner) ? '/admin/partners/update/' . $partner['id'] : '/admin/partners/store' ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Partner</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= isset($partner) ? $partner['name'] : old('name') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">Logo Partner (Gambar)</label>
                    <div class="mb-2">
                        <img src="<?= isset($partner) && $partner['logo_path'] ? '/'.esc($partner['logo_path']) : '' ?>" id="logo_preview" style="max-height: 100px; display: <?= isset($partner) && $partner['logo_path'] ? 'block' : 'none' ?>;" class="img-thumbnail">
                    </div>
                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*"
                           onchange="document.getElementById('logo_preview').src = window.URL.createObjectURL(this.files[0]); document.getElementById('logo_preview').style.display = 'block';">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
