<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CertificateModel;

class Certificates extends BaseController
{
    protected $certificateModel;

    public function __construct()
    {
        $this->certificateModel = new CertificateModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Sertifikat Kompetensi',
            'certificates' => $this->certificateModel->findAll()
        ];
        return view('admin/certificates/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Sertifikat',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/certificates/form', $data);
    }

    public function create()
    {
        $rules = [
            'title' => 'required|min_length[3]',
            'image' => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,15360]',
        ];

        if (!$this->validate($rules) && empty($this->request->getPost('cropped_image'))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ];

        $imagePath = null;
        $croppedImage = $this->request->getPost('cropped_image');
        if (!empty($croppedImage)) {
            $imagePath = $this->_saveBase64Image($croppedImage);
        } else {
            $img = $this->request->getFile('image');
            if ($img && $img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move(ROOTPATH . 'public/uploads', $newName);
                $imagePath = 'uploads/' . $newName;
            }
        }

        if ($imagePath) {
            $data['image_path'] = $imagePath;
        } else {
             return redirect()->back()->withInput()->with('errors', ['image' => 'Image is required.']);
        }

        $this->certificateModel->save($data);

        return redirect()->to('/admin/certificates')->with('success', 'Sertifikat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $certificate = $this->certificateModel->find($id);
        if (!$certificate) {
            return redirect()->to('/admin/certificates')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Sertifikat',
            'certificate' => $certificate,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/certificates/form', $data);
    }

    public function update($id)
    {
        $certificate = $this->certificateModel->find($id);
        if (!$certificate) {
            return redirect()->to('/admin/certificates')->with('error', 'Data tidak ditemukan');
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'image' => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,15360]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ];
        
        $imagePath = null;
        $newImageUploaded = false;
        $croppedImage = $this->request->getPost('cropped_image');

        if (!empty($croppedImage)) {
            $imagePath = $this->_saveBase64Image($croppedImage);
            $newImageUploaded = true;
        } else {
            $img = $this->request->getFile('image');
            if ($img && $img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move(ROOTPATH . 'public/uploads', $newName);
                $imagePath = 'uploads/' . $newName;
                $newImageUploaded = true;
            }
        }

        if ($newImageUploaded && $imagePath) {
            // Delete old image if exists
            if (!empty($certificate['image_path']) && file_exists(ROOTPATH . 'public/' . $certificate['image_path'])) {
                @unlink(ROOTPATH . 'public/' . $certificate['image_path']);
            }
            $data['image_path'] = $imagePath;
        }

        $this->certificateModel->save($data);

        return redirect()->to('/admin/certificates')->with('success', 'Sertifikat berhasil diperbarui');
    }

    private function _saveBase64Image($base64String) {
        if (empty($base64String) || strpos($base64String, 'data:image') !== 0) {
            return null;
        }
        
        list($type, $data) = explode(';', $base64String);
        list(, $data)      = explode(',', $data);
        $decodedData = base64_decode($data);

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->buffer($decodedData);
        $extensions = [
            'image/jpeg' => 'jpg', 'image/png'  => 'png', 'image/gif'  => 'gif', 'image/webp' => 'webp'
        ];
        $extension = $extensions[$mime_type] ?? 'jpg';
        
        $newName = bin2hex(random_bytes(10)) . '.' . $extension;
        $uploadPath = ROOTPATH . 'public/uploads';

        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0777, true);
        }
        
        $filePath = $uploadPath . '/' . $newName;
        if (file_put_contents($filePath, $decodedData)) {
            return 'uploads/' . $newName;
        }
        
        return null;
    }

    public function delete($id)
    {
        $certificate = $this->certificateModel->find($id);
        if ($certificate) {
            if (!empty($certificate['image_path']) && file_exists(ROOTPATH . 'public/' . $certificate['image_path'])) {
                unlink(ROOTPATH . 'public/' . $certificate['image_path']);
            }
            $this->certificateModel->delete($id);
        }
        return redirect()->to('/admin/certificates')->with('success', 'Sertifikat berhasil dihapus');
    }
}
