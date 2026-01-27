<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h3><?= ucfirst($action) ?> Article</h3>

<form action="<?= $action === 'edit' ? '/admin/articles/update/'.$article['id'] : '/admin/articles/store' ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?= $article['title'] ?? '' ?>" required>
            </div>
            
            <div class="mb-3">
                <label>Article Type</label>
                <select name="link_type" id="link_type" class="form-select">
                    <option value="internal" <?= (isset($article['link_type']) && $article['link_type'] == 'internal') ? 'selected' : '' ?>>Write Article (Internal)</option>
                    <option value="external" <?= (isset($article['link_type']) && $article['link_type'] == 'external') ? 'selected' : '' ?>>Link to News (External)</option>
                </select>
            </div>

            <div class="mb-3" id="external_url_group" style="display: none;">
                <label>External URL (Link Berita)</label>
                <input type="url" name="external_url" class="form-control" placeholder="https://example.com/news/..." value="<?= $article['external_url'] ?? '' ?>">
            </div>

            <div class="mb-3" id="content_group">
                <label>Content</label>
                <textarea name="content" class="form-control" rows="10"><?= $article['content'] ?? '' ?></textarea>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label>Author</label>
                <input type="text" name="author" class="form-control" value="<?= $article['author'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label>Cover Image</label>
                <div class="mb-2">
                    <img src="<?= isset($article['image_path']) && $article['image_path'] ? '/'.esc($article['image_path']) : '' ?>" id="image_preview" style="max-width: 100%; display: <?= isset($article['image_path']) && $article['image_path'] ? 'block' : 'none' ?>;" class="img-fluid rounded">
                </div>
                <input type="file" name="image" class="form-control image-cropper-input"
                       data-hidden-input-id="cropped_image_data"
                       data-preview-id="image_preview"
                       data-aspect-ratio="4/5">
                <input type="hidden" name="cropped_image" id="cropped_image_data">
                <small class="text-muted">Pilih gambar untuk membuka cropper (rasio 4:5).</small>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('link_type');
        const urlGroup = document.getElementById('external_url_group');
        const contentGroup = document.getElementById('content_group');

        function toggleFields() {
            if (typeSelect.value === 'external') {
                urlGroup.style.display = 'block';
                contentGroup.style.display = 'none';
            } else {
                urlGroup.style.display = 'none';
                contentGroup.style.display = 'block';
            }
        }

        typeSelect.addEventListener('change', toggleFields);
        toggleFields(); // Run on load
    });
</script>
<?= $this->endSection() ?>