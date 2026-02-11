<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h3><?= ucfirst($action) ?> Service</h3>

<form action="<?= $action === 'edit' ? '/admin/services/update/'.$service['id'] : '/admin/services' ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="<?= $service['title'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"><?= $service['description'] ?? '' ?></textarea>
    </div>
    <div class="mb-3">
        <label>Icon/Image</label>
        <div class="mb-2">
            <img src="<?= isset($service['icon_image']) && $service['icon_image'] ? '/'.esc($service['icon_image']) : '' ?>" id="image_preview" style="max-height: 100px; display: <?= isset($service['icon_image']) && $service['icon_image'] ? 'block' : 'none' ?>;">
        </div>
        <input type="file" name="image" class="form-control image-cropper-input" accept="image/*"
               data-hidden-input-id="cropped_image_data"
               data-preview-id="image_preview"
               data-aspect-ratio="1/1">
        <input type="hidden" name="cropped_image" id="cropped_image_data">
        <small class="text-muted">Pilih gambar untuk membuka cropper (rasio 1:1).</small>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
<?= $this->endSection() ?>
