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
        <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
        <div id="croppedResult" class="mt-2" style="display:none;">
            <p class="text-success small"><i class="fas fa-check-circle"></i> Image Cropped Ready to Upload</p>
            <img id="previewResult" src="" height="100" class="border rounded">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>

<!-- Cropper Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="imageToCrop" src="" style="max-width: 100%; display: block;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="cropBtn">Crop</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('imageInput');
        const imageToCrop = document.getElementById('imageToCrop');
        const cropBtn = document.getElementById('cropBtn');
        const cropModalEl = document.getElementById('cropModal');
        const cropModal = new bootstrap.Modal(cropModalEl);
        const croppedResult = document.getElementById('croppedResult');
        const previewResult = document.getElementById('previewResult');
        let cropper;
        let originalFiles; // Store original files if cancelled

        imageInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                
                // Validate if it is an image
                if (!file.type.startsWith('image/')) { 
                    return; 
                }

                // Store original files incase needed
                originalFiles = files;

                const url = URL.createObjectURL(file);
                imageToCrop.src = url;
                
                // Show Modal
                cropModal.show();
            }
        });

        cropModalEl.addEventListener('shown.bs.modal', function () {
            cropper = new Cropper(imageToCrop, {
                aspectRatio: 1, // Square for services
                viewMode: 2,
                autoCropArea: 1,
            });
        });

        cropModalEl.addEventListener('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            imageToCrop.src = "";
            // If closed without cropping (and no result yet), could reset input or leave as is.
            // But we will handle "Crop" action specifically.
        });

        cropBtn.addEventListener('click', function() {
            if (cropper) {
                cropper.getCroppedCanvas({
                    width: 500, // Reasonable max width for icons
                    height: 500,
                }).toBlob(function(blob) {
                    // Create a new File object
                    const newFile = new File([blob], 'cropped_image.jpg', { type: 'image/jpeg', lastModified: new Date().getTime() });

                    // Create a DataTransfer to get a FileList
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(newFile);

                    // Update the file input
                    imageInput.files = dataTransfer.files;

                    // Show preview
                    previewResult.src = URL.createObjectURL(blob);
                    croppedResult.style.display = 'block';

                    // Hide modal
                    cropModal.hide();
                }, 'image/jpeg', 0.9);
            }
        });
    });
</script>
<?= $this->endSection() ?>
