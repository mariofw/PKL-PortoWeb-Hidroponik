<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class Services extends BaseController
{
    public function index()
    {
        $model = new ServiceModel();
        $data['services'] = $model->findAll();
        return view('admin/services/index', $data);
    }

    public function new()
    {
        return view('admin/services/form', ['action' => 'create']);
    }

    public function create()
    {
        $model = new ServiceModel();
        $data = $this->request->getPost();

        // Validation
        $title = trim($data['title'] ?? '');
        $description = trim($data['description'] ?? '');

        if (empty($title)) {
            return redirect()->back()->withInput()->with('error', 'Judul wajib diisi');
        }
        if (str_word_count($title) > 15) {
            return redirect()->back()->withInput()->with('error', 'Judul tidak boleh lebih dari 15 kata');
        }

        if (empty($description)) {
            return redirect()->back()->withInput()->with('error', 'Deskripsi wajib diisi');
        }
        if (str_word_count($description) > 100) {
            return redirect()->back()->withInput()->with('error', 'Deskripsi tidak boleh lebih dari 100 kata');
        }
        
        $imagePath = null;
        $croppedImage = $this->request->getPost('cropped_image');
        if (!empty($croppedImage)) {
            $imagePath = $this->_saveBase64Image($croppedImage);
        } else {
            $file = $this->request->getFile('image');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads', $newName);
                $imagePath = 'uploads/' . $newName;
            }
        }

        if (!$imagePath) {
            return redirect()->back()->withInput()->with('error', 'Gambar wajib diunggah');
        }

        $data['icon_image'] = $imagePath;
        unset($data['cropped_image']);
        $model->insert($data);
        return redirect()->to('/admin/services')->with('message', 'Layanan berhasil ditambahkan');
    }

    public function edit($id = null)
    {
        $model = new ServiceModel();
        $data['service'] = $model->find($id);
        $data['action'] = 'edit';
        return view('admin/services/form', $data);
    }

    public function update($id = null)
    {
        $model = new ServiceModel();
        $data = $this->request->getPost();

        // Validation
        $title = trim($data['title'] ?? '');
        $description = trim($data['description'] ?? '');

        if (empty($title)) {
            return redirect()->back()->withInput()->with('error', 'Title is required');
        }
        if (str_word_count($title) > 15) {
            return redirect()->back()->withInput()->with('error', 'Title cannot exceed 15 words');
        }

        if (empty($description)) {
            return redirect()->back()->withInput()->with('error', 'Description is required');
        }
        if (str_word_count($description) > 100) {
            return redirect()->back()->withInput()->with('error', 'Description cannot exceed 100 words');
        }

        $newImageUploaded = false;

        $croppedImage = $this->request->getPost('cropped_image');
        if (!empty($croppedImage)) {
            $imagePath = $this->_saveBase64Image($croppedImage);
            if ($imagePath) {
                $data['icon_image'] = $imagePath;
                $newImageUploaded = true;
            }
        } else {
            $file = $this->request->getFile('image');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads', $newName);
                $data['icon_image'] = 'uploads/' . $newName;
                $newImageUploaded = true;
            }
        }

        if ($newImageUploaded) {
            $existing = $model->find($id);
            if ($existing && !empty($existing['icon_image']) && file_exists(FCPATH . $existing['icon_image'])) {
                @unlink(FCPATH . $existing['icon_image']);
            }
        }

        unset($data['cropped_image']);
        $model->update($id, $data);
        return redirect()->to('/admin/services')->with('message', 'Service updated');
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
        $uploadPath = FCPATH . 'uploads';

        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0777, true);
        }
        
        $filePath = $uploadPath . '/' . $newName;
        if (file_put_contents($filePath, $decodedData)) {
            return 'uploads/' . $newName;
        }
        
        return null;
    }

    public function delete($id = null)
    {
        $model = new ServiceModel();
        $service = $model->find($id);

        if ($service) {
            if (!empty($service['icon_image']) && file_exists(FCPATH . $service['icon_image'])) {
                @unlink(FCPATH . $service['icon_image']);
            }
            
            $model->delete($id);
            return redirect()->to('/admin/services')->with('message', 'Service deleted');
        }

        return redirect()->to('/admin/services')->with('error', 'Service not found');
    }
}
