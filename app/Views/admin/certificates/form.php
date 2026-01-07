<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        <a href="/admin/certificates" class="btn btn-secondary">
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

            <form action="<?= isset($certificate) ? '/admin/certificates/update/' . $certificate['id'] : '/admin/certificates/store' ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Sertifikat</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= isset($certificate) ? $certificate['title'] : old('title') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Singkat</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= isset($certificate) ? $certificate['description'] : old('description') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Sertifikat</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" <?= isset($certificate) ? '' : 'required' ?>>
                    <?php if(isset($certificate) && $certificate['image_path']): ?>
                        <div class="mt-2">
                            <img src="/<?= $certificate['image_path'] ?>" alt="Preview" height="150" class="img-thumbnail">
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
