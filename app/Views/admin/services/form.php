<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h3><?= ucfirst($action) ?> Service</h3>

<form action="<?= $action === 'edit' ? '/admin/services/'.$service['id'] : '/admin/services' ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?php if($action === 'edit'): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

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
        <?php if(isset($service['icon_image'])): ?>
            <div class="mb-2"><img src="/<?= $service['icon_image'] ?>" height="100"></div>
        <?php endif; ?>
        <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
<?= $this->endSection() ?>
