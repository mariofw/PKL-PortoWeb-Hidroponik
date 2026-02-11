<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h3><?= ucfirst($action) ?> Slider</h3>

<form action="<?= $action === 'edit' ? '/admin/sliders/update/'.$slider['id'] : '/admin/sliders/create' ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label>Order Index</label>
        <input type="number" name="order_index" class="form-control" value="<?= $slider['order_index'] ?? 0 ?>">
    </div>
    <div class="mb-3">
        <label>Image</label>
        <?php 
            $imagePath = $slider['image_path'] ?? '';
            $previewSrc = !empty($imagePath) ? "/".$imagePath : '';
            $previewDisplay = !empty($imagePath) ? 'block' : 'none';
        ?>
        <div class="mb-2">
            <img src="<?= $previewSrc ?>" id="image_preview" style="max-height: 100px; display: <?= $previewDisplay ?>;">
        </div>
        
        <input type="file" name="image" class="form-control image-cropper-input" 
               data-hidden-input-id="cropped_image_data" 
               data-preview-id="image_preview"
               data-aspect-ratio="16/9">
        
        <input type="hidden" name="cropped_image" id="cropped_image_data">

        <small class="text-muted">Pilih gambar untuk membuka cropper. Rekomendasi rasio 16:9.</small>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
<?= $this->endSection() ?>
